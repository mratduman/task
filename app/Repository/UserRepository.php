<?php

namespace App\Repository;

use App\Models\User;

class UserRepository {

    public function updateStatus($request): int
    {
        return User::query()
            ->where('id',$request->id)
            ->update([
                'status'=>$request->status,
                'template_id'=>$request->template_id
            ]);
    }

}
