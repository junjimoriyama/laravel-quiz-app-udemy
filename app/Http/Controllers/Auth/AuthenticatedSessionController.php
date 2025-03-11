<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //リクエストデータから認証試みる
        $request->authenticate();
        //ログイン成功時にセッションIDを新たに生成
        $request->session()->regenerate();
        //管理画面トップページにリダイレクト
        return redirect()->intended(route('admin.top', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 1. ログアウト処理（ユーザーを認証解除）
        Auth::guard('web')->logout();

        // 2. セッションを無効化（セキュリティ対策）
        $request->session()->invalidate();

        // 3. CSRF トークンを再生成
        $request->session()->regenerateToken();

        // 4. ログアウト後に `/login` にリダイレクト
        return redirect('login');
        return redirect()->intended(route('login', absolute: false));

    }
}
