<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= config("Settings")->websiteName; ?></title>
    <meta name="description" content="A web-based Karaoke built using the Youtube API Services">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="public/favicon.ico" />

    <!-- STYLES -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/css/bootstrap4.3.1.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/public/css/toastr.min.css">

    <!-- HEADER SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/public/js/toastr.min.js"></script>
    <?php include("includes/JKGlobals.php"); ?>
    <style>
        body {
            background-image: url('<?= base_url() ?>/public/images/index_bg.jpg');
        }
    </style>
</head>

<body>
    <div class="container login-form-parent">
        <div class="login-form animate__animated animate__fadeIn">
            <img src="<?= base_url() ?>/public/images/logo.png" class="img-fluid mb-4" alt="Logo">
            <div class="form-group animate__animated animate__fadeIn">
                <label for="accessCodeInput">Please enter your access code</label>
                <input type="password" class="form-control text-center" id="accessCodeInput" aria-describedby="accessCodeHelp" placeholder="Access Code">
            </div>
            <button type="submit" class="jk-login-btn btn btn-primary">Login</button>
        </div>
    </div>

    <!-- FOOTER SCRIPTS -->
    <script src="<?= base_url() ?>/public/js/detectmobilebrowser.js"></script>
    <script src="<?= base_url() ?>/public/js/login.js"></script>
    <script>
    </script>

    <!-- -->

</body>

</html>