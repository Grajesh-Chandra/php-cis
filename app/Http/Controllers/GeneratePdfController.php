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
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(config('app.name'));
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('PDF with JSON Attachment');
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
}
