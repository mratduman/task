<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class UserController extends Controller
{
    public function index() {
        $users = User::query()->get();
        return view('admin.users',compact('users'));
    }

    public function update(Request $request) {
        $response = new stdClass();
        $response->success = false;
        $response->message = 'Güncelleme başarısız';

        try {
            $request->validate([
                'status' => 'required'
            ], [
                'status.required' => 'Durum alanı seçilmemiş'
            ]);

            $request->template_id = Template::SARI;
            if ($request->status==User::RISKLI)
                $request->template_id = Template::KIRMIZI;

            $update = (new \App\Repository\UserRepository)->updateStatus($request);

            if (!$update)
                return $response;

            $response->success = true;
            $response->message = 'Başarılı güncelleme';
        }catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return redirect()->back()->with((array)$response);
    }
}
