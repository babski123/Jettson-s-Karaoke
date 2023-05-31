<?php

/**
 * The file name says it all
 */

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['logged_in'] = $this->session->get('logged_in');
        return view('index', $data);
    }

    public function test() {
        return getenv('websiteName');
    }
}
