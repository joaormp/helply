<?php

namespace Database\Seeders;

use App\Models\Tenant\Customer;
use App\Models\Tenant\Tag;
use App\Models\Tenant\Team;
use App\Models\Tenant\Ticket;
use App\Models\Tenant\User;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed tenant database com dados de exemplo.
     */
    public function run(): void
    {
        // Criar equipa
        $team = Team::create([
            'name' => 'Support Team',
            'description' => 'Equipa principal de suporte',
            'color' => '#3B82F6',
            'is_active' => true,
        ]);

        // Criar utilizadores/agentes
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@'.tenant('slug').'.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'team_id' => $team->id,
            'is_active' => true,
        ]);

        $agent1 = User::create([
            'name' => 'Maria Silva',
            'email' => 'maria@'.tenant('slug').'.com',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'team_id' => $team->id,
            'is_active' => true,
        ]);

        $agent2 = User::create([
            'name' => 'João Santos',
            'email' => 'joao@'.tenant('slug').'.com',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'team_id' => $team->id,
            'is_active' => true,
        ]);

        // Criar clientes
        $customers = [
            [
                'name' => 'Pedro Costa',
                'email' => 'pedro@cliente.com',
                'phone' => '+351 912 345 678',
                'company' => 'Tech Solutions Lda',
            ],
            [
                'name' => 'Ana Martins',
                'email' => 'ana@empresa.pt',
                'phone' => '+351 923 456 789',
                'company' => 'Digital Agency',
            ],
            [
                'name' => 'Carlos Ferreira',
                'email' => 'carlos@business.com',
                'phone' => '+351 934 567 890',
                'company' => 'E-commerce Store',
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create($customerData);

            // Criar alguns tickets para cada cliente
            for ($i = 1; $i <= rand(2, 5); $i++) {
                $statuses = ['open', 'pending', 'resolved', 'closed'];
                $priorities = ['low', 'medium', 'high', 'urgent'];

                Ticket::create([
                    'subject' => 'Ticket #'.$i.' - '.fake()->sentence(),
                    'status' => fake()->randomElement($statuses),
                    'priority' => fake()->randomElement($priorities),
                    'customer_id' => $customer->id,
                    'assigned_to' => fake()->randomElement([$agent1->id, $agent2->id, null]),
                    'team_id' => $team->id,
                    'source' => fake()->randomElement(['email', 'web', 'api']),
                ]);
            }
        }

        // Criar tags
        $tags = [
            ['name' => 'Bug', 'color' => '#EF4444'],
            ['name' => 'Feature Request', 'color' => '#3B82F6'],
            ['name' => 'Question', 'color' => '#10B981'],
            ['name' => 'Urgent', 'color' => '#F59E0B'],
            ['name' => 'Billing', 'color' => '#8B5CF6'],
        ];

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }
    }
}
