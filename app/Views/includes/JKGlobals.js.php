<?php

/**
 * This is an include file that contains the global variables,
 * objects and functions used in the entire website.
 * This file must be included in any page/view
 */
?>
<script>
    //Global Javascript Variables and Methods
    var JKGlobals = {

        baseURL: "<?= base_url() ?>",


        /**
         * REMOTE CONTROLLER OBJECTS AND METHODS
         * 
         * The methods in this section should be used in the remote controller only.
         * Specifically, the select_song.php file
         */

        //reserve a song via remote controller
        reserveSong: function(vid, title) {
            $("#addSongModalContent").html("<strong>" + title + "</strong> is being added to the queue. Please wait...");
            $("#addSongModalConfirmBtn")[0].disabled = true;
            $("#addSongModal").modal({
                backdrop: 'static'
            });

            $.ajax({
                url: this.baseURL + "/select/reserve/" + vid + "/" + title,
                success: function(data) {
                    if (data.status == "success") {
                        $("#addSongModalContent").html("<strong>" + title + "</strong> has been successfully reserved! <i class='fa-solid fa-check text-success'></i>");
                        $("#addSongModalConfirmBtn")[0].disabled = false;
                    } else {
                        $("#addSongModalContent").html("Failed to reserve song. Please try again or contact IT.");
                        $("#addSongModalConfirmBtn")[0].disabled = false;
                    }
                },
                error: function() {
                    $("#addSongModalContent").html("Failed to reserve song. Please check network or contact IT.");
                    $("#addSongModalConfirmBtn")[0].disabled = false;
                }
            });
        },

        //display reserved songs in the remote controller
        getReservedSongs: function() {
            const eventSource = new EventSource('<?= base_url() ?>select/reservations');

            eventSource.onmessage = function(event) {
                let songs = JSON.parse(event.data);
                let html = "<h5 class='text-center mb-2'>Songs in queue: " + songs.length + "</h5>";
                if (songs.length > 1) {
                    html += "<div class='text-center'><a href='javascript:void(0)' onclick='JKGlobals.deleteReservedSongs()'>Clear Queue</a></div>";
                }
                html += "<ol>";
                for (let i = 0; i < songs.length; i++) {
                    html += "<li class='my-2 reserved-song song-" + songs[i].id + "'>" + songs[i].title + "<br>";
                    if (i != 0) {
                        html += "<a class='badge badge-primary' href='javascript:void(0)'>PRIORITIZE</a>  <a class='badge badge-danger' href='javascript:void(0)' onclick='JKGlobals.deleteSong(" + songs[i].id + ")'>REMOVE</a></li>";
                    }
                }
                html += "</ol>"
                $("#reservedSongs").html(html);
            }
        },

        //delete an individual song from the remote controller
        deleteSong: function(songID) {
            document.querySelector(".song-" + songID).classList.remove('reserved-song');
            document.querySelector(".song-" + songID).classList.add('removed-song');
            //run API call to delete the song
            $.ajax({
                url: "<?= base_url() ?>select/delete/" + songID,
                success: function(data) {
                    if (data.status == "success") {
                        toastr.success("Song has been removed!");
                    } else {
                        toastr.error("Failed to remove song.");
                        document.querySelector(".song-" + songID).classList.add('reserved-song');
                        document.querySelector(".song-" + songID).classList.remove('removed-song');
                    }
                },
                error: function() {
                    toastr.error("Failed to remove song.");
                    document.querySelector(".song-" + songID).classList.add('reserved-song');
                    document.querySelector(".song-" + songID).classList.remove('removed-song');
                }
            });
        },

        //show the delete confirmation modal in the remote controller
        deleteReservedSongs: function() {
            $("#deleteReservedSongsModalContent").html("Are you sure to delete all reserved songs?");
            $("#deleteReservedSongsModal").modal({
                backdrop: 'static'
            });
        },

        //handle the deletion of songs in the remote controller
        deleteReservedSongsConfirm: function() {

            //disable the buttons to avoid duplicate actions
            let btns = document.querySelectorAll("#deleteReservedSongsModal .btn");
            btns[0].disabled = true;
            btns[1].disabled = true;
            btns[1].innerHTML = "Deleting...";

            //run API call to delete all songs
            $.ajax({
                url: "<?= base_url() ?>select/clear",
                success: function(data) {
                    if (data.status == "success") {
                        $("#deleteReservedSongsModalContent").html("All reserved songs has been deleted.");
                        $("#deleteReservedSongsModal").modal("hide");
                    } else {
                        $("#deleteReservedSongsModalContent").html("Failed to delete reserved songs. Please try again or contact IT.");
                    }

                    //revert the buttons to original state
                    btns[0].disabled = false;
                    btns[1].disabled = false;
                    btns[1].innerHTML = "Proceed";
                },
                error: function() {
                    $("#deleteReservedSongsModalContent").html("Failed to delete reserved songs. Please check your network or contact IT.");
                    //revert the buttons to original state
                    btns[0].disabled = false;
                    btns[1].disabled = false;
                    btns[1].innerHTML = "Proceed";
                }
            });
        },

        //this method emits an event to pusher and sends a data which contains our command
        executeCommand: function(action) {
            let btns = document.querySelectorAll("#command-btns .button");
            btns[0].disabled = true;
            btns[1].disabled = true;
            btns[2].disabled = true;
            btns[3].disabled = true;
            $.ajax({
                url: "<?= base_url() ?>control/update/" + action,
                complete: function(xhr, status) {
                    if (status == "success") {
                        toastr.success("Command executed");
                    } else {
                        toastr.error("Command failed");
                    }
                    btns[0].disabled = false;
                    btns[1].disabled = false;
                    btns[2].disabled = false;
                    btns[3].disabled = false;
                }
            });
        },

        /**
         * END REMOTE CONTROLLER OBJECTS AND METHODS
         */

        /** ----------------------------------------------------------------------------------------------------------------------------------------------- */

        /**
         * SPEECH SYNTHESIS OBJECTS AND METHODS
         */

        //Speech Synthesis Instance
        speech: new SpeechSynthesisUtterance(),

        //This method handles the speaking
        speak: function(text) {
            this.speech.volume = 1; // Volume (0.0 to 1.0)
            this.speech.rate = 1; // Speaking rate (0.1 to 10)
            this.speech.pitch = 1; // Pitch (0 to 2)
            this.speech.text = text;
            window.speechSynthesis.speak(this.speech);
        },

        /**
         * END SPEECH SYNTHESIS OBJECTS AND METHODS
         */

        /** ----------------------------------------------------------------------------------------------------------------------------------------------- */

        /**
         * VIDEO PLAYER OBJECTS AND METHODS
         * The methods in this section should be used only in the Video Player.
         * Specifically, video_player.php
         */

        //The youtube player instance
        player: {},
        //The reserved songs array
        reservedSongs: [],

        //Hide the splash screen
        hideSplash: function() {
            $("#video-container").fadeOut();
            $("#jk-title-container").fadeOut();
        },

        //Show the splash screen
        showSplash: function() {
            $("#video-container").fadeIn();
            $("#jk-title-container").fadeIn();
        },

        //This method handles the functionality of moving to the next song
        nextVideo: function() {
            //stop the currently playing song
            this.player.stopVideo();
            //if there are more than 1 song in the queue
            if (this.reservedSongs.length > 1) {
                //load the video ID of the next song
                this.player.loadVideoById(this.reservedSongs[1].vid);
                //play the song
                this.player.playVideo();
            }
            //remove the first song from database
            this.removeSong(this.reservedSongs[0].id);
            //remove the first song
            this.reservedSongs.shift();
        },

        //This method handles the functionaity of playing the queue
        startQueue: function() {
            //if there are songs in the queue, play the first one and hide the splash screen
            if (this.reservedSongs.length > 0) {
                //load the video id of the first song
                this.player.loadVideoById(this.reservedSongs[0].vid);
                //play the song
                this.player.playVideo();
                //hide splash screen
                this.hideSplash();
            }
        },

        //this method handles the deletion of a song from the database via the video player
        removeSong: function(songID) {
            //run API call to delete the song
            $.ajax({
                url: "<?= base_url() ?>select/delete/" + songID,
                success: function(data) {
                    console.log(data);
                },
                error: function(e1, e2, e3) {
                    console.log(e1);
                    console.log(e2);
                    console.log(e3);
                }
            });
        },

        //This method is called once the youtube iFrame API has been loaded
        onYouTubeIframeAPIReady: function() {

            this.speak('Welcome to Jettson\'s Karaoke');

            this.player = new YT.Player('youtube-player', {
                height: window.innerHeight - (window.innerHeight * 0.01),
                width: window.innerWidth - (window.innerHeight * 0.01),
                //height: window.innerHeight,
                //width: window.innerWidth,
                playerVars: {
                    "enablejsapi": 1,
                    "origin": "https://www.youtube.com"
                },
                events: {
                    'onReady': this.onPlayerReady,
                    'onStateChange': this.onPlayerStateChange
                }
            });
        },

        //This method is executed once the youtube player is ready
        onPlayerReady: function(event) {

            JKGlobals.speak('The Karaoke Player is now ready');
            //When the player is ready, pull the reserved songs
            $.ajax({
                url: "<?= base_url() ?>select/songs",
                success: function(data) {
                    //store the song list in our global object
                    JKGlobals.reservedSongs = data;
                    JKGlobals.startQueue();
                }
            });
        },

        //This method is executed once the player state changes (paused, stop, play, etc.)
        onPlayerStateChange: function(event) {
            console.log('Playter state change');
        },

        //This method subscribes the browser to our Pusher command-channel
        commandListener() {

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            let channel = this.pusher.subscribe('command-channel');
            channel.bind('command-update', function(data) {
                let cmd = data.command;

                switch (cmd) {
                    case "next":
                        JKGlobals.nextVideo();
                        break;
                    case "pause":
                        JKGlobals.player.pauseVideo();
                        break;
                    case "play":
                        JKGlobals.player.playVideo();
                        break;
                    case "stop":
                        JKGlobals.player.stopVideo();
                        break;
                }
            });
        },

        /**
         * END VIDEO PLAYER OBJECTS AND METHODS
         */


        /** ----------------------------------------------------------------------------------------------------------------------------------------------- */

        /**
         * PUSHER INSTANCE
         * Visit www.pusher.com for more details
         */
        pusher: new Pusher('<?= env('PUSHER_APP_KEY'); ?>', {
            cluster: '<?= env('PUSHER_APP_CLUSTER'); ?>'
        })
    }
</script>