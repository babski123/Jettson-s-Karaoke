<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PrivacyPolicy extends BaseController
{
    public function index()
    {
        return view('privacy_policy');
    }
}
