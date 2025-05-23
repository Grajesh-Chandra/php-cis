<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\IotaController;
use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\PdfVerificationController;
use App\Http\Controllers\verificatonController;
use App\Http\Controllers\revocationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/issue-credential', [CredentialController::class, 'issueCredential']);
Route::post('/accept-credential-status', [CredentialController::class, 'acceptCredentialStatus']);
Route::post('/issued-credential', [CredentialController::class, 'IssuedCredential']);
Route::post('/iota-start', [IotaController::class, 'start']);
Route::post('/iota-complete', [IotaController::class, 'callback']);
Route::get('/generate-pdf', [GeneratePdfController::class, 'generatePdf'])->name('generate.pdf');
Route::get('/download-pdf', [GeneratePdfController::class, 'generatePdfWithAttachment'])->name('download.pdf');
Route::post('/verify-pdf', [PdfVerificationController::class, 'verify'])->name('verify.pdf');
Route::get('/verify-pdf-status', [PdfVerificationController::class, 'status'])->name('verify.pdf.status');
Route::post('/verify-credentials', [verificatonController::class, 'verifyCredentials']);
Route::post('/revoke-credentials', [revocationController::class, 'revokeCredential']);