<?php

declare(strict_types=1);

use App\Http\Middleware\InitializeTenancyByPath;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes (Path-based)
|--------------------------------------------------------------------------
|
| Routes para tenants usando path-based routing:
| - /t/{tenant}/ - Dashboard do tenant
| - /t/{tenant}/... - Outras páginas do tenant
|
| O Filament Tenant Panel também usa estas rotas
|
*/

Route::prefix('t/{tenant}')
    ->middleware([
        'web',
        InitializeTenancyByPath::class,
    ])
    ->group(function () {
        // Redirecionar para o painel Filament
        Route::get('/', function () {
            return redirect('/t/'.tenant('slug'));
        });
    });
