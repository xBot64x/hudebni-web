<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Hudba web - fullscreen</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="description" content="hudbaweb">
    <meta name="keywords" content="music, lil vidlák">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="overflow: hidden; transition: background-color 1s ease;">
<div class="center">
    
    <?php
        // Include Composer's autoloader
        require_once 'vendor/autoload.php';

        $song = "music/" . $_GET['song'];

        // Import the getID3 class
        use getID3 as getID3;

        // Directory where your music files are stored
        $musicFolder = 'music';

        // Scan the music folder for files

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
    ?>

    <?php echo '<img class="fullscreenblur" src="' . $coverImage . '">'; ?>
    <?php echo '<img id="cover" src="' . $coverImage . '">'; ?>
    <?php echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) . '"><div class="download-icon"></div></a>'; ?>
    
    <div class="controls">
        <div class="titles">
            <?php
            echo '<span id="titlef" style="font-weight: bold; padding-bottom: 10px; display:block;">' . htmlspecialchars($title) . '</span>';
            echo '<span id="artistf" style="opacity: 65%; padding-bottom: 5px; display:block;">' . htmlspecialchars($artist) . '</span>';
            ?>
        </div>
        <div class="progress-bar">
            <span id="currentTime2">0:00</span>
            <input type="range" min="0" max="100" value="0" class="fullscreen" id="myRange">
            <span id="remainingTime">0:00</span>
        </div>
        <ul class="gaps">
            <li style="float:left;padding-left: 5px;">
                <div class="like-icon" onclick="toggleLike(this)"></div>
            </li>
            <li style="display: inline-block;">
                <div class="buttons">
                    <a onClick="togglePlay()"><img id="playButton" src="play.png"></a>
                    <a onClick="toggleLoop()"><img id="loopButton" src="nonewloop.svg"></a>
                </div>  
            </li>
            <li style="float:right;padding-right: 5px;">
                <?php echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) .'"><div class="download-icon"></div></a>'; ?>
            </li>
        </ul>
        
        
    </div>

    <audio id="audioPlayer" controls>
        <source src="<?php echo "music/" . htmlspecialchars($_GET['song']); ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</div>


<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
<script>
    const colorThief = new ColorThief();
    const img = document.querySelector('#cover');

    // Make sure image is finished loading
    if (img.complete) 
    {
        const color = colorThief.getColor(img);
        const rgbColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        document.body.style.backgroundColor = rgbColor;
    } 
    else 
    {
        image.addEventListener('load', function() {
            const color = colorThief.getColor(img);
            const rgbColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
            document.body.style.backgroundColor = rgbColor;
        });
    }
    
</script>

</body>
</html>