<?php

use App\Models\Central\Tenant;

test('can create a tenant', function () {
    $tenant = Tenant::create([
        'id' => 'test-tenant',
        'name' => 'Test Company',
        'slug' => 'test-company',
        'email' => 'test@company.com',
        'status' => 'active',
    ]);

    expect($tenant)->toBeInstanceOf(Tenant::class)
        ->and($tenant->name)->toBe('Test Company')
        ->and($tenant->slug)->toBe('test-company')
        ->and($tenant->status)->toBe('active');
});

test('tenant has domains relationship', function () {
    $tenant = Tenant::factory()->create();

    $domain = $tenant->domains()->create([
        'domain' => 'test.helply.test',
        'is_primary' => true,
    ]);

    expect($tenant->domains)->toHaveCount(1)
        ->and($domain->domain)->toBe('test.helply.test');
});

test('tenant can have subscriptions', function () {
    $tenant = Tenant::factory()->create();

    expect($tenant->subscriptions())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('tenant slug must be unique', function () {
    Tenant::factory()->create(['slug' => 'unique-slug']);

    expect(fn () => Tenant::factory()->create(['slug' => 'unique-slug']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});
