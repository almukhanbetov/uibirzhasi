<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();      
        // Если таблицы PaymentSection нет, можно временно передать пустой массив или 
        // создать объект вручную для теста вида:
        $sections = []; 

        $payments = Payment::where('user_id', $user->id)->latest()->take(10)->get();

        return view('payments.index', compact('user', 'sections', 'payments'));
    }
    public function init(Request $request)
    {
        $user = Auth::user()->id;
        $amount = $request->input('amount', 1000); // Сумма из модального окна

        // 1. Создаем запись в нашей БД (pending)
        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => 'CPA-' . time() . '-' . $user->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // 2. Параметры для Freedom Pay
        $params = [
            'pg_merchant_id' => config('services.freedom.merchant_id'),
            'pg_amount'      => $payment->amount,
            'pg_currency'    => 'KZT',
            'pg_order_id'    => $payment->order_id,
            'pg_description' => "Пополнение баланса ТОО СРА для пользователя #{$user->id}",
            'pg_salt'        => bin2hex(random_bytes(12)),
            'pg_result_url'  => route('payment.result'),
            'pg_success_url' => route('payment.success'),
            'pg_failure_url' => route('payment.failure'),
        ];
        // 3. Генерация подписи
        $params['pg_sig'] = $this->makeSignature('init_payment.php', $params);

        // 4. Формируем URL для редиректа
        $query = http_build_query($params);
        return redirect()->away("https://api.freedompay.money/init_payment.php?{$query}");
    }
    private function makeSignature($scriptName, $params)
    {
        ksort($params); // Сортировка по ключам обязательна
        array_unshift($params, $scriptName);
        array_push($params, config('services.freedom.secret_key'));
        return md5(implode(';', $params));
    }
    public function success()
    {
        // Мы просто показываем файл из resources/views/payments/success.blade.php
        return view('payments.success');
    }
    public function failure()
    {
        // Мы просто показываем файл из resources/views/payments/failure.blade.php
        return view('payments.failure');
    }
    

}