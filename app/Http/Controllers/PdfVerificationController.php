<?php

namespace App\Http\Controllers;

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


            // Prepare the response with the extracted data
            return response()->json([
                'message' => 'PDF content and attachments extracted successfully.',
                'pdf_content' => $extractionData['pdf_content'] ?? '', // Use null coalescing operator to avoid errors if keys are missing
                'attachments' => $extractionData['attachments'] ?? [],
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
