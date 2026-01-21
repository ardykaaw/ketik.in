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
        // Revert the assumption: We don't know if email was sent, so we set it to NULL.
        // This will verify that the system is "checking correctly" (i.e., not assuming).
        DB::table('users')
            ->update(['activation_email_sent_at' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot restore the "guessed" data.
    }
};
