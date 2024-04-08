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
        <li>
            <div class="slidecontainer">
                <span id="currentTime">0:00</span>
                <input type="range" min="0" max="100" value="0" class="slider" id="myRange">
                <span id="durationTime">0:00</span>
            </div>
        </li>
        
        
    </ul>
    <audio id="audioPlayer" controls>
        <source src="music/Sneaky-Snitch.mp3" type="audio/mp3">
    </audio>

    <script>
        var audioPlayer = document.getElementById("audioPlayer");
        var slider = document.getElementById("myRange");
        var currentTime = document.getElementById('currentTime');
        var durationTime = document.getElementById('durationTime');

        audioPlayer.addEventListener('timeupdate', function() {
            var percentage = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            slider.value = percentage;
            currentTime.textContent = audioPlayer.currentTime;
            durationTime.textContent = audioPlayer.duration;
        });

        slider.addEventListener('input', function() {
            var seekTime = (slider.value / 100) * audioPlayer.duration;
            audioPlayer.currentTime = seekTime;
        });

        function changeMusic(source, albumCover, songTitle, artist) {
            var audio = document.getElementById('audioPlayer');
            audio.src = source;
            audio.play();

            // aktualizování alba
            var albumCoverImg = document.getElementById('albumCover');
            albumCoverImg.src = albumCover;

            // aktualizování názvu skladby
            var songTitleSpan = document.getElementById('songTitle');
            songTitleSpan.textContent = songTitle;

            // aktualizace interpreta
            var artistSpan = document.getElementById('artist');
            artistSpan.textContent = artist;

            //pauzování hudby
            var audioPlayer = document.getElementById("audioPlayer");

            //nastavení správné ikony
            var playButtonImg = document.getElementById("playButton");
            playButtonImg.src = "pause.png";

            
        }
        function togglePlay() {
            var audioPlayer = document.getElementById("audioPlayer");
            var playButtonImg = document.getElementById("playButton");

            if (audioPlayer.paused) {
                audioPlayer.play();
                playButtonImg.src = "pause.png";
            } else {
                audioPlayer.pause();
                playButtonImg.src = "play.png";
            }
        }             
</script>

</body>