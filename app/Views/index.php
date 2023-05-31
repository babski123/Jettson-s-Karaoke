<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("includes/headers.php");
    include("includes/JKGlobals.js.php");
    ?>
    <style>
        body {
            background-image: url('<?= base_url() ?>public/images/index_bg.jpg');
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div class="container login-form-parent">
        <div class="login-form animate__animated animate__fadeIn">
            <img src="<?= base_url() ?>public/images/logo.png" class="img-fluid mb-4" alt="Logo">
            <?php if (!$logged_in) : ?>
                <div class="form-group animate__animated animate__fadeIn">
                    <label for="accessCodeInput">Please enter your access code</label>
                    <input type="password" class="form-control text-center" id="accessCodeInput" aria-describedby="accessCodeHelp" placeholder="Access Code">
                </div>
                <button type="submit" class="jk-login-btn btn btn-primary">Login</button>

            <?php else : ?>
                <div class="form-group animate__animated animate__fadeIn jk-hidden">
                    <label for="accessCodeInput">Please enter your access code</label>
                    <input type="password" class="form-control text-center" id="accessCodeInput" aria-describedby="accessCodeHelp" placeholder="Access Code">
                </div>
                <button type="submit" class="jk-login-btn btn btn-primary jk-hidden">Login</button>
                <button id="startButton" class="btn btn-primary btn-lg">Start</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- FOOTER SCRIPTS -->
    <script src="<?= base_url() ?>public/js/detectmobilebrowser.js"></script>
    <script src="<?= base_url() ?>public/js/login.js"></script>
    <?php include("includes/footers.php"); ?>
    <!-- -->

</body>

</html>