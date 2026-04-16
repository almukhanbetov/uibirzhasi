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
    
    public function init(Request $request)    {    
        // dd('INIT WORKS'); 
        // dd(config('services.freedom.merchant_id')); // 👈 ВСТАВЬ СЮДА         
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
        // 🔥 ЛОГ ПАРАМЕТРОВ (добавь тут)
        Log::info('FreedomPay REQUEST', $params);
        // ПОДПИСЬ
             // 3. подпись
        unset($params['pg_sig']);
        ksort($params);

        $values = array_values($params);
        array_unshift($values, 'init_payment.php');
        array_push($values, config('services.freedom.secret_key'));

        $signature = md5(implode(';', $values));

        $params['pg_sig'] = $signature;

        // лог
        Log::info('FreedomPay FORM', $params);

        // 4. ВАЖНО: возвращаем VIEW, а не redirect
        // return view('payments.redirect', compact('params'));
        // ✅ ВМЕСТО ЭТОГО:

        $response = Http::asForm()->post(
            'https://api.freedompay.kz/init_payment.php',
            $params
        );

        Log::info('FreedomPay RESPONSE', [
            'body' => $response->body()
        ]);

        $xml = simplexml_load_string($response->body());

        if (!$xml || !isset($xml->pg_redirect_url)) {
            dd('Ошибка FreedomPay', $response->body());
        }

        $redirectUrl = (string) $xml->pg_redirect_url;

        return redirect()->away($redirectUrl);
            
    }
    public function result(Request $request)
    {
        Log::info('FreedomPay CALLBACK', $request->all());

        $data = $request->all();

        // 🔐 проверка подписи
        $pg_sig = $data['pg_sig'];
        unset($data['pg_sig']);

        ksort($data);

        $values = array_values($data);
        array_unshift($values, 'result.php');
        array_push($values, config('services.freedom.secret_key'));

        $check_sig = md5(implode(';', $values));

        if ($check_sig !== $pg_sig) {
            Log::error('SIGNATURE INVALID');
            return response('error', 400);
        }

        // 🔍 находим платеж
        $payment = \App\Models\Payment::where('order_id', $data['pg_order_id'])->first();

        if (!$payment) {
            return response('payment not found', 404);
        }

        // ✅ если успешно
        if ($data['pg_result'] == 1) {

            if ($payment->status !== 'success') {

                $payment->status = 'success';
                $payment->save();

                // 💰 начисляем баланс
                $user = $payment->user;
                $user->balance += $payment->amount;
                $user->save();

                Log::info('BALANCE UPDATED', [
                    'user_id' => $user->id,
                    'balance' => $user->balance
                ]);
            }
        } else {
            $payment->status = 'failed';
            $payment->save();
        }

        return response('ok', 200);
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
    private function makeSignature($script, $params)
    {
        ksort($params);
        $values = [];
        $values[] = $script;
        foreach ($params as $key => $value) {
            $values[] = $value;
        }
        $values[] = config('services.freedom.secret_key');
        return md5(implode(';', $values));
        Log::info('FreedomPay SIGN STRING', [
            'string' => implode(';', $values),
        ]);
    }
    
}
