<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    //ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //ログイン処理
    public function login(Request $request)
    {
        //バリデーション
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //認証試行(Auth::attemptはハッシュチェックを自動で行う)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //ログインが成功したらメインページに戻る
            return redirect()->intended('/');

            //認証失敗時
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ])->onlyInput('email');
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //登録内容確認用
    //登録内容確認用
    public function confirmRegister(Request $request)
    {
        //バリデーションチェック
        // 【修正】 $inputs = を追加して、バリデーション済みのデータを受け取る
        $inputs = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'], //確認画面からハッシュ前のパスがくる
        ]);

        //入力値をinputsという名前でviewに返す
        return view('auth.confirm', [
            'inputs' => $inputs,
        ]);
    }

    //登録
    public function register(Request $request)
    {

        //入力値のバリデーション(フォーム改ざん対策)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //パスワードのハッシュ化
        ]);

        Auth::login($user); //そのままログインさせる

        return redirect('/')->with('success', '登録が完了しました!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // セッションを無効化
        $request->session()->invalidate();
        // CSRFトークンを再生成
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
