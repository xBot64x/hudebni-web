<!DOCTYPE html>
<html>

<head>
    <title>Hudba web</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="description" content="hudbaweb">
    <meta name="keywords" content="music, lil vidlák">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php require 'header.php';?>
    <div class="main">
        <h2>Prozkoumejte tyto novinky</h2>
        <?php
        // Include Composer's autoloader
        require_once 'vendor/autoload.php';

        // Import the getID3 class
        use getID3 as getID3;

        // Directory where your music files are stored
        $musicFolder = 'music';

        // Scan the music folder for files
        $songs = glob($musicFolder . '/*.mp3');

        // Loop through each song
        foreach ($songs as $song) {
            // Extract metadata using getID3
            $getID3 = new getID3();
            $tags = $getID3->analyze($song);

            // Access metadata like title, artist, album, etc.
            $title = $tags['tags']['id3v2']['title'][0] ?? 'Unknown Title';
            $artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
            $album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';
            
            if(isset($tags['comments']['picture'][0])){
                $coverImage='data:'.$tags['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($tags['comments']['picture'][0]['data']);
            }

            $link = substr($song, 6);

            // Generate HTML for each song
            echo '<div class="responsive">';
            echo '<div class="gallery">';
            echo '<img class="blur" src="' . $coverImage . '">';
            echo '<a href="song.php?id=' . $link . '">';
            echo '<img src="' . $coverImage . '">';
            echo '</a>';
            echo '<div class="play-icon" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"></div>';
            echo '<div class="like-icon" onclick="toggleLike(this)"></div>';
            echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) . '"><div class="download-icon"></div></a>';
            echo '<div class="desc">';
            echo '<b>' . htmlspecialchars($title) . '</b>';
            echo '<p>' . htmlspecialchars($artist) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
        <div id="noResultsMessage" style="display: none;">Nenalezeny žádné výsledky</div>

    </div>
    <?php require 'footer.php';?>
    
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</body>

</html>