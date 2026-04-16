@extends('layouts.app')
@section('content')
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Пополнение депозита</h1>
        <div class="mb-4">
            <div class="text-sm text-gray-500">Текущий баланс</div>
            <div class="text-xl font-semibold">{{ number_format($user->balance, 2, '.', ' ') }} KZT</div>
        </div>
        <form method="POST" action="{{ route('payment.init') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Сумма депозита</label>
                <input type="number" name="amount" min="100" step="1" value="1300"
                    class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="border rounded p-4">
                <div class="font-medium">Способ оплаты</div>
                <div class="text-sm text-gray-600 mt-1">Freedom Pay — банковская карта</div>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Оплатить через Freedom Pay
            </button>
            <button type="submit" style="background:red;color:white;padding:10px;">
                TEST PAY 🚀
            </button>
        </form>
        <hr class="my-6">
        <h2 class="text-lg font-semibold mb-3">История платежей</h2>
        <div class="space-y-2">
            @forelse($payments as $payment)
                <div class="border rounded p-3">
                    <div><strong>Заказ:</strong> {{ $payment->order_id }}</div>
                    <div><strong>Сумма:</strong> {{ $payment->amount }} {{ $payment->currency }}</div>
                    <div><strong>Статус:</strong> {{ $payment->status }}</div>
                </div>
            @empty
                <div class="text-gray-500">Платежей пока нет</div>
            @endforelse
        </div>
    </div>
@endsection
