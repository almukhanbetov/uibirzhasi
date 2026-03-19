<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class RegisteredUserController extends Controller
{   
    public function create(): View
    {
        return view('auth.register');
    }
    public function store(Request $request): RedirectResponse
    {        
        $raw = (string) $request->input('phone', '');
        $digits = preg_replace('/\D+/', '', $raw);   // оставляем только цифры
        if ($digits !== '') {            
            if (str_starts_with($digits, '8')) {
                $digits = '7' . substr($digits, 1);
            }           
            $normalized = '+' . $digits;
            // кладём НАЗАД в $request
            $request->merge(['phone' => $normalized]);
        }
        // (опционально) посмотрим, что реально уйдёт в валидацию
        Log::info('Регистрация: нормализация телефона', [
            'original'   => $raw,
            'normalized' => $request->input('phone'),
        ]);
        // 2) Валидация (уже по нормализованному значению)
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'phone'                 => ['required', 'string', 'regex:/^\+7\d{10}$/', 'unique:users,phone'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'accepted_offer'        => ['accepted'],
        ], [
            'name.required'     => 'Введите имя.',
            'phone.required'    => 'Введите номер телефона.',
            'phone.regex'       => 'Введите номер в формате +7700XXXXXXX.',
            'phone.unique'      => 'Этот номер уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.confirmed'=> 'Пароли не совпадают.',
        ]);      
        $user = User::create([
            'name'     => $validated['name'],
            'phone'    => $request->input('phone'),
            'password' => Hash::make($validated['password']),
            // 🔥 ОФЕРТА — ЯВНО
            'accepted_offer' => true,
            'accepted_offer_at' => now(),
            'accepted_offer_ip' => $request->ip(),
            'accepted_offer_version' => 'v1.0',
        ]);       
        // 🔀 Redirect в зависимости от роли
        if ($user->is_admin) {
            return redirect('/admin');
        }
        return redirect()->route('dashboard');
    }
}
