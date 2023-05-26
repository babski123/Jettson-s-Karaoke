<?php

/**
 * The file name says it all
 */

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function test() {
        return getenv('websiteName');
    }
}
