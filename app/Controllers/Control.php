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

            /**
             * This section is commented out only for future references
             * Pusher is a better option
             * 
             */

            /*

            //disable output buffer
            ob_end_flush();

            //set headers
            $this->response->setHeader('Content-Type', 'text/event-stream');
            $this->response->setHeader('Cache-Control', 'no-cache');
            $this->response->setHeader('Connection', 'keep-alive');

            //Send headers to the client
            $this->response->sendHeaders();

            $model = new Command();
            $result = $model->first();

            echo "data: " . json_encode($result) . "\n\n";

            $ii = 0;
            while (true) {
                echo 'data: {"event_counter": ' . $ii++ . "}\n\n";
                ob_flush();
                flush();
                sleep(1);
            }

             */

            return $this->fail(["message" => "function migrated"]);
        }
    }

    public function update($action)
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {

            $response = [
                'status' => 'success',
                'command' => $action
            ];

            helper('pusher');

            $pusher = pusher_create();

            $data['command'] = $action;
            $pusher->trigger('command-channel', 'command-update', $data);

            return $this->respondCreated($response);
        }
    }
}
