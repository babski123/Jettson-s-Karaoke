<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("includes/headers.php");
    include("includes/JKGlobals.js.php");
    ?>
    <style>
        body {
            background-color: #000;
        }
        #video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        #video-player {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .jk-title {
            font-size: 200px;
            color: rgb(187 255 255);
            -webkit-text-stroke: 2px #000;
            text-shadow: -5px 7px #23287a;
        }

        .jk-title-container {
            position: fixed;
            width: 100%;
            z-index: 2;
        }

        @keyframes float {
            0% {
                box-shadow: 0 5px 15px 0px rgba(0, 0, 0, 0.6);
                transform: translatey(0px);
            }

            50% {
                box-shadow: 0 25px 15px 0px rgba(0, 0, 0, 0.2);
                transform: translatey(-20px);
            }

            100% {
                box-shadow: 0 5px 15px 0px rgba(0, 0, 0, 0.6);
                transform: translatey(0px);
            }
        }

        /* animation: float 6s ease-in-out infinite; */
    </style>
</head>

<body>
    <div id="video-container">
        <video id="video-player" autoplay loop muted>
            <source src="<?= base_url() ?>/public/videos/background_video.mp4" type="video/mp4">
        </video>
    </div>

    <div id="jk-title-container" class="jk-title-container">
        <h1 class="text-center jk-title animate__animated animate__bounceInDown animate__delay-1s">Jettson's<br>Karaoke</h1>
    </div>

    <div id="youtube-player">
    </div>

    <!-- FOOTER SCRIPTS -->
    <script>
        //load the Youtube iFRAME API Asynchronously
        let tag = document.createElement("script");
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        function onYouTubeIframeAPIReady() {
            JKGlobals.onYouTubeIframeAPIReady();
        }
    </script>
    <!-- FOOTER SCRIPTS END -->

</body>

</html>