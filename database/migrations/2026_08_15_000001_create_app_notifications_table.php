<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * In-app notification feed.
 *
 * Named `app_notifications` rather than `notifications` so it never collides
 * with Laravel's own database notification channel, which the auth mail
 * notifications already use.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Recipient. Organization is nullable because account/security
            // notifications belong to the user, not to any one workspace.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();

            $table->string('type', 64);
            $table->string('category', 32)->index();
            $table->unsignedTinyInteger('priority')->default(2);

            $table->string('title');
            $table->text('body')->nullable();

            // Deep-link target for the mobile client, e.g. "/leave/{uuid}".
            $table->string('action_url')->nullable();

            // The record this notification is about, so a stale one can be
            // resolved (or suppressed) when that record changes.
            $table->string('subject_type', 191)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            $table->json('data')->nullable();

            // Who caused it. Null for system/scheduled notifications.
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // The feed query: this user's rows, newest first.
            $table->index(['user_id', 'created_at']);
            // The unread badge count, and unread-only filtering.
            $table->index(['user_id', 'read_at']);
            // Scoping a feed to the active workspace.
            $table->index(['user_id', 'organization_id']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
