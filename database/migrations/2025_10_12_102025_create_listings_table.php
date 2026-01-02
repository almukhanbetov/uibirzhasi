<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('set null');
            $table->foreignId('type_id')->nullable()->constrained('types')->onDelete('set null');
            $table->text('description')->nullable();
            // 💡 Добавляем тип сделки
            $table->enum('deal_type', ['sale', 'buy'])->comment('sale - продажа, buy - покупка');
            $table->double('area')->nullable();
            $table->integer('rooms');
            $table->double('price_current')->default(0);
            $table->double('price_base')->default(0);
            // логика изменения
            $table->float('price_step_pct')->default(1); // % шага
            $table->integer('price_step_days')->default(1);
            $table->timestamp('last_price_change_at')->nullable();
            // статус
            $table->enum('status', [
                'active',
                'matched',
                'expired',
                'closed'
            ])->default('active');      
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
