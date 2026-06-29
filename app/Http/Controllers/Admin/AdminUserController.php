<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['listings', 'deposits'])
            ->with('role')
            ->latest();

        if ($search = $request->input('search')) {
            // Нормализуем телефон: 8777... → +7777..., убираем лишние символы
            $phoneVariants = [$search];
            $digits = preg_replace('/\D/', '', $search);
            if ($digits) {
                $phoneVariants[] = $digits;
                if (str_starts_with($digits, '8') && strlen($digits) === 11) {
                    $phoneVariants[] = '+7' . substr($digits, 1);
                }
                if (str_starts_with($digits, '7') && strlen($digits) === 11) {
                    $phoneVariants[] = '+' . $digits;
                    $phoneVariants[] = '8' . substr($digits, 1);
                }
            }

            $query->where(function ($q) use ($search, $phoneVariants) {
                $q->where('name', 'like', "%{$search}%");
                foreach ($phoneVariants as $variant) {
                    $q->orWhere('phone', 'like', "%{$variant}%");
                }
            });
        }

        $users = $query->paginate(12)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show(string $id)
    {
        $user = User::with('role')->withCount(['listings', 'deposits'])->findOrFail($id);
        $listings = $user->listings()->with('photos')->latest()->get();
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'listings', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('role_id')) {
            $request->validate(['role_id' => 'required|exists:roles,id']);
            $user->update(['role_id' => $request->role_id]);
            return back()->with('success', "Роль пользователя «{$user->name}» обновлена.");
        }

        if ($request->has('reset_password')) {
            $newPassword = rand(100000, 999999);
            $user->update(['password' => bcrypt($newPassword)]);
            return back()->with('success', "Новый пароль для «{$user->name}» ({$user->phone}): {$newPassword}");
        }

        return back();
    }
}
