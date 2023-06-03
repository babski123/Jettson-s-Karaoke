
# Youtube-OKE

A web-based karaoke built on top of the Youtube API Services.

- Backend: CodeIgniter4
- Frontend: Bootstrap, Vanilla JS, jQuery
- Communication Service: Pusher (https://pusher.com)


## Installation

Clone this repo or download it to your desired project directory

    1. Navigate to the root directory and run `composer install`
    2. Edit `app/Config/App.php`
    3. Change `$baseURL` to your base URL
    4. Edit `app/Config/Database.php`
    5. Add your database details
    6. That's it!
## Development/Production Modes
For dev/prod mode, just edit the .env file in the root directory.
Go to line 17 and comment it out for prod mode, uncomment it for dev mode
## Documentation

You must first create an access code in the database, use the access code to login.

The videoke player must be accessed in a desktop, the application will automatically redirect the user to `/player` if using a desktop.

The remote control must be accessed via a mobile device's browser. The application will automatically redirect the user to `/select` if using a mobile browser.

### How to select a song?
    1. Access the app via mobile browser
    2. Search for your desired song
    3. Click the song from the search results and it will then be added to the queue
    4. The selected song will then be played automatically in the videoke player
    5. You can add more songs to the queue and it will be played automatically after the currently paying video has ended
    6. The remote control has buttons you can use to either stop, pause, play or next.



## Demo

Live demo: https://mayly.x10host.com


## Authors

- [@babski123](https://github.com/babski123) - eleazer.ababa181@gmail.com

