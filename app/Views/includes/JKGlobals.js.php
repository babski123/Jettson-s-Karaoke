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

        //reserve a song
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

        //display reserved songs
        getReservedSongs: function() {
            const eventSource = new EventSource('<?= base_url() ?>/select/reservations');

            eventSource.onmessage = function(event) {
                let songs = JSON.parse(event.data);
                let html = "<h5 class='text-center mb-2'>Songs in queue: " + songs.length + "</h5>";
                if (songs.length > 1) {
                    html += "<div class='text-center'><a href='javascript:void(0)' onclick='JKGlobals.deleteReservedSongs()'>Clear Queue</a></div>";
                }
                html += "<ol>";
                for (let i = 0; i < songs.length; i++) {
                    html += "<li class='my-2 reserved-song song-" + songs[i].id + "'>" + songs[i].title + "<br><a class='badge badge-primary' href='javascript:void(0)'>PRIORITIZE</a>  <a class='badge badge-danger' href='javascript:void(0)' onclick='JKGlobals.deleteSong(" + songs[i].id + ")'>REMOVE</a></li>";
                }
                html += "</ol>"
                $("#reservedSongs").html(html);
            }
        },

        //delete an individual song
        deleteSong: function(songID) {
            document.querySelector(".song-" + songID).classList.remove('reserved-song');
            document.querySelector(".song-" + songID).classList.add('removed-song');
            //run API call to delete the song
            $.ajax({
                url: "<?= base_url() ?>/select/delete/" + songID,
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

        //show the delete confirmation modal
        deleteReservedSongs: function() {
            $("#deleteReservedSongsModalContent").html("Are you sure to delete all reserved songs?");
            $("#deleteReservedSongsModal").modal({
                backdrop: 'static'
            });
        },

        //handle the deletion of songs
        deleteReservedSongsConfirm: function() {

            //disable the buttons to avoid duplicate actions
            let btns = document.querySelectorAll("#deleteReservedSongsModal .btn");
            btns[0].disabled = true;
            btns[1].disabled = true;
            btns[1].innerHTML = "Deleting...";

            //run API call to delete all songs
            $.ajax({
                url: "<?= base_url() ?>/select/clear",
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

        //The youtube player instance
        player: {},
        //The reserved songs array
        reservedSongs: [],

        //Hide the splash screen
        hideSplash: function() {
            $("#video-container").fadeToggle();
            $("#jk-title-container").fadeToggle();
        },

        //This method handles the functionality of moving to the next song
        nextVideo: function() {
            
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
                url: "<?= base_url() ?>/select/songs",
                success: function(data) {
                    //store the song list in our global object
                    JKGlobals.reservedSongs = data;

                    //if there are songs in the queue, play the first one and hide the splash screen
                    if(data.length>0) {
                        JKGlobals.player.loadVideoById(data[0].vid);
                        JKGlobals.player.playVideo();
                        JKGlobals.hideSplash();
                    }
                }
            });
        },

        //This method is executed once the player state changes (paused, stop, play, etc.)
        onPlayerStateChange: function(event) {
            console.log('Playter state change');
        }

    }
</script>