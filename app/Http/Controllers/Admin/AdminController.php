<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Repository\PointRepository;
use Illuminate\Http\Request;
use stdClass;

class AdminController extends Controller
{
    public function answered(Request $request) {
        $points = Point::query()
            ->scopes('Answered')
            ->scopes('PointUser')
            ->select('users.name','points.*')
            ->orderByDesc('points.id');

        if (empty($request->status)) {
            $points = $points->get();
            return view('admin.answered',compact('points'));
        }

        $filter = [];
        $request->status!='' ?: array_push($filter,['points.status'=>$request->status]);
        $request->username!='' ?: array_push($filter,['users.name','like','%'.$request->username.'%']);

        $points = $points->where($filter);

        return view('admin.answered',compact('points'));
    }

    public function waiting() {
        $points = Point::query()
            ->scopes('Waiting')
            ->scopes('PointUser')
            ->select('users.name','points.*')
            ->get();

        return view('admin.waiting', compact('points'));
    }

    public function pointStatusUpdate(Request $request) {
        $response = new stdClass();
        $response->success = false;
        $response->message = 'Güncelleme yapılamadı';

        try {
            $request->status = Point::RED;

            if (isset($request->okay['okay'])) {
                $request->status = Point::ONAY;

                $request->validate([
                    'point' => 'required'
                ], [
                    'point.required' => 'Onaylarken puan boş olamaz!'
                ]);
            }

            $up = (new PointRepository())->pointStatusUpdate($request);

            if (!$up)
                return $response;

            $response->success = true;
            $response->message = 'Güncelleme başarılı';
        }catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return redirect()->back()->with((array)$response);
    }
}
