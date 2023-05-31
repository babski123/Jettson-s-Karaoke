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

            //send updated list to pusher
            $this->_send_songs_to_pusher();

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
     * This method will send the reserved songs to our Pusher songs-channel
     */
    public function songs()
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {

            $response = $this->_send_songs_to_pusher();

            return $this->respond([
                "status" => "success",
                "songs" => $response
            ]);
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
            $this->_send_songs_to_pusher();

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
            $this->_send_songs_to_pusher();

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

    /**
     * Handles the functionality of prioritizing a song
     * This will stop the current playing song, remove it from DB
     * and play the selected song
     */
    public function prioritize($song_id)
    {
        if (!$this->session->get('logged_in')) {
            //if not logged in, redirect to home page
            return redirect()->to(base_url());
        } else {
            //load the songs model
            $model = new Songs();

            //delete the current playing song from the table (the first row)
            $first = $model->where('access_name', $this->session->get('access_name'))->first();
            if ($first) {
                $model->delete($first['id']);
            }

            //get the detail of the selected song to be prioritized
            $prio = $model->where('id', $song_id)->first();
            //delete the song to be prioritized from the queue
            $model->delete($song_id);
            //get the remaining songs
            $remaining = $model->where('access_name', $this->session->get('access_name'))->findAll();
            //delete the remaining songs
            $model->where('access_name', $this->session->get('access_name'))->delete();
            //insert the priority song
            $model->insert($prio);
            //insert the remaining songs
            foreach ($remaining as $song_data) {
                $model->insert($song_data);
            }
            //send updated list to pusher
            $this->_send_songs_to_pusher("forceplay");

            //return the new list
            $response = [
                'status' => 'success',
                'new_list' => $model->where('access_name', $this->session->get('access_name'))->findAll()
            ];
            return $this->respond($response);
        }
    }

    /**
     * Use this method to send the reserved songs to pusher
     * Returns the list of songs
     */
    protected function _send_songs_to_pusher($command = null)
    {
        //load the pusher helper
        helper('pusher');

        //create the pusher instance
        $pusher = pusher_create();

        //retrieve the list of reserved songs
        $model = new Songs();
        $response = $model->where('access_name', $this->session->get('access_name'))->findAll();

        //send the list to pusher
        $data['songs'] = $response;
        $pusher->trigger('songs-channel', 'songs-update', $data);

        if($command != null) {
            //execute command (optional)
            $data_optional["command"] = $command;
            $pusher->trigger('command-channel', 'command-update', $data_optional);
        }

        return $response;
    }
}
