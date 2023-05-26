<?php

/**
 * This controller handles the authentication functionality
 * If the access code provided by the user is valid, session is set
 * else, return an error
 */

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\AccessCodes;

class Auth extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $model = new AccessCodes();
        $code = $this->request->getPost('code');
        $result = $model->where('code', $code)->findAll();

        $this->response->setContentType('application/json');

        if (count($result) > 0) {
            $message = [
                'status' => 'success'
            ];
            $this->session->set('logged_in', true);
            $this->session->set('access_name', $result[0]['name']);
        } else {
            $message = ['status' => 'failure'];
        }

        return $this->respond($message);
    }
}
