var audioPlayer = document.getElementById("audioPlayer");
var slider = document.getElementById("myRange");
var volumeSlider = document.getElementById("myVolume");

if (localStorage.getItem("loopvar") === null) {
  localStorage.setItem("loopvar", "false");
}



//set volume from local storage
if (localStorage.getItem("volume") === null) {
  localStorage.setItem("volume", 1);
}
volumeSlider.value = localStorage.getItem("volume") * 100;
audioPlayer.volume = localStorage.getItem("volume");


document.addEventListener('DOMContentLoaded', function() {
  // Retrieve liked songs from localStorage
  var likedSongs = JSON.parse(localStorage.getItem('likedSongs')) || [];

  // Apply liked status to the corresponding like buttons
  var likeButtons = document.querySelectorAll('.like-icon');
  likeButtons.forEach(function(likeButton) {
    
    try {
      var galleryItem = likeButton.closest('.gallery');
      var title = galleryItem.querySelector('.desc b').textContent;
      var artist = galleryItem.querySelector('.desc p').textContent;
    } 
    catch (error) {
      try {
        var galleryItem = likeButton.closest('.skladbadiv');
        var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
        var artist = galleryItem.querySelector('.artistspan').textContent;
      } 
      catch (error) {
        try {
          var title = document.getElementById('titlef').innerHTML;
          var artist = document.getElementById('artistf').innerHTML;
        } 
        catch (error) {
          var galleryItem = likeButton.closest('.skladbadiv');
          var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
          var artist = document.getElementById('artistid').textContent;
        }
      }
    }

    // Check if the current song is in the liked songs array
    var isLiked = likedSongs.some(function(song) {
      return song.title === title && song.artist === artist;
    });
    
    // If liked, add 'liked' class to the like button
    if (isLiked) {
      likeButton.classList.add('liked');
    }
  });

  //check if song was previosly playing and check looping
  if(localStorage.getItem("loopvar") == "true"){
    loop();
  }

  if(localStorage.getItem("playing") == "true"){
    changeMusic(localStorage.getItem("lastsong"));
    audioPlayer.currentTime = localStorage.getItem("sliderprogress");
  }
});

audioPlayer.addEventListener('timeupdate', function(){
  var sliderMax = Math.floor(audioPlayer.duration);
  slider.max = sliderMax;
  var percentage = Math.floor(audioPlayer.currentTime);
  slider.value = percentage;
  localStorage.setItem("sliderprogress", percentage);
  currentTime2.textContent = convertStoMs(audioPlayer.currentTime);
  remainingTime.textContent = "-" + convertStoMs(Math.floor(audioPlayer.duration) - Math.floor(audioPlayer.currentTime));

  if(percentage == sliderMax && localStorage.getItem("loopvar") == true){
    slider.value = 0;
    play();
  }
  else if(percentage == sliderMax){
    pause();
  }
});

slider.addEventListener('input', function() {
  var sliderMax = Math.floor(audioPlayer.duration);
  var seekTime = Math.floor((slider.value / sliderMax) * audioPlayer.duration);
  audioPlayer.currentTime = seekTime;
});

volumeSlider.addEventListener('input', function() {
  var volume = volumeSlider.value / 100;
  audioPlayer.volume = volume;
  localStorage.setItem("volume", volume);
});

function changeMusic(source) {  
  audioPlayer.src = "../" + source;
  localStorage.setItem("lastsong",source)
  play();
  fullscreenLink.href = `fullscreen.php?song=${encodeURIComponent(source.substring(6))}`;
  fullscreenLinkfooter.href = `fullscreen.php?song=${encodeURIComponent(source.substring(6))}`;

  const jsmediatags = window.jsmediatags

  jsmediatags.read(window.location.origin + "/" + source, {
    onSuccess: function(tag) {
      console.log(tag)

      // Output the metadata
      var albumCoverImg = document.getElementById('albumCover');
      albumCoverImg.src = `albums/${tag.tags.album}.jpg`

      var songTitleSpan = document.getElementById('songTitle');
      songTitleSpan.textContent = tag.tags.title

      var titleWidth = $('#songTitle')[0].scrollWidth;
      var songInfoWidth = $('#songInfo')[0].offsetWidth;
      console.log(titleWidth)
      console.log(songInfoWidth)
      if (titleWidth >  songInfoWidth) {
        songTitleSpan.classList.add('marquee-animation-title');
        console.log("ANO");
      } else {
        songTitleSpan.classList.remove('marquee-animation-title');
      }

      var artistSpan = document.getElementById('artist');
      artistSpan.textContent = tag.tags.artist
    },
    onError: function(error) {
      console.log(':(', error.type, error.info);
    }
  })
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

function togglePlay() {
  if (audioPlayer.paused) {
    play()
  } else {
    pause()
  }
}

function toggleLoop() {
  if (localStorage.getItem("loopvar") == "false") {
    loop();
  } else {
    noloop();
    console.log(localStorage.getItem("loopvar"))
  }
}

function play() {
  var promise = audioPlayer.play();

  if (promise !== undefined) {
    promise.then(_ => {
      // Autoplay started!
    }).catch(error => {
      alert("Prosím povolte automatické přehrávání ve vašem prohlížeči v levém horním rohu pro správnou funkci webu.");
      audioPlayer.play();
    });
  }


  playButton.src = "../images/pause.png";
  localStorage.setItem("playing", "true")
}

function pause() {
  audioPlayer.pause();
  playButton.src = "../images/play.png";
  localStorage.setItem("playing", "false")
}

function loop() {
  loopButton.src = "../images/newloop.svg";
  localStorage.setItem("loopvar", "true")
}

function noloop() {
  loopButton.src = "../images/nonewloop.svg";
  localStorage.setItem("loopvar", "false")
}

// vyhledávání na stránce (search)
function filterDivs() {
  // Get the input value
  var inputValue = document.querySelector('input[type="text"]').value.toLowerCase();

  // Get all div elements with the class "responsive"
  var divs = document.querySelectorAll('.responsive');

  var longdivs = document.querySelectorAll('.skladbadiv');

  // Variable to track if any results are found
  var resultsFound = false;

  // Loop through each div
  divs.forEach(function(div) {
    // Get the text content of the div
    var textContent = div.textContent.toLowerCase();

    // Check if the input value is present in the div's text content
    if (textContent.includes(inputValue)) {
      // If yes, show the div
      div.style.display = 'block';
      resultsFound = true; // Set flag to true
    } else {
      // If not, hide the div
      div.style.display = 'none';
    }
  });

  longdivs.forEach(function(div) {
    // Get the text content of the div
    var textContent = div.textContent.toLowerCase();

    // Check if the input value is present in the div's text content
    if (textContent.includes(inputValue)) {
      // If yes, show the div
      div.style.display = 'grid';
      resultsFound = true; // Set flag to true
    } else {
      // If not, hide the div
      div.style.display = 'none';
    }
  });

  // Display message if no results are found
  var messageDiv = document.getElementById('noResultsMessage');
  if (!resultsFound) {
    messageDiv.style.display = 'block'; // Show message
  } else {
    messageDiv.style.display = 'none'; // Hide message
  }
}

// Add event listener to input field for changes
document.querySelector('input[type="text"]').addEventListener('input', filterDivs);


function toggleLike(likeButton) {
  // Check if the song is already liked
  var isLiked = likeButton.classList.contains('liked');

  if (isLiked) {
    // Unlike the song (remove from liked list, change button appearance)
    unlikeSong(likeButton);
  } else {
    // Like the song (save to liked list, change button appearance)
    likeSong(likeButton);
  }
}

function likeSong(likeButton) {
  // Add liked class to the button (change appearance)
  likeButton.classList.add('liked');

  // Get song information from the gallery
  try {
    var galleryItem = likeButton.closest('.gallery');
    var title = galleryItem.querySelector('.desc b').textContent;
    var artist = galleryItem.querySelector('.desc p').textContent;
  } 
  catch (error) {
    try {
      var galleryItem = likeButton.closest('.skladbadiv');
      var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
      var artist = galleryItem.querySelector('.artistspan').textContent;
    } 
    catch (error) {
      try {
        var title = document.getElementById('titlef').innerHTML;
        var artist = document.getElementById('artistf').innerHTML;
      } 
      catch (error) {
        var galleryItem = likeButton.closest('.skladbadiv');
        var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
        var artist = document.getElementById('artistid').textContent;
      }
    }
  }
  
  // Save the liked song to localStorage
  var likedSongs = JSON.parse(localStorage.getItem('likedSongs')) || [];
  likedSongs.push({ title: title, artist: artist });
  localStorage.setItem('likedSongs', JSON.stringify(likedSongs));
}

function unlikeSong(likeButton) {
  // Remove liked class from the button (change appearance)
  likeButton.classList.remove('liked');

  // Get song information from the gallery
  try {
    var galleryItem = likeButton.closest('.gallery');
    var title = galleryItem.querySelector('.desc b').textContent;
    var artist = galleryItem.querySelector('.desc p').textContent;
  } 
  catch (error) {
    try {
      var galleryItem = likeButton.closest('.skladbadiv');
      var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
      var artist = galleryItem.querySelector('.artistspan').textContent;
    } 
    catch (error) {
      try {
        var title = document.getElementById('titlef').innerHTML;
        var artist = document.getElementById('artistf').innerHTML;
      } 
      catch (error) {
        var galleryItem = likeButton.closest('.skladbadiv');
        var title = galleryItem.querySelector('.nazevskladbyspan').textContent;
        var artist = document.getElementById('artistid').textContent;
      }
    }
  }

  // Retrieve liked songs from localStorage
  var likedSongs = JSON.parse(localStorage.getItem('likedSongs')) || [];

  // Remove the song from the liked songs array
  likedSongs = likedSongs.filter(function(song) {
    return !(song.title === title && song.artist === artist);
  });

  // Update localStorage with the modified liked songs array
  localStorage.setItem('likedSongs', JSON.stringify(likedSongs));
}

