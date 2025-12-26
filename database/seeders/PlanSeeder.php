<?php

namespace Database\Seeders;

use App\Models\Central\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfeito para pequenas equipas que estão a começar',
                'price_monthly' => 29.00,
                'price_yearly' => 290.00,
                'features' => [
                    'agents' => 3,
                    'mailboxes' => 1,
                    'storage_gb' => 5,
                    'tickets_per_month' => 100,
                ],
                'limits' => [
                    'tickets_per_month' => 100,
                    'knowledge_base_articles' => 50,
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Ideal para equipas em crescimento',
                'price_monthly' => 79.00,
                'price_yearly' => 790.00,
                'features' => [
                    'agents' => 10,
                    'mailboxes' => 5,
                    'storage_gb' => 20,
                    'tickets_per_month' => 500,
                ],
                'limits' => [
                    'tickets_per_month' => 500,
                    'knowledge_base_articles' => 200,
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Para empresas com alto volume de suporte',
                'price_monthly' => 149.00,
                'price_yearly' => 1490.00,
                'features' => [
                    'agents' => 25,
                    'mailboxes' => 15,
                    'storage_gb' => 50,
                    'tickets_per_month' => -1, // unlimited
                ],
                'limits' => [
                    'tickets_per_month' => -1,
                    'knowledge_base_articles' => -1,
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Solução completa para grandes organizações',
                'price_monthly' => 299.00,
                'price_yearly' => 2990.00,
                'features' => [
                    'agents' => -1, // unlimited
                    'mailboxes' => -1,
                    'storage_gb' => -1,
                    'tickets_per_month' => -1,
                ],
                'limits' => [
                    'tickets_per_month' => -1,
                    'knowledge_base_articles' => -1,
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
