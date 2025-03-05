<?php

namespace App\Http\Controllers;

use TCPDF;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GeneratePdfController extends Controller
{
    private function generateBasePdf()
    {
        try {
            Log::info('Starting PDF generation');

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Basic PDF configuration
            $pdf->SetCreator(config('app.name'));
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('PDF with JSON Attachment');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Use built-in font instead of dejavusans
            $pdf->SetFont('helvetica', '', 10);

            $pdf->AddPage();

            // Add content
            $html = view('pdf.document')->render();
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            Log::info('PDF generation completed successfully');

            return $pdf;
        } catch (\Exception $e) {
            Log::error('Base PDF Generation Error: ' . $e->getMessage());
            throw $e; // Re-throw for handling in parent method
        }
    }

    public function generatePdfWithAttachment()
    {
        $inputPdf = null;
        $outputPdf = null;

        try {
            // Generate base PDF first
            $pdf = $this->generateBasePdf();

            // Temporary file paths
            $tempDir = storage_path('app/temp/');

            // Create directory if not exists with proper permissions
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
                Log::info('Temp directory created: ' . $tempDir);
            } else {
                Log::info('Temp directory already exists: ' . $tempDir);
            }

            $inputPdf = $tempDir . 'base.pdf';
            $outputPdf = $tempDir . 'with_attachment.pdf';

            Log::info('Attempting to save base PDF to: ' . $inputPdf);
            $pdf->Output($inputPdf, 'F');
            Log::info('Output() command executed.');

            if (!file_exists($inputPdf)) {
                Log::error('file_exists() check failed for: ' . $inputPdf);
                throw new \Exception("Failed to save base PDF at: $inputPdf");
            } else {
                Log::info('file_exists() check passed for: ' . $inputPdf);
                Log::info('Base PDF saved successfully at: ' . $inputPdf);
            }

            // Verify JSON file exists
            $jsonPath = public_path('attachments/address.json');
            if (!file_exists($jsonPath)) {
                throw new \Exception("JSON file not found at: $jsonPath");
            }

            // Python script path validation
            $pythonScript = base_path('public/scripts/attach_file.py');
            if (!file_exists($pythonScript)) {
                throw new \Exception("Python script not found at: $pythonScript");
            }

            // Build process command
            $process = new Process([
                base_path('.venv/bin/python3'), // Using base_path() for absolute path
                $pythonScript,
                $inputPdf,
                $jsonPath,
                $outputPdf
            ]);

            $process->setTimeout(30);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Verify output file creation
            if (!file_exists($outputPdf)) {
                throw new \Exception("Python script failed to create output PDF");
            }

            // Return modified PDF
            return response()->download($outputPdf, 'document_with_attachment.pdf', [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            // Cleanup temporary files
            foreach ([$inputPdf, $outputPdf] as $file) {
                if ($file && file_exists($file)) {
                    @unlink($file);
                }
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

    // Keep original methods for compatibility
    public function generatePdf()
    {
        $inputPdf = null;

        try {
            // Generate base PDF first
            $pdf = $this->generateBasePdf();

            // Temporary file paths
            $tempDir = storage_path('app/temp/');

            // Create directory if not exists with proper permissions
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0775, true);
                Log::info('Temp directory created: ' . $tempDir);
            } else {
                Log::info('Temp directory already exists: ' . $tempDir);
            }

            $inputPdf = $tempDir . 'base.pdf';

            Log::info('Attempting to save base PDF to: ' . $inputPdf);
            $pdf->Output($inputPdf, 'F');
            Log::info('Output() command executed.');

            if (!file_exists($inputPdf)) {
                Log::error('file_exists() check failed for: ' . $inputPdf);
                throw new \Exception("Failed to save base PDF at: $inputPdf");
            } else {
                Log::info('file_exists() check passed for: ' . $inputPdf);
                Log::info('Base PDF saved successfully at: ' . $inputPdf);
            }

            // Return PDF inline
            $pdfContent = file_get_contents($inputPdf);

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="document.pdf"');
        } catch (\Exception $e) {
            // Cleanup temporary files
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
}
