<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function tenant()
{
    return \App\Models\Central\Tenant::factory()->create();
}

function createTenantWithDatabase()
{
    $tenant = tenant();
    $tenant->createDatabase();
    $tenant->run(function () {
        artisan()->call('migrate', [
            '--database' => 'pgsql_tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
    });

    return $tenant;
}
