var audioPlayer = document.getElementById("audioPlayer");
var slider = document.getElementById("myRange");

audioPlayer.addEventListener('timeupdate', function(){
    var sliderMax = Math.floor(audioPlayer.duration);
    slider.max = sliderMax;
    var percentage = Math.floor(audioPlayer.currentTime);
    slider.value = percentage;
    currentTime2.textContent = convertStoMs(audioPlayer.currentTime);
    remainingTime.textContent = convertStoMs(Math.floor(audioPlayer.duration) - Math.floor(audioPlayer.currentTime));
    console.log(audioPlayer.currentTime)
    console.log("audioPlayer.currentTime: ",audioPlayer.currentTime);
    
});

slider.addEventListener('input', function() {
    var sliderMax = Math.floor(audioPlayer.duration);
    var seekTime = Math.floor((slider.value / sliderMax) * audioPlayer.duration);
    audioPlayer.currentTime = seekTime;
});

function changeMusic(source, albumCover, songTitle, artist) {  
    audioPlayer.src = source;
    audioPlayer.play();

    // Update album cover
    var albumCoverImg = document.getElementById('albumCover');
    albumCoverImg.src = albumCover;

    // Update song title
    var songTitleSpan = document.getElementById('songTitle');
    songTitleSpan.textContent = songTitle;

    // Update artist
    var artistSpan = document.getElementById('artist');
    artistSpan.textContent = artist;

    // Change play button icon
    var playButtonImg = document.getElementById("playButton");
    playButtonImg.src = "pause.png";   
}

function togglePlay() {
    if (audioPlayer.paused) {
        audioPlayer.play();
        playButton.src = "pause.png";
    } else {
        audioPlayer.pause();
        playButton.src = "play.png";
    }
}

function convertStoMs(seconds) {
    let minutes = Math.floor(seconds / 60);
    let extraSeconds = Math.floor(seconds % 60);
    minutes = minutes < 10 ? minutes : minutes;
    extraSeconds = extraSeconds < 10 ? "0" + extraSeconds : extraSeconds;
    return minutes + ':' + extraSeconds;
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
      if ((new Date().getTime() - start) > milliseconds){
        break;
      }
    }
  }