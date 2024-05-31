<!DOCTYPE html>
<html>

<head>
    <title>Hudba web</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <meta charset="UTF-8">
    <meta name="description" content="hudbaweb">
    <meta name="keywords" content="music, lil vidlák">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
    <?php require 'header.php';?>
    <div class="main">
        <h2>Všechny skladby</h2>
        
        <?php
        // Include Composer's autoloader
        require_once 'vendor/autoload.php';

        // Directory where your music files are stored
        $musicFolder = 'music';

        // Scan the music folder for files
        $songs = glob($musicFolder . '/*.mp3');

        // Loop through each song
        $pass = 0;
        foreach ($songs as $song) {
            // Extract metadata using getID3
            $getID3 = new getID3();
            $tags = $getID3->analyze($song);

            // Access metadata like title, artist, album, etc.
            $title = $tags['tags']['id3v2']['title'][0] ?? 'Unknown Title';
            $artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
            $album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';
            $playtime = $tags['playtime_string'] ?? '0:00';

            $coverPath = 'LQ albums/' . $album . '.png';
            if (file_exists($coverPath)){
                $coverImage = $coverPath;
            }
            else {
                $coverImage = 'placeholder.png';
            }
            
            

            $link = substr($song, 6);

            // Generate HTML for each song
            if ($pass % 2 == 0) {
                echo '<div class="skladbadiv">';
            }
            else {
                echo '<div class="skladbadiv skladbadiv2">';
            }
            echo '<div class="like-icon" onclick="toggleLike(this)"></div>';
            echo '<img class="coverskladba" src="' . $coverImage . '">';
            echo '<div class="play-icon" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"></div>';

            echo '<a class="pc" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"><span class="nazevskladbyspan">' . htmlspecialchars($title) . '</span></a>';
            echo '<a class="pc" href="artist.php?id=' . htmlspecialchars($artist) . '"><span class="artistspan">' . htmlspecialchars($artist) . '</span></a>';
            echo '<a class="pc" href="album.php?id=' . htmlspecialchars($album) . '"><span>' . htmlspecialchars($album) . '</span></a>';

            echo '<div class="mobil">';
                echo '<span class="nazevskladbyspan">' . htmlspecialchars($title) . '</span>';
                echo '<div>';
                    echo '<a href="artist.php?id=' . htmlspecialchars($artist) . '"><span class="artistspan">' . htmlspecialchars($artist) . '</span></a> · ';
                    echo '<a href="album.php?id=' . htmlspecialchars($album) . '"><span>' . htmlspecialchars($album) . '</span></a>';
                echo '</div>';
            echo '</div>';

            echo '<span class="playtime">' . htmlspecialchars($playtime) . '</span>';
            echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) . '"><div class="download-icon"></div></a>';
            echo '</div>';

            $pass = $pass + 1;
        }
        ?>

        <div id="noResultsMessage" style="display: none;">Nenalezeny žádné výsledky</div>

    </div>
    <?php require 'footer.php';?>
    
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</body>

</html>