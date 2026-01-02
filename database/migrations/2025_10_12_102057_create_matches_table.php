<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            // 🔹 Покупатель
            $table->foreignId('buyer_id')->nullable()->constrained('users')->nullOnDelete();
            // 🔹 Продавец
            $table->foreignId('seller_id')->nullable()->constrained('users')->nullOnDelete();
            // 🔹 Объявление покупателя
            $table->foreignId('buy_listing_id')->nullable()->constrained('listings')->nullOnDelete();
            // 🔹 Объявление продавца
            $table->foreignId('sell_listing_id')->nullable()->constrained('listings')->nullOnDelete();
            // 🔹 Цена покупателя на момент совпадения
            $table->unsignedBigInteger('buy_price')->nullable();
            // 🔹 Цена продавца на момент совпадения
            $table->unsignedBigInteger('sale_price')->nullable();
            // 🔹 Итоговая (средняя)
            $table->unsignedBigInteger('final_price')->nullable();
            // 🔹 Статус сделки
            // awaiting_deposit — ждём депозита
            // contacts_open — контакты открыты
            // expired — просрочено
            // done — завершена
            $table->string('status')->default('awaiting_deposit');
            // 🔹 Для скорости
            $table->index('buyer_id');
            $table->index('seller_id');
            $table->index('buy_listing_id');
            $table->index('sell_listing_id');
            $table->index('status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
