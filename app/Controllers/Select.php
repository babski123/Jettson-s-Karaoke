<?php

/**
 * This controller handles the functionality of
 * Searchings songs, reserving songs, removing songs
 * checking the queue, and etc.
 */

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\Songs;

class Select extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //here, we return the song selection page view
            return view('select_song');
        }
    }

    public function reserve($video_id, $title)
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //add song to the queue

            //load the Songs model
            $model = new Songs();
            $data = [
                'title' => $title,
                'vid' => $video_id
            ];

            //insert the song to db
            $result = $model->insert($data);

            if ($result) {
                $response = [
                    'status' => 'success',
                    'song_detail' => $data
                ];

                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 'failure',
                    'song_detail' => $data
                ];

                return $this->fail($response);
            }
        }
    }
}
