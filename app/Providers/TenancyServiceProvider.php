<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Events\CreatingTenant;
use Stancl\Tenancy\Events\TenantCreated;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenancyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootEvents();
        $this->mapRoutes();
    }

    protected function bootEvents(): void
    {
        Event::listen(CreatingTenant::class, function (CreatingTenant $event) {
            // Set tenant database name
            $event->tenant->database = config('tenancy.database.prefix').$event->tenant->id;
        });

        Event::listen(TenantCreated::class, function (TenantCreated $event) {
            JobPipeline::make([
                CreateDatabase::class,
                MigrateDatabase::class,
            ])->send(fn() => $event->tenant)->dispatch();
        });
    }

    protected function mapRoutes(): void
    {
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::middleware([
                'web',
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
            ])->group(base_path('routes/tenant.php'));
        }
    }
}
