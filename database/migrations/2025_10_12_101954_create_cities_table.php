<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->string('name');

            // 1 — областной центр или город областного значения
            $table->boolean('is_region_center')->default(false);

            // 1 — город областного значения (Конаев, Тараз, Актобе, и т.д.)
            $table->boolean('is_city_of_region')->default(false);

            $table->timestamps();

            // один город внутри региона
            $table->unique(['region_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
