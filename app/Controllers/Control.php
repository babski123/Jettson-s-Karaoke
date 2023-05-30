<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\Command;

class Control extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {

            //set headers
            $this->response->setHeader('Content-Type', 'text/event-stream')
                ->setHeader('Cache-Control', 'no-cache')
                ->setHeader('Connection', 'keep-alive');

            $model = new Command();
            $result = $model->first();

            echo "data: " . json_encode($result) . "\n\n";
        }
    }

    public function update($action)
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            
        }
    }
}
