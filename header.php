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
        <li><a href="index.php"><img src="../images/home.png">Domů</a></li>
        <li><a href="skladby.php"><img src="../images/list.png">Skladby</a></li>
        <li><a href="alba.php"><img src="../images/list.png">Alba</a></li>
        <li><a id="fullscreenLink" href="#"><img src="../images/squares.png">Fullscreen</a></li>
        <li><a href="library.php"><img src="../images/white-liked-icon.svg">Knihovna</a></li>
        <li><a href="info.php"><img src="../images/info.png">Info</a></li>
    </ul>

    <ul class="topbar">
        <li><img class="blur2" src="../images/play-blur.png">
            <a onClick="togglePlay()"><img id="playButton" src="../images/play.png"></a>
            <a onClick="toggleLoop()"><img id="loopButton" src="../images/nonewloop.svg"></a>
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
            <!--<img src="images/volume-min.svg">-->
        </li>
        <li>
            <a id="sliderMouseCheck">
                <input type="range" min="0" max="100" value="0" class="volumeSlider" id="myVolume">
            </a>
        </li>
    </ul>
    
    <audio id="audioPlayer" controls></audio>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
</body>
</html>
