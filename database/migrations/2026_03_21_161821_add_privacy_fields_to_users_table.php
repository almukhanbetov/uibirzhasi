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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('accepted_privacy')->default(false)->after('accepted_offer_version');
            $table->timestamp('accepted_privacy_at')->nullable();
            $table->string('accepted_privacy_ip', 45)->nullable();
            $table->string('accepted_privacy_version', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'accepted_privacy',
                'accepted_privacy_at',
                'accepted_privacy_ip',
                'accepted_privacy_version',
            ]);
        });
    }
};
