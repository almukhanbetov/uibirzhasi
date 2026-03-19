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
        Schema::create('payment_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_desc')->nullable(); // короткий текст
            $table->longText('long_desc')->nullable(); // длинный текст
            $table->string('icon')->nullable(); // bi-arrow-repeat          
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_sections');
    }
};
