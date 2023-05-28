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
        getReservedSongs: function() {
            const eventSource = new EventSource('<?= base_url() ?>/select/reservations');

            eventSource.onmessage = function(event) {
                let songs = JSON.parse(event.data);
                let html = "<h5 class='text-center mb-4'>Songs in queue: " + songs.length + "</h5>";
                html += "<ol>";
                for(let i = 0; i<songs.length; i++) {
                    html += "<li class='my-2'>" + songs[i].title + "</li>";
                }
                html += "</ol>"
                $("#reservedSongs").html(html);
            }

        }
    }
</script>