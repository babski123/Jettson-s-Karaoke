<?php

use Pusher\Pusher;

//Create Pusher instance
function pusher_create()
{
    $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true
    );
    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );

    return $pusher;
}
