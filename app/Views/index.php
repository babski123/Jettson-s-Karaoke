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
            <div class="form-group animate__animated animate__fadeIn">
                <label for="accessCodeInput">Please enter your access code</label>
                <input type="password" class="form-control text-center" id="accessCodeInput" aria-describedby="accessCodeHelp" placeholder="Access Code">
            </div>
            <button type="submit" class="jk-login-btn btn btn-primary">Login</button>
        </div>
    </div>

    <!-- FOOTER SCRIPTS -->
    <script src="<?= base_url() ?>public/js/detectmobilebrowser.js"></script>
    <script src="<?= base_url() ?>public/js/login.js"></script>
    <?php if ($logged_in) : ?>
        <script>
            if (window.mobileCheck()) {
                //if mobile, redirect to the song selection page
                window.location.href = JKGlobals.baseURL + 'select';
            } else {
                //if not, redirect to the videoke player
                window.location.href = JKGlobals.baseURL + 'player';
            }
        </script>
    <?php endif; ?>
    <!-- -->

</body>

</html>