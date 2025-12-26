<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20)->unique(); // HLP-000001
            $table->string('subject', 500);
            $table->string('status', 50)->default('open'); // open, pending, resolved, closed
            $table->string('priority', 20)->default('medium'); // low, medium, high, urgent
            $table->string('source', 50)->default('email'); // email, web, api
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('mailbox_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('sla_policy_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
