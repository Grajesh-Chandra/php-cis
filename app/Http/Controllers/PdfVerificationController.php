<?php

namespace App\Http\Controllers;

use App\Providers\AffinidiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process; // Import Symfony Process

class PdfVerificationController extends Controller
{
    public function verify(Request $request)
    {
        Log::info('PDF verification request received', ['request' => $request->all()]);

        // Validate file upload and PDF type (same as before)
        if (!$request->hasFile('pdf_file') || !$request->file('pdf_file')->isValid()) {
            return response()->json(['error' => 'No PDF file uploaded or file is invalid.'], 400);
        }
        $pdfFile = $request->file('pdf_file');
        if ($pdfFile->getClientMimeType() !== 'application/pdf') {
            return response()->json(['error' => 'Uploaded file is not a PDF.'], 400);
        }

        $tempDir = storage_path('app/upload/');
        // Create directory if not exists with proper permissions
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
            Log::info('Temp directory created: ' . $tempDir);
        } else {
            Log::info('Temp directory already exists: ' . $tempDir);
        }

        // Remove spaces from the filename and replace with underscores
        $filename = str_replace(' ', '_', $pdfFile->getClientOriginalName());
        //Store the file
        $pdfFile->storeAs('upload', $filename);
        //Create the absolute path
        $pdfFilePath = storage_path('app/upload/' . $filename);
         // Check if the file exists after the move operation
        if (!is_file($pdfFilePath)) {
            Log::error('Failed to store the file at: ' . $pdfFilePath);
            return response()->json(['error' => 'Failed to store the uploaded PDF.'], 500);
        }

        try {
            // Path to your Python script (adjust if needed)
            $pythonScriptPath = base_path('public/scripts/pdf_extractor.py'); // Assuming pdf_extractor.py is in your project root

            // Construct command to execute Python script
            $command = [
                base_path('.venv/bin/python3'), // Or 'python' depending on your system setup
                $pythonScriptPath,
                //escapeshellarg($pdfFilePath) // Safely pass the file path
                $pdfFilePath
            ];

            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('Python script failed: ' . $process->getErrorOutput());
                return response()->json(['error' => 'Failed to process PDF using Python script.', 'python_error' => $process->getErrorOutput()], 500);
            }

            $pythonOutput = $process->getOutput();
            $extractionData = json_decode($pythonOutput, true);

            if ($extractionData === null && json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error: ' . json_last_error_msg() . ', Python Output: ' . $pythonOutput);
                return response()->json(['error' => 'Error decoding JSON response from Python script.', 'json_error' => json_last_error_msg()], 500);
            }
            if ($extractionData === null) { // Handle case where python script returns no valid JSON but no JSON error
                Log::error('Python script did not return valid JSON. Output: ' . $pythonOutput);
                return response()->json(['error' => 'Python script did not return valid JSON.'], 500);
            }

            // Log the extracted data
            // Log::info('PDF attachments ', ['attachments' => $extractionData['attachments'] ?? []]);

            // Check for PDFSignature.json and decode content
            $pdfSignatureContent = null;
            $hasPdfSignature = false;
            if (isset($extractionData['attachments']) && is_array($extractionData['attachments'])) {
                foreach ($extractionData['attachments'] as $attachment) {
                    if (isset($attachment['filename']) && $attachment['filename'] === 'PDFSignature.json') {
                        $hasPdfSignature = true;
                        //check if exist content_base64
                        if (isset($attachment['content_base64'])) {
                            $pdfSignatureContent = base64_decode($attachment['content_base64']);

                            // Try to decode the content as JSON if it's not null
                            if ($pdfSignatureContent !== false) {
                                $decodedJsonContent = json_decode($pdfSignatureContent, true);

                                // Check if PDFSignature.json content was verified
                                $verifiedRequest = (['verifiableCredentials' => [$decodedJsonContent]]);
                                $verifiedResponse = AffinidiServices::Verification($verifiedRequest); //Using AffinidiServices::Verification to verify the signature

                                Log::info('PDFSignature.json verification response: ' . json_encode($verifiedResponse));
                                    if (isset($verifiedResponse['isValid']) && $verifiedResponse['isValid'] === true) {
                                    Log::info('PDFSignature.json verified successfully.');
                                    $credentials_expected_hash = $verifiedRequest['verifiableCredentials'][0]['credentialSubject']['hashWithoutAttachments'];
                                    $credentials_expected_orderid = $verifiedRequest['verifiableCredentials'][0]['credentialSubject']['orderId'];
                                    $credentials_expected = $verifiedRequest['verifiableCredentials'][0]['credentialSubject']['hashWithAttachment'];
                                    Log::info('PDFSignature.json verified successfully. Expected hash: ' . $credentials_expected_hash);
                                    Log::info('PDFSignature.json verified successfully. Expected orderid: ' . $credentials_expected_orderid);
                                    Log::info('PDFSignature.json verified successfully. Expected hashWithAttachment: ' . $credentials_expected);
                                } else {
                                    Log::error('PDFSignature.json verification failed.');
                                }
                                if (isset($verifiedResponse['error'])) {
                                    Log::error('Error verifying PDFSignature.json: ' . $verifiedResponse['error']);
                                    $pdfSignatureContent = "Error verifying PDFSignature.json: " . $verifiedResponse['error']; // Provide error message in output
                                } else {
                                    $pdfSignatureContent = $decodedJsonContent;
                                }
                                if ($decodedJsonContent === null && json_last_error() !== JSON_ERROR_NONE) {
                                    Log::error('Error decoding PDFSignature.json content: ' . json_last_error_msg());
                                    $pdfSignatureContent = "Error decoding PDFSignature.json: " . json_last_error_msg(); // Provide error message in output
                                } else {
                                    $pdfSignatureContent = $decodedJsonContent;
                                }
                            } else {
                                Log::error('Error base64 decoding PDFSignature.json content');
                                $pdfSignatureContent = "Error base64 decoding PDFSignature.json"; // Provide error message in output
                            }
                        } else {
                            Log::error('content_base64 not found on PDFSignature.json');
                            $pdfSignatureContent = "content_base64 not found";
                        }

                        break;
                    }
                }
            }
            if (!$hasPdfSignature) {
                Log::error('PDFSignature.json not found in attachments.');
                return response()->json(['error' => 'PDFSignature.json not found in attachments.'], 400);
            }

            // Compare expected hash with calculated hash

            if (isset($extractionData['pdf_content_hash']) && isset($credentials_expected_hash)) {
                if ($extractionData['pdf_content_hash'] === $credentials_expected_hash) {
                    Log::info('PDF content hash matches expected hash.');
                } else {
                    Log::error('PDF content hash does not match expected hash.');
                    return response()->json(['error' => 'PDF content hash does not match expected hash.'], 400);
                }
            } else {
                Log::error('PDF content hash or expected hash not found.');
                return response()->json(['error' => 'PDF content hash or expected hash not found.'], 400);
            }

            // Check credentials_expected value and check in attachments for "credentials_expected.json"
            $hasCredentialsExpected = false;
            $credentials_expected_content = null;
            if (isset($extractionData['attachments']) && is_array($extractionData['attachments']) && isset($credentials_expected)) {
                foreach ($extractionData['attachments'] as $attachment) {
                    if (isset($attachment['filename']) && $attachment['filename'] === $credentials_expected) {
                        $hasCredentialsExpected = true;
                        if (isset($attachment['content_base64'])) {
                            $credentials_expected_content = base64_decode($attachment['content_base64']);
                            if ($credentials_expected_content !== false) {
                                $decodedExpectedJsonContent = json_decode($credentials_expected_content, true);
                                if ($decodedExpectedJsonContent === null && json_last_error() !== JSON_ERROR_NONE) {
                                    Log::error('Error decoding ' . $credentials_expected . ' content: ' . json_last_error_msg());
                                    $credentials_expected_content = "Error decoding " . $credentials_expected . ": " . json_last_error_msg();
                                } else {
                                    $credentials_expected_content = $decodedExpectedJsonContent;
                                }
                                $verifiedExpectedRequest = (['verifiableCredentials' => [$decodedExpectedJsonContent]]);
                                $verifiedExpectedResponse = AffinidiServices::Verification($verifiedExpectedRequest);
                                Log::info($credentials_expected . ' verification response: ' . json_encode($verifiedExpectedResponse));
                                if (isset($verifiedExpectedResponse['isValid']) && $verifiedExpectedResponse['isValid'] === true) {
                                    Log::info($credentials_expected . ' verified successfully.');
                                } else {
                                    Log::error($credentials_expected . ' verification failed.');
                                }
                            } else {
                                Log::error('Error base64 decoding ' . $credentials_expected . ' content');
                                $credentials_expected_content = "Error base64 decoding " . $credentials_expected;
                            }
                        }
                    }
                }
            }
            if (!$hasCredentialsExpected) {
                Log::error($credentials_expected . ' not found in attachments.');
                return response()->json(['error' => $credentials_expected . ' not found in attachments.'], 400);
            }


            // Prepare the response with the extracted data
            return response()->json([
                'message' => 'PDF content and attachments extracted and verified successfully.',
                'pdf_content' => $extractionData['pdf_content'] ?? '',
                'attachments' => $extractionData['attachments'] ?? [],
                'pdf_content_hash' => $extractionData['pdf_content_hash'] ?? '',
                'credentials_expected_content' => $credentials_expected_content
            ]);
        } catch (\Exception $e) {
            Log::error('Error executing Python script or processing output: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Error processing PDF file.', 'details' => $e->getMessage()], 500);
        }
    }

    public function status(Request $request)
    {
        // Add your status checking logic here
        Log::info('PDF verification status check request received', ['request' => $request->all()]);

        // Example response
        return response()->json(['status' => 'PDF verification status']);
    }
}
