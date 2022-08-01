<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class LoginController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request) {
        $auth = $this->auth($request, false);

        if ($auth->success)
            session(['user'=>$auth->userId]);

        return $auth;
    }

    public function loginAdmin(Request $request) {
        $auth = $this->auth($request, true);

        if ($auth->success)
            session(['admin_user'=>$auth->userId]);

        return $auth;
    }

    public function logout() {
        if (Session::has('user'))
            Session::forget('user');

        if (Session::has('admin_user'))
            Session::forget('admin_user');

        return redirect()->route('login');
    }

    protected function auth($request, bool $isAdminLogin) {
        $response = new stdClass();
        $response->success = false;
        $response->message = 'Böyle bir kullanıcı bulunamadı!';

        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'E-posta zorunlu alan',
                'email.email' => 'Lütfen doğru bir e-posta giriniz',
                'password.required' => 'Şifre zorunlu alan'
            ]);

            if ($isAdminLogin)
                $validated['admin'] = 1;

            $validated['password'] = md5($validated['password']);
            $user = User::query()->where($validated)->first();

            if (!$user)
                throw new \Exception($response->message);

            $response->success = true;
            $response->message = '';
            $response->userId = $user->id;

            session(['user'=>$response->userId]);

            return $response;
        }catch (\Exception $e) {
            $response->success = false;
            $response->message = $e->getMessage();
            return $response;
        }
    }
}
