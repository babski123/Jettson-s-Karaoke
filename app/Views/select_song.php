<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include("includes/headers.php");
  include("includes/JKGlobals.js.php");
  ?>
  <script>
    //start streaming reserved songs
    JKGlobals.getReservedSongs();

  </script>
  <style>
    body {
      background: #501c0e;
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
  <!-- Add Song Modal -->
  <div class="modal fade" id="addSongModal" tabindex="-1" role="dialog" aria-labelledby="addSongModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSongModalTitle">Reserve a Song</h5>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
        </div>
        <div class="modal-body" id="addSongModalContent">
        </div>
        <div class="modal-footer">
          <button id="addSongModalConfirmBtn" disabled type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Song Modal End -->

  <!-- Delete All Songs Modal -->
  <div class="modal fade" id="deleteReservedSongsModal" tabindex="-1" role="dialog" aria-labelledby="deleteReservedSongsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteReservedSongsModalTitle">Clear the Queue</h5>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
        </div>
        <div class="modal-body" id="deleteReservedSongsModalContent">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="JKGlobals.deleteReservedSongsConfirm()">Proceed</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete All Songs Modal End -->

  <div class="container mt-2">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="remote text-center">
          <h2>Jettson's Karaoke</h2>

          <button class="button">Stop</button>
          <button class="button">Play</button>
          <button class="button">Pause</button>
          <button class="button">Next</button>
          <br>
          <a href="<?= base_url() ?>/privacy">Privacy Policy</a>
          <div class="search-container my-3 mx-2">
            <input id="search" type="text" class="search-input" placeholder="Find a song">
            <button id="find" class="button">Go</button>
          </div>
          <ul class="nav nav-tabs" id="navigation-tabs" role="tablist">
            <li class="nav-item">
              <a class="text-reset nav-link active" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" aria-selected="true">Search Results</a>
            </li>
            <li class="nav-item">
              <a class="text-reset nav-link" id="reservedSongs-tab" data-toggle="tab" href="#reservedSongs" role="tab" aria-controls="reservedSongs" aria-selected="false">Reserved Songs</a>
            </li>
          </ul>
          <div class="tab-content mt-3" id="navigation-tabs-content">
            <div class="tab-pane fade text-left show active" id="results" role="tabpanel" aria-labelledby="results-tab"></div>
            <div class="tab-pane fade text-left" id="reservedSongs" role="tabpanel" aria-labelledby="reservedSongs-tab"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="<?= base_url() ?>/public/js/selectSong.js"></script>
</body>

</html>