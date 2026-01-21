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
        // Mark all currently active users as having "sent" emails (using their update time as proxy)
        // This assumes that if they are active, they were processed manually or correctly before this tracking existed.
        DB::table('users')
            ->where('is_active', true)
            ->whereNull('activation_email_sent_at')
            ->update(['activation_email_sent_at' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse really, but we could set them back to null if needed.
        // For data integrity, we'll leave it.
    }
};
