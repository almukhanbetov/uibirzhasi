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
            $table->boolean('accepted_offer')->default(false)->after('password');
            $table->timestampTz('accepted_offer_at')->nullable()->after('accepted_offer');
            $table->string('accepted_offer_ip', 45)->nullable()->after('accepted_offer_at');
            $table->string('accepted_offer_version', 20)->nullable()->after('accepted_offer_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'accepted_offer',
                'accepted_offer_at',
                'accepted_offer_ip',
                'accepted_offer_version',
            ]);
        });
    }
};
