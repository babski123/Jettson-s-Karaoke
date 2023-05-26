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
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="<?= base_url() ?>/public/js/toastr.min.js"></script>
  <script>
    //Global Javascript Variables
    var JKGlobals = {
      baseURL: "<?= base_url() ?>"
    }
  </script>
  <style>
    body {
      background: #1a1a1a;
    }

    .remote {
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .button {
      margin: 5px;
      padding: 5px 12px;
      background-color: #e0e0e0;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #ccc;
    }

    .button:active {
      background-color: #aaa;
    }

    .search-container {
      display: flex;
      justify-content: center;
      margin-bottom: 10px;
    }

    .search-input {
      width: 100%;
      padding: 5px 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>
  <div class="container mt-2">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="remote text-center">
          <h2>Jettson's Karaoke</h2>

          <button class="button">Stop</button>
          <button class="button">Play</button>
          <button class="button">Pause</button>
          <button class="button">Next</button>

          <div class="search-container my-3 mx-2">
            <input id="search" type="text" class="search-input" placeholder="Find a song">
            <button id="find" class="button">Go</button>
          </div>
        </div>

        <div id="results" class="remote jk-hidden mt-2">
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url() ?>/public/js/selectSong.js"></script>
</body>

</html>