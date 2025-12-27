<?php

namespace Database\Seeders;

use App\Models\Tenant\Customer;
use App\Models\Tenant\Message;
use App\Models\Tenant\Tag;
use App\Models\Tenant\Team;
use App\Models\Tenant\Ticket;
use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed tenant database with demo data.
     */
    public function run(): void
    {
        // Create teams
        $supportTeam = Team::firstOrCreate(
            ['name' => 'Support Team'],
            [
                'description' => 'Main customer support team',
                'active' => true,
            ]
        );

        $technicalTeam = Team::firstOrCreate(
            ['name' => 'Technical Team'],
            [
                'description' => 'Technical support and engineering',
                'active' => true,
            ]
        );

        // Create users/agents
        $admin = User::firstOrCreate(
            ['email' => 'admin@'.tenant('slug').'.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'team_id' => $supportTeam->id,
            ]
        );

        $agents = [
            [
                'name' => 'Maria Silva',
                'email' => 'maria@'.tenant('slug').'.test',
                'role' => 'agent',
                'team_id' => $supportTeam->id,
            ],
            [
                'name' => 'João Santos',
                'email' => 'joao@'.tenant('slug').'.test',
                'role' => 'agent',
                'team_id' => $supportTeam->id,
            ],
            [
                'name' => 'Carlos Tech',
                'email' => 'carlos@'.tenant('slug').'.test',
                'role' => 'agent',
                'team_id' => $technicalTeam->id,
            ],
        ];

        $agentModels = [];
        foreach ($agents as $agentData) {
            $agentModels[] = User::firstOrCreate(
                ['email' => $agentData['email']],
                array_merge($agentData, ['password' => Hash::make('password')])
            );
        }

        // Create tags
        $tagData = [
            ['name' => 'Bug', 'color' => '#EF4444', 'slug' => 'bug'],
            ['name' => 'Feature Request', 'color' => '#3B82F6', 'slug' => 'feature-request'],
            ['name' => 'Question', 'color' => '#10B981', 'slug' => 'question'],
            ['name' => 'Urgent', 'color' => '#F59E0B', 'slug' => 'urgent'],
            ['name' => 'Billing', 'color' => '#8B5CF6', 'slug' => 'billing'],
        ];

        $tags = [];
        foreach ($tagData as $tag) {
            $tags[] = Tag::firstOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }

        // Create customers and tickets
        $customerData = [
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
            [
                'name' => 'Rita Sousa',
                'email' => 'rita@startup.io',
                'phone' => '+351 945 678 901',
                'company' => 'Startup Hub',
            ],
            [
                'name' => 'Miguel Oliveira',
                'email' => 'miguel@corp.com',
                'phone' => '+351 956 789 012',
                'company' => 'Corporate Systems',
            ],
        ];

        foreach ($customerData as $customer) {
            $customerModel = Customer::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );

            // Create 2-4 tickets for each customer with varied statuses
            $ticketCount = rand(2, 4);
            for ($i = 0; $i < $ticketCount; $i++) {
                $status = fake()->randomElement(['open', 'pending', 'on_hold', 'solved', 'closed']);
                $priority = fake()->randomElement(['low', 'normal', 'high', 'urgent']);
                $source = fake()->randomElement(['email', 'web', 'api']);

                $ticket = Ticket::create([
                    'subject' => fake()->sentence(),
                    'description' => fake()->paragraph(3),
                    'status' => $status,
                    'priority' => $priority,
                    'customer_id' => $customerModel->id,
                    'agent_id' => $status !== 'open' ? fake()->randomElement($agentModels)->id : null,
                    'team_id' => fake()->randomElement([$supportTeam->id, $technicalTeam->id]),
                    'source' => $source,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);

                // Add 1-3 messages to each ticket
                $messageCount = rand(1, 3);
                for ($j = 0; $j < $messageCount; $j++) {
                    $isFromAgent = $j > 0; // First message from customer, rest from agents

                    Message::create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $isFromAgent ? fake()->randomElement($agentModels)->id : null,
                        'customer_id' => ! $isFromAgent ? $customerModel->id : null,
                        'body' => fake()->paragraph(2),
                        'is_internal' => false,
                        'created_at' => $ticket->created_at->addMinutes(rand(10, 1440 * $j)),
                    ]);
                }

                // Attach random tags (0-2 tags per ticket)
                $ticketTags = fake()->randomElements($tags, rand(0, 2));
                foreach ($ticketTags as $tag) {
                    $ticket->tags()->attach($tag->id);
                }
            }
        }

        $this->command->info('Tenant database seeded successfully for: '.tenant('slug'));
        $this->command->info('Admin: admin@'.tenant('slug').'.test / password');
        $this->command->info('Agent: maria@'.tenant('slug').'.test / password');
    }
}
