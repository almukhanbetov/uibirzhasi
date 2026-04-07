<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{  
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Внешний ключ на пользователя (физ. лицо)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');            
            // Внутренний ID заказа для ТОО "СРА" (pg_order_id)
            $table->string('order_id')->unique();            
            // ID транзакции в системе Freedom Pay (придет в callback)
            $table->string('pg_payment_id')->nullable()->index();            
            // Сумма и валюта
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('KZT');            
            // Статусы: pending, success, rejected, refunded
            $table->string('status')->default('pending');            
            // Дополнительные данные от банка (логируем весь JSON ответ на всякий случай)
            $table->json('payment_details')->nullable();
            $table->timestamps();            
            // Индекс для быстрого поиска по заказу
            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
