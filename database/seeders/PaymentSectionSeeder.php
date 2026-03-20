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