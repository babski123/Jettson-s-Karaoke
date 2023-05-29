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

    /**
     * Displays the song selection UI
     */
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

    /**
     * Handles the functionality of reserving songs
     */
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
                'vid' => $video_id,
                'access_name' => $this->session->get('access_name')
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

    /**
     * Returns the list of reserved songs as a JSON data
     * via Server Sent Events
     */
    public function reservations()
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //return the reserved songs via SEE

            //set headers
            $this->response->setHeader('Content-Type', 'text/event-stream')
                ->setHeader('Cache-Control', 'no-cache')
                ->setHeader('Connection', 'keep-alive');

            $model = new Songs();
            $response = $model->where('access_name', $this->session->get('access_name'))->findAll();

            //send initial response
            echo "data: " . json_encode($response) . "\n\n";
        }
    }

    /**
     * Handles the deletion of all songs in the queue
     * of the currently logged-in user
     */
    public function clear()
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //load the Songs model
            $model = new Songs();

            //delete the reserved songs
            $result = $model->where('access_name', $this->session->get('access_name'))->delete();

            if ($result) {
                $response = [
                    'status' => 'success'
                ];
                return $this->respondDeleted($response);
            } else {
                $response = [
                    'status' => 'failure'
                ];
                return $this->fail($response);
            }
        }
    }

    /**
     * Handles the deletion of an individual song from the queue
     * based on song id
     */
    public function delete($song_id)
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //load the Songs model
            $model = new Songs();

            //delete the song
            $result = $model->where('id', $song_id)->delete();

            if ($result) {
                $response = [
                    'status' => 'success',
                    'deleted_id' => $song_id
                ];
                return $this->respondDeleted($response);
            } else {
                $response = [
                    'status' => 'failure'
                ];
                return $this->fail($response);
            }
        }
    }
}
