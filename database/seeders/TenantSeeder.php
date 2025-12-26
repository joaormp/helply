<?php

namespace Database\Seeders;

use App\Models\Central\Plan;
use App\Models\Central\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Criar tenant demo apenas em ambiente local
        if (!app()->environment('local')) {
            return;
        }

        $plan = Plan::where('slug', 'professional')->first();

        // Tenant ACME
        $acme = Tenant::create([
            'id' => 'acme',
            'name' => 'ACME Corporation',
            'slug' => 'acme',
            'email' => 'admin@acme.com',
            'status' => 'active',
        ]);

        $acme->domains()->create([
            'domain' => 'acme.helply.test',
            'is_primary' => true,
        ]);

        if ($plan) {
            $acme->subscriptions()->create([
                'plan_id' => $plan->id,
                'status' => 'active',
                'billing_cycle' => 'monthly',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]);
        }

        // Tenant Globex
        $globex = Tenant::create([
            'id' => 'globex',
            'name' => 'Globex Corporation',
            'slug' => 'globex',
            'email' => 'admin@globex.com',
            'status' => 'active',
        ]);

        $globex->domains()->create([
            'domain' => 'globex.helply.test',
            'is_primary' => true,
        ]);

        if ($plan) {
            $globex->subscriptions()->create([
                'plan_id' => $plan->id,
                'status' => 'active',
                'billing_cycle' => 'monthly',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]);
        }
    }
}
