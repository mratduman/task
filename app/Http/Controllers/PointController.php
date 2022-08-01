<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\User;
use App\Repository\PointRepository;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function create(Request $request) {
        $response = new \stdClass();
        $response->success = false;
        $response->message = '';

        try {
            $currentUserId = User::scopes('CurrentUserId');

            $lastPoint = Point::query()
                ->where('user_id',$currentUserId)
                ->orderByDesc('id')
                ->first();

            if (empty($lastPoint->id) or $lastPoint->status==Point::BEKLENIYOR)
                throw new \Exception('Bekleniyor durumunda talebiniz varken yeni talepte bulunamazsınız!');

            $create = (new PointRepository())->create($currentUserId);

            if (!$create)
                throw new \Exception('Kayıt sırasında bir hata oluştu!');

            $response->success = true;
            $response->message = 'Kayıt başarılı';
        }catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return redirect()->route('home')->with((array)$response);
    }
}
