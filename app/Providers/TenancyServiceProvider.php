<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events\TenancyInitialized;
use Stancl\Tenancy\Events\TenancyEnded;
use Stancl\Tenancy\Events\TenantCreated;
use Stancl\Tenancy\Events\CreatingTenant;
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
            $event->tenant->database = config('tenancy.database.prefix') . $event->tenant->id;
        });

        Event::listen(TenantCreated::class, function (TenantCreated $event) {
            // Create database
            $event->tenant->createDatabase();

            // Run migrations
            $event->tenant->run(function () {
                artisan()->call('migrate', [
                    '--database' => 'pgsql_tenant',
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);
            });
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
