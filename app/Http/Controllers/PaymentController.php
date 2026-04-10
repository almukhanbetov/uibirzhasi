<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // dd(
        //     config('freedom.merchant_id'),
        //     config('freedom.secret_key') ? 'OK' : 'NULL'
        // );
        $user = Auth::user();
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
            'pg_result_url' => 'https://uibirzhasi.kz/payment/result',
            'pg_success_url' => 'https://uibirzhasi.kz/payment/success',
            'pg_failure_url' => 'https://uibirzhasi.kz/payment/failure',
        ];     
    // ПОДПИСЬ
        ksort($params);
        $values = array_values($params);
        array_unshift($values, 'init_payment.php');
        array_push($values, config('freedom.secret_key'));
        $signatureString = implode(';', $values);
        $pg_sig = md5($signatureString);
        // ЛОГ ПОДПИСИ
        Log::info('FreedomPay SIGNATURE', [
            'string' => $signatureString,
            'pg_sig' => $pg_sig,
        ]);
        $params['pg_sig'] = $pg_sig;
        // URL
        $query = http_build_query($params);
        $url = "https://api.freedompay.kz/init_payment.php?$query";    
        return redirect()->away($url);
    }
    private function makeSignature($scriptName, $params)
    {
        ksort($params);
        $values = array_values($params);
        array_unshift($values, $scriptName);
        array_push($values, config('services.freedom.secret_key'));
        return md5(implode(';', $values));
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
