<?php

/**
 * This controller handles the functionality of
 * Searchings songs, reserving songs, removing songs
 * checking the queue, and etc.
 */

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

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
            $data = [
                'video_id' => $video_id,
                'title' => $title
            ];

            return $this->respond($data);
        }
    }
}
