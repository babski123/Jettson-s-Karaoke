<?php

/**
 * This is an include file that contains the global variables,
 * objects and functions used in the entire website.
 * This file must be included in any page/view
 */
?>
<script>
    //Global Javascript Variables
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
                    html += "<li class='my-2'>" + songs[i].title + "</li>";
                }
                html += "</ol>"
                $("#reservedSongs").html(html);
            }
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
        }

    }
</script>