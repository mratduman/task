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
        $points = Point::join('users','users.id','=','points.user_id')
            ->select('users.name','users.status','users.admin','points.*');

        if (!isset($request->button)) {
            $points = $points->where(function ($q) {
                $q->where('points.status', '=', 1)
                    ->orWhere('points.status', '=', 0);
            })->orderByDesc('points.id')->get();
            return view('admin.answered',compact('points'));
        }

        $filter = array();
        if (!empty($request->status))
            $filter[] = array('users.status', '=', $request->status);
        if (!empty($request->admin))
            $filter[] = array('users.admin','=',$request->admin);
        if (!empty($request->name))
            $filter[] = array('users.name','like','%'.$request->name.'%');

        $points = $points->where($filter)->orderByDesc('points.id')->get();

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
