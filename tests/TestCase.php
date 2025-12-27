<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run central migrations for tests
        $this->artisan('migrate', [
            '--database' => 'pgsql',
            '--path' => 'database/migrations/central',
        ]);
    }
}
