<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Player</title>
</head>
<body>
    <ul class="sidebar">
        <li><input type="text" placeholder="najdu tam co neznám"></li>
        <li><a href="index.php"><img src="home.png">Domů</a></li>
        <li><a id="fullscreenLink" href="#"><img src="squares.png">Fullscreen</a></li>
        <li><a href="library.php"><img src="list.png">Knihovna</a></li>
        <li><a href="info.php"><img src="info.png">Info</a></li>
    </ul>

    <ul class="topbar">
        <li><img class="blur2" src="play-blur.png">
            <a onClick="togglePlay()"><img id="playButton" src="play.png"></a>
            <a onClick="toggleLoop()"><img id="loopButton" src="nonewloop.svg"></a>
        </li>
        <li><img id="albumCover" src=""></li>
        <li id="songinfoli" style="margin-top: 15px;">
            <div id="songInfo">
                <b><span id="songTitle"></span></b><br><span id="artist"></span>
            </div>
        </li>
        <li style="float: right; margin-top: 22px;">
            <span id="currentTime2">0:00</span> / <span id="remainingTime">0:00</span>
        </li>
    </ul>
    <ul class="progress-bar">
        <li>
            <a id="sliderMouseCheck">
                <input type="range" min="0" max="100" value="0" class="slider" id="myRange">
            </a>
        </li>
    </ul>
    <ul class="progress-bar" style="top:-35px;">
        <li>
            <a id="sliderMouseCheck">
                <input type="range" min="0" max="100" value="0" class="volumeSlider" id="myVolume">
            </a>
        </li>
    </ul>
    
    <audio id="audioPlayer" controls>
        <source id="audioSource" src="path/to/your/song.mp3" type="audio/mpeg">
    </audio>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
</body>
</html>
