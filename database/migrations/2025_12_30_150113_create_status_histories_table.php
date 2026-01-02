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
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            // к какому объявлению относится запись
            $table->foreignId('listing_id')
                ->constrained('listings')
                ->cascadeOnDelete();

            // старый и новый статус
            $table->string('old_status')->nullable();
            $table->string('new_status');

            // причина изменения (auto_match, manual, admin и т.п.)
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histories');
    }
};
