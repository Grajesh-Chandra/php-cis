<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF; // Import the TCPDF class
use Illuminate\Support\Facades\Log; // Import the Log facade

class GeneratePdfController extends Controller
{
    public function generatePdf()
    {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laravel TCPDF Example');
        $pdf->SetSubject('TCPDF PDF Generation in Laravel');
        $pdf->SetKeywords('TCPDF, PDF, Laravel, example');

        // Remove header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // Set font
        $pdf->SetFont('dejavusans', '', 10);

        // Add a page
        $pdf->AddPage();

        // Set some content to print
        $html = view('pdf.document')->render(); // Render a Blade template for the PDF content

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // Output directly to browser
        $pdf->Output('laravel_tcpdf_example.pdf', 'I');
        exit; // Terminate script execution to prevent further output
    }

    public function downloadPdf()
    {
        // --- PDF Download Generation (New method) ---
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document properties
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laravel TCPDF Example (Download)');
        $pdf->SetSubject('TCPDF PDF Generation in Laravel (Download)');
        $pdf->SetKeywords('TCPDF, PDF, Laravel, example, download');

        // Disable header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page break
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set language (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // Set font
        $pdf->SetFont('dejavusans', '', 10);

        // Add a page
        $pdf->AddPage();

        // Render HTML content from Blade view
        $html = view('pdf.document')->render();
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Output PDF to browser (download)
        $pdf->Output('laravel_tcpdf_example_download.pdf', 'D'); // 'D' for download
        exit; // Terminate script execution
    }
}
