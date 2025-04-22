<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20',
                'role' => 'required|string|max:50',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'full_name.required' => 'Vui lòng nhập họ tên.',
                'email.required' => 'Email không được để trống.',
                'email.email' => 'Email không đúng định dạng.',
                'email.lowercase' => 'Email phải là chữ thường.',
                'email.unique' => 'Email này đã được đăng ký.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'role.required' => 'Vui lòng chọn vai trò.',
                'password.required' => 'Mật khẩu không được để trống.',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            ]);

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => $request->password,
            ]);

            event(new Registered($user));
            Auth::login($user);

            return to_route('login');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.']);
        }
    }

}
