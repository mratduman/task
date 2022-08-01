<?php

namespace App\Repository;

use App\Models\Point;

class PointRepository extends Point
{
    public function create($userId) {
        return Point::query()->create([
            'point' => 0,
            'user_id' => $userId,
            'status' => Point::BEKLENIYOR
        ]);
    }

    public function pointStatusUpdate($request) {
        return Point::query()
            ->where('id',$request->id)
            ->update([
                'point'=> @$request->point ?? 0,
                'status'=>$request->status,
                'updated_at'=>now()
            ]);
    }
}
