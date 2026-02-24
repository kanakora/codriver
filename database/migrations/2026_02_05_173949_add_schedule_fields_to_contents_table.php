<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->timestamp('scheduled_publish_at')->nullable()->after('published_at');
            $table->timestamp('expires_at')->nullable()->after('scheduled_publish_at');
            $table->timestamp('archived_at')->nullable()->after('expires_at');
            $table
                ->foreignId('current_revision_id')
                ->nullable()
                ->after('archived_at')
                ->constrained('content_revisions')
                ->nullOnDelete();

            $table->index('scheduled_publish_at');
            $table->index('expires_at');
            $table->index('archived_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['current_revision_id']);
            $table->dropColumn([
                'scheduled_publish_at',
                'expires_at',
                'archived_at',
                'current_revision_id',
            ]);
        });
    }
};
