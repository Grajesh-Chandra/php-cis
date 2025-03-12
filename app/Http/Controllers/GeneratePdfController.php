<?php

namespace App\Http\Controllers;

use TCPDF;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use App\Providers\AffinidiServices;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
    private function generateBasePdf()
    {
        try {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(config('app.name'));
            $pdf->SetAuthor('Grajesh');
            $pdf->SetTitle('Final Check Report with Verifiable Credentials');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->AddPage();
            $html = view('pdf.document')->render();
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            return $pdf;
        } catch (\Exception $e) {
            Log::error('Base PDF Generation Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generatePdfWithAttachment()
    {
        $inputPdf = null;
        $outputPdf = null;
        $finalPdf = null;
        $tempDir = storage_path('app/temp/');

        try {
            $pdf = $this->generateBasePdf();

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $inputPdf = $tempDir . 'base.pdf';
            $finalPdf = $tempDir . 'final_with_attachments.pdf';

            $pdf->Output($inputPdf, 'F');
            if (!file_exists($inputPdf)) {
                throw new \Exception("Failed to save base PDF");
            }

            // Step1: Generate the PDF Signature and attach the signature to the PDF
            $pdfSignatureResponse = $this->hash_pdf_content_excluding_attachments();
            if ($pdfSignatureResponse->getStatusCode() !== 200) {
                throw new \Exception("Failed to generate PDF hash");
            }
            $pdfsignature = json_decode($pdfSignatureResponse->getContent(), true)['hash'];
            Log::info('PDF Signature generated successfully', ['signature' => $pdfsignature]);

            $walletId= config('services.affinidi_sign_credentials.walletId');
            $holderDID= config('services.affinidi_sign_credentials.holderDID');
            $pdf_signature_json= config('services.affinidi_sign_credentials.pdf_signature_json');
            $pdf_signature_jsonld= config('services.affinidi_sign_credentials.pdf_signature_jsonld');
            $pdf_signature_type_id= config('services.affinidi_sign_credentials.pdf_signature_type_id');

            $unsignedRequest = [
                "unsignedCredentialParams" => [
                    "jsonLdContextUrl" => $pdf_signature_jsonld,
                    "jsonSchemaUrl" => $pdf_signature_json,
                    "typeName" => $pdf_signature_type_id,
                    "credentialSubject" => [
                        "@type" => ["VerifiableCredential", "TpdfSignatureV1R0"],
                        "hashWithoutAttachments" => $pdfsignature,
                        "hashWithAttachment" => "personalInfo.json",
                        "orderId" => "123456",
                    ],
                    "holderDid" => $holderDID,
                    "expiresAt" => "2030-12-31T23:59:59Z",
                ]
            ];

            Log::info('Signing the PDF Signature', ['unsignedRequest' => $unsignedRequest]);

            $signedRequest = AffinidiServices::SignCredentials($walletId, $unsignedRequest);

            Log::info('PDF Signature signed successfully', ['signature' => $signedRequest]);

            if (!isset($signedRequest['signedCredential'])) {
                throw new \Exception("Failed to sign PDF Signature");
            }
            $signature = $signedRequest['signedCredential'];

            $attachmentsDir = public_path('attachments/');
            if (!file_exists($attachmentsDir)) {
                mkdir($attachmentsDir, 0755, true);
            }
            $signatureFileName = 'PDFSignature.json';
            $signatureFilePath = $attachmentsDir . $signatureFileName;

            file_put_contents($signatureFilePath, json_encode($signature, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            # step2: Attach the signature to the PDF
            $attachmentsDir = public_path('attachments/');
            $jsonFiles = glob($attachmentsDir . '*.json');

            if (empty($jsonFiles)) {
                throw new \Exception("No JSON files found");
            }

            $pythonScript = public_path('scripts/attach_file.py');
            if (!file_exists($pythonScript)) {
                throw new \Exception("Python script not found");
            }

            $processArguments = [
                base_path('.venv/bin/python3'),
                $pythonScript,
                $inputPdf,
                $finalPdf,
            ];
            foreach ($jsonFiles as $jsonPath) {
                $processArguments[] = $jsonPath;
            }

            $process = new Process($processArguments);
            $process->setTimeout(60);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('Python script failed: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }

            if (!file_exists($finalPdf)) {
                Log::error("Final PDF not created: $finalPdf");
                throw new \Exception("Final PDF not created: $finalPdf");
            }

            return response()->download($finalPdf, 'Verifiable_Report.pdf', [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            foreach ([$inputPdf, $outputPdf, $finalPdf] as $file) {
                if ($file && file_exists($file)) {
                    @unlink($file);
                }
            }
            $intermediateFiles = glob($tempDir . 'with_attachment_*.pdf');
            foreach ($intermediateFiles as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'PDF generation failed',
                'message' => $e->getMessage(),
                'details' => $e instanceof ProcessFailedException ? $e->getProcess()->getErrorOutput() : []
            ], 500);
        }
    }

    public function generatePdf()
    {
        $inputPdf = null;
        try {
            $pdf = $this->generateBasePdf();
            $tempDir = storage_path('app/temp/');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0775, true);
            }
            $inputPdf = $tempDir . 'base.pdf';
            $pdf->Output($inputPdf, 'F');
            if (!file_exists($inputPdf)) {
                throw new \Exception("Failed to save base PDF at: $inputPdf");
            }
            $pdfContent = file_get_contents($inputPdf);
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="document.pdf"');
        } catch (\Exception $e) {
            if ($inputPdf && file_exists($inputPdf)) {
                @unlink($inputPdf);
            }
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'PDF generation failed',
                'message' => $e->getMessage(),
                'details' => $e instanceof ProcessFailedException
                    ? $e->getProcess()->getErrorOutput()
                    : []
            ], 500);
        }
    }

    public function downloadPdf()
    {
        return $this->generatePdfWithAttachment();
    }

    public function hash_pdf_content_excluding_attachments()
    {
        $inputPdf = null;
        $tempDir = storage_path('app/temp/');
        try {
            // Generate base PDF (without attachments)
            $pdf = $this->generateBasePdf();

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            $inputPdf = $tempDir . 'base_hash_pdf.pdf';

            // Save the base PDF to a temporary file
            $pdf->Output($inputPdf, 'F');

            if (!file_exists($inputPdf)) {
                throw new \Exception("Failed to save base PDF for hashing");
            }

            // Get the content of the base PDF
            $pdfContent = file_get_contents($inputPdf);

            // Calculate the SHA256 hash of the PDF content
            $pdfHash = hash('sha256', $pdfContent);

            // Cleanup temporary PDF file
            if (file_exists($inputPdf)) {
                @unlink($inputPdf);
            }

            return response()->json([
                'hash' => $pdfHash,
            ]);
        } catch (\Exception $e) {
            // Cleanup temporary files in case of error
            if ($inputPdf && file_exists($inputPdf)) {
                @unlink($inputPdf);
            }

            Log::error('Error generating PDF hash: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate PDF hash',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
