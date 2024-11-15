<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

//$testopen = openssl_pkey_get_private('file://pk.pem');
// $testopen = openssl_pkey_get_private("-----BEGIN PRIVATE KEY-----
// MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDNheD6lDvuhYn+
// a+k8+3+bKePvq2VdOzZUINcHmfWQHZxw9rGmqAnEnl4jkl2m0jXE+9epEV3HhcZv
// 6rPhZ5Mr04YEGIVTkuJ6C+xMTLNcw7/APj+GL591wcRBKxeire3uafHvamZNOFX6
// O8yQxiQEdaANe9FqFuUBlP83R7DyK1BO4kLUrDyBuKl1InrmkyJgJUvigBQtq7JV
// /i0soUmebZUNhWjhLvmEW9TUw3Pt+dZ73vcmUqTSeG9vC6HM01k6xo5Hhi1UboJG
// nhdeUzeMlANOQr04TFriaXBJX1UxkrBAqBSQWRd+QzK2OIkp8NdV72zCPMj4OTtA
// Vrgu+gWxAgMBAAECggEAAVUx7U4SyWwyReUbQRr8a9wsrzw0TxN4Oblwy4rTDdkz
// T4Q6CLOkRJMmVyK22sMYOCvN7TnAmu+iJs2l1vtd9/XKM7KZAr68G0CCisggjaRz
// VOLSdKNQbGoSRL3rzFFGbrpfKEdPXIbV/+ZtYC74wtKkdBHufLqjR4xYz1n2qstc
// I1RU5iJtZePH4W458h3GC0NdU8w9tP9tlEuMfccjEWRD3I7CXPIJSoSX/g+qusut
// w2aUgYE1xBvQve4MMvdqcBaNRN4GQejbZ7sggVk/xSJM5tztrXagGjzdPFD0G33z
// WYIGhzFAC5xBbsgN/aj6z0WN0KrM97jzWr6UsS2mFQKBgQDnc9fzy/FvLjlvI5UI
// XXR/k4ERPQVK4gB2okGr28+ByzLCHx+tw4zgpQqZ7HQOR5f0woDyoCIM4X2H/5u9
// KING24IIuUAXgZBGutriBoXhCa1FplAAzeUHMWwutJ1JPLYmE87nEfSMEBYZZlBF
// 7NP/67QrA0zjphVs4396mfQNEwKBgQDjUgX0ZoANlkAee6cfNFtghLcmEY+Qh9Kk
// E27uJRJTQKhMtptjWaC//htQMprRMUek1qz7cBLqRY/GdZZdtM7suQZDpZa5tBRB
// NxzREN9WR9QL3Q64kMWOM7hNhPueD1SA3RyemtY/A/sT3l8QNeby+MUksx8ZaRQZ
// PPR+LdDOqwKBgDRgq9s5KO7/J/I1vDFDbOy+BbRP+dWjZXVzbKcmvEPkJx11C6c4
// HLZtwwNoVi8xFntGVQYTJQGDOfQ/7Q+WjnbHkBrHSXDIWk0XVhdWYI+3r+WWKH62
// GYFSNugu6XU8bwAY9XanQo87yLSAyeO5H5TH02L0gT73Q9v7c8rb8jXPAoGAG2e/
// GgjldT3g+wvTSRrJzWgSoH9LfJQzW96P6BwGCo1n/N+i+iZLD/p1loSTT5cOWRwc
// fK+1SBMc00NH3oI21Ck2TR+AfWDtdDNNwRK0qjU8pjV/WdbySkOH+6iFoTed6288
// zQ5DuBMlyO5tLYoiDrbZJaSGokydxLEplLC3VMMCgYAuEsTB4UpM1KlDWrGK+Hnd
// 9x2hVoJyambh4jb6gVz5GjnfvKajl2qTr4nx2G5HH7nMqORmXu6J/EfRiSVh0M+Z
// LHKEK/cMRZPOqJriz4ZhF2UQ7xWW6IMd57vH8+/2lsGjM/Aq08ctxWhXsCf7bhvg
// WNGAv47Jcl7WthztyxyP2g==
// -----END PRIVATE KEY-----");
// dd($testopen);
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
