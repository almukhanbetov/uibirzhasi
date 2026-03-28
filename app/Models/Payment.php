<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'pg_payment_id',
        'amount',
        'currency',
        'status',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];

    /**
     * Связь с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Метод для успешного завершения платежа
     */
    public function markAsSuccess($pgPaymentId, $details = [])
    {
        // Используем транзакцию базы данных для надежности
        DB::transaction(function () use ($pgPaymentId, $details) {
            if ($this->status !== 'success') {
                $this->update([
                    'status' => 'success',
                    'pg_payment_id' => $pgPaymentId,
                    'payment_details' => $details
                ]);

                // Пополняем баланс пользователя в ТОО "СРА"
                // Предполагаем, что у модели User есть поле 'balance'
                $this->user->increment('balance', $this->amount);
            }
        });
    }
}