<body>
    <ul class="sidebar">
        <li><input type="text" placeholder="najdu tam co neznám"></li>
        <li><a href="index.php">Domů</a></li>
        <li><a href="#">Tlačítko</a></li>
        <li><a href="#">Tlačítko</a></li>
        <li><a href="#">Tlačítko</a></li>
    </ul>

    <ul class="topbar">
        <li><audio id="audioPlayer" controls>
            <source src="music/Sneaky-Snitch.mp3" type="audio/mp3">
        </audio></li>
        <li><img id="albumCover" src=""></li>
        <li><div id="songInfo">
            <span id="songTitle">nehraje žádná skladba</span> <br> <span id="artist"></span>
        </div></li>
        
    </ul>

    <script>
    function changeMusic(source, albumCover, songTitle, artist) {
        var audio = document.getElementById('audioPlayer');
        audio.src = source;
        audio.play();

        // Update album cover
        var albumCoverImg = document.getElementById('albumCover');
        albumCoverImg.src = albumCover;

        // Update song title
        var songTitleSpan = document.getElementById('songTitle');
        songTitleSpan.textContent = songTitle;

        // Update artist
        var artistSpan = document.getElementById('artist');
        artistSpan.textContent = artist;
    }
</script>

</body>