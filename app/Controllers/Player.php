<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Player extends BaseController
{
    public function index()
    {
        //
        return view('video_player');
    }
}
