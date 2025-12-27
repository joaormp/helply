<?php

namespace Database\Seeders;

use App\Models\Tenant\CannedReply;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Message;
use App\Models\Tenant\SlaPolicy;
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
                'is_active' => true,
            ]
        );

        $technicalTeam = Team::firstOrCreate(
            ['name' => 'Technical Team'],
            [
                'description' => 'Technical support and engineering',
                'is_active' => true,
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
                    'status' => $status,
                    'priority' => $priority,
                    'customer_id' => $customerModel->id,
                    'assigned_to' => $status !== 'open' ? fake()->randomElement($agentModels)->id : null,
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
                        'type' => $j === 0 ? 'original' : 'reply',
                        'sender_type' => $isFromAgent ? 'agent' : 'customer',
                        'sender_id' => $isFromAgent ? fake()->randomElement($agentModels)->id : $customerModel->id,
                        'body' => fake()->paragraph(2),
                        'is_internal' => false,
                        'created_at' => $ticket->created_at->addMinutes(rand(10, 1440 * $j)),
                    ]);
                }

                // Attach random tags (0-2 tags per ticket)
                $ticketTags = fake()->randomElements($tags, rand(0, 2));
                $tagIds = array_map(fn ($tag) => $tag->id, $ticketTags);
                if (! empty($tagIds)) {
                    $ticket->tags()->sync($tagIds);
                }
            }
        }

        // Create canned replies
        $cannedRepliesData = [
            [
                'name' => 'Welcome Message',
                'subject' => 'Welcome to our support system!',
                'body' => '<p>Hi {{customer_name}},</p><p>Thank you for contacting us! We have received your ticket <strong>{{ticket_number}}</strong> and one of our team members will get back to you shortly.</p><p>Best regards,<br>{{agent_name}}</p>',
                'is_shared' => true,
            ],
            [
                'name' => 'Request More Information',
                'subject' => null,
                'body' => '<p>Hi {{customer_name}},</p><p>Thank you for reaching out. To better assist you with ticket <strong>{{ticket_number}}</strong>, could you please provide us with some additional information:</p><ul><li>A detailed description of the issue</li><li>Any error messages you received</li><li>Steps to reproduce the problem</li></ul><p>This will help us resolve your issue more quickly.</p><p>Thank you,<br>{{agent_name}}</p>',
                'is_shared' => true,
            ],
            [
                'name' => 'Issue Resolved',
                'subject' => 'Your issue has been resolved',
                'body' => '<p>Hi {{customer_name}},</p><p>Great news! We have successfully resolved the issue reported in ticket <strong>{{ticket_number}}</strong>.</p><p>If you experience any further problems or have additional questions, please don\'t hesitate to reach out to us.</p><p>Thank you for your patience!</p><p>Best regards,<br>{{agent_name}}</p>',
                'is_shared' => true,
            ],
            [
                'name' => 'Password Reset Instructions',
                'subject' => 'Password Reset Instructions',
                'body' => '<p>Hi {{customer_name}},</p><p>To reset your password, please follow these steps:</p><ol><li>Go to our login page</li><li>Click on "Forgot Password"</li><li>Enter your email address</li><li>Check your email for the reset link</li><li>Follow the link and create a new password</li></ol><p>If you continue to experience issues, please let us know.</p><p>Best regards,<br>{{agent_name}}</p>',
                'is_shared' => true,
            ],
            [
                'name' => 'Escalation Notice',
                'subject' => 'Your ticket has been escalated',
                'body' => '<p>Hi {{customer_name}},</p><p>We wanted to let you know that ticket <strong>{{ticket_number}}</strong> has been escalated to our senior support team for further investigation.</p><p>A specialist will review your case and provide an update within the next 24 hours.</p><p>We appreciate your patience as we work to resolve this matter.</p><p>Best regards,<br>{{agent_name}}</p>',
                'is_shared' => true,
            ],
        ];

        foreach ($cannedRepliesData as $cannedReply) {
            CannedReply::firstOrCreate(
                ['name' => $cannedReply['name']],
                $cannedReply
            );
        }

        // Create SLA policies
        $slaPoliciesData = [
            [
                'name' => 'Standard Support',
                'description' => 'Standard SLA for normal priority tickets',
                'first_response_time' => 240, // 4 hours
                'resolution_time' => 1440, // 24 hours
                'priority' => 'normal',
                'is_active' => true,
            ],
            [
                'name' => 'High Priority Support',
                'description' => 'Enhanced SLA for high priority issues',
                'first_response_time' => 120, // 2 hours
                'resolution_time' => 480, // 8 hours
                'priority' => 'high',
                'is_active' => true,
            ],
            [
                'name' => 'Urgent Support',
                'description' => 'Critical SLA for urgent tickets requiring immediate attention',
                'first_response_time' => 30, // 30 minutes
                'resolution_time' => 240, // 4 hours
                'priority' => 'urgent',
                'is_active' => true,
            ],
            [
                'name' => 'Low Priority Support',
                'description' => 'Flexible SLA for low priority requests',
                'first_response_time' => 480, // 8 hours
                'resolution_time' => 2880, // 48 hours
                'priority' => 'low',
                'is_active' => true,
            ],
        ];

        foreach ($slaPoliciesData as $slaPolicy) {
            SlaPolicy::firstOrCreate(
                ['name' => $slaPolicy['name']],
                $slaPolicy
            );
        }

        $this->command->info('Tenant database seeded successfully for: '.tenant('slug'));
        $this->command->info('Admin: admin@'.tenant('slug').'.test / password');
        $this->command->info('Agent: maria@'.tenant('slug').'.test / password');
    }
}
