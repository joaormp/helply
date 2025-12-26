<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('type', 20)->default('reply'); // original, reply, note
            $table->string('sender_type', 20); // customer, agent
            $table->unsignedBigInteger('sender_id'); // customer_id or user_id
            $table->text('body');
            $table->text('body_html')->nullable();
            $table->boolean('is_internal')->default(false);
            $table->string('message_id')->nullable(); // email Message-ID
            $table->string('in_reply_to')->nullable();
            $table->json('headers')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
