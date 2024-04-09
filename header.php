<body>
    <ul class="sidebar">
        <li><input type="text" placeholder="najdu tam co neznám"></li>
        <li><a href="index.php">Domů</a></li>
        <li><a href="#">Tlačítko</a></li>
        <li><a href="#">Tlačítko</a></li>
        <li><a href="#">Tlačítko</a></li>
    </ul>

    <ul class="topbar">
        <li><img class="blur2" src="play-blur.png">
            <a onClick="togglePlay()"><img id="playButton"src="play.png"></a>
        </li>
        <li><img id="albumCover" src=""></li>
        <li>
            <div id="songInfo">
                <span id="songTitle">nehraje žádná skladba</span> <br> <span id="artist"></span>
            </div>
        </li>
        <li><br><span id="currentTime2">0:00</span></li>
        <li>
            <div  class="slidecontainer">
                <input type="range" min="0" max="100" value="0" class="slider" id="myRange">
            </div>
        </li>
        <li><br><span id="remainingTime">0:00</span></li>
        
        
    </ul>
    <audio id="audioPlayer" controls>
        <source src="music/Sneaky-Snitch.mp3" type="audio/mp3">
    </audio>

    <script src="script.js"></script> 
</body>