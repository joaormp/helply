<?php

namespace Database\Seeders;

use App\Models\Central\CentralUser;
use App\Models\Central\Plan;
use App\Models\Central\Subscription;
use App\Models\Central\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CentralDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        if (! CentralUser::where('email', 'admin@helply.test')->exists()) {
            CentralUser::create([
                'name' => 'Admin User',
                'email' => 'admin@helply.test',
                'password' => Hash::make('password'),
            ]);
        }

        // Create subscription plans
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small teams getting started',
                'price_monthly' => 29.00,
                'price_yearly' => 290.00,
                'features' => json_encode([
                    '5 team members',
                    '100 tickets/month',
                    'Email support',
                    'Basic reporting',
                ]),
                'max_users' => 5,
                'max_tickets_per_month' => 100,
                'active' => true,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For growing teams with more needs',
                'price_monthly' => 79.00,
                'price_yearly' => 790.00,
                'features' => json_encode([
                    '20 team members',
                    '500 tickets/month',
                    'Priority support',
                    'Advanced reporting',
                    'Custom branding',
                ]),
                'max_users' => 20,
                'max_tickets_per_month' => 500,
                'active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large organizations with custom needs',
                'price_monthly' => 199.00,
                'price_yearly' => 1990.00,
                'features' => json_encode([
                    'Unlimited team members',
                    'Unlimited tickets',
                    '24/7 dedicated support',
                    'Custom integrations',
                    'SLA guarantees',
                    'White-label solution',
                ]),
                'max_users' => null,
                'max_tickets_per_month' => null,
                'active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        // Create demo tenants with subscriptions
        $tenants = [
            [
                'id' => 'acme',
                'name' => 'Acme Corporation',
                'slug' => 'acme',
                'email' => 'support@acme.test',
                'status' => 'active',
                'plan' => 'enterprise',
            ],
            [
                'id' => 'techstart',
                'name' => 'TechStart Inc',
                'slug' => 'techstart',
                'email' => 'help@techstart.test',
                'status' => 'active',
                'plan' => 'professional',
            ],
            [
                'id' => 'creative-studio',
                'name' => 'Creative Studio',
                'slug' => 'creative-studio',
                'email' => 'info@creativestudio.test',
                'status' => 'active',
                'plan' => 'professional',
            ],
            [
                'id' => 'startup-hub',
                'name' => 'Startup Hub',
                'slug' => 'startup-hub',
                'email' => 'contact@startuphub.test',
                'status' => 'trial',
                'plan' => 'starter',
            ],
            [
                'id' => 'digital-agency',
                'name' => 'Digital Agency',
                'slug' => 'digital-agency',
                'email' => 'support@digitalagency.test',
                'status' => 'active',
                'plan' => 'starter',
            ],
        ];

        foreach ($tenants as $tenantData) {
            $planSlug = $tenantData['plan'];
            unset($tenantData['plan']);

            // Use firstOrCreate without events to avoid automatic database creation during seeding
            $tenant = Tenant::withoutEvents(function () use ($tenantData) {
                return Tenant::firstOrCreate(
                    ['id' => $tenantData['id']],
                    $tenantData
                );
            });

            // Create subscription for the tenant
            $plan = Plan::where('slug', $planSlug)->first();
            if ($plan && ! $tenant->subscriptions()->where('plan_id', $plan->id)->exists()) {
                $periodStart = now()->subDays(rand(30, 180));
                Subscription::create([
                    'tenant_id' => $tenant->id,
                    'plan_id' => $plan->id,
                    'status' => $tenant->status === 'trial' ? 'trialing' : 'active',
                    'billing_cycle' => 'monthly',
                    'trial_ends_at' => $tenant->status === 'trial' ? now()->addDays(14) : null,
                    'current_period_start' => $periodStart,
                    'current_period_end' => $periodStart->copy()->addMonth(),
                    'cancelled_at' => null,
                ]);
            }
        }

        $this->command->info('Central database seeded successfully!');
        $this->command->info('Admin credentials: admin@helply.test / password');
    }
}
