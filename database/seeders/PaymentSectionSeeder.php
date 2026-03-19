<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSection;

class PaymentSectionSeeder extends Seeder
{
    public function run(): void
    {
        PaymentSection::insert([
            [
                'title' => 'Банковская карта',
                'short_desc' => 'Безналичная оплата через защищённый платёжный шлюз.',
                'long_desc' => 'Поддерживаются стандартные банковские карты для безопасной оплаты через личный кабинет.',
                'icon' => 'bi-credit-card',               
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Тарифы',
                'short_desc' => 'Комиссия составляет 1% от стоимости недвижимости.',
                'long_desc' => 'Комиссия оплачивается отдельно Продавцом и Покупателем после совпадения цен и подтверждения сделки.',
                'icon' => 'bi-arrow-repeat',               
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Процедура оплаты',
                'short_desc' => 'Оплата рассчитывается автоматически на основе актуальной рыночной цены.',
                'long_desc' => 'При изменении условий сделки сумма автоматически пересчитывается и оплачивается через личный кабинет.',
                'icon' => 'bi-arrow-repeat',               
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Правила возврата',
                'short_desc' => 'Возврат средств возможен в течение 3 рабочих дней с момента оплаты.',
                'long_desc' => 'Если сделка не была завершена, пользователь может обратиться в поддержку через личный кабинет.',
                'icon' => 'bi-arrow-counterclockwise',               
                'sort_order' => 4,
                'is_active' => true,
            ],
        ]);
    }
}