<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class HomeController extends Controller
{
    public function index() {
        $points = User::query()
            ->scopes('CurrentUser')
            ->points()
            ->orderByDesc('points.id')
            ->get();

        $templateId = User::query()->scopes('CurrentUser')->template_id;
        $bgColor = Template::query()->find($templateId)->color;

        return view('home',compact('points','bgColor'));
    }
}
