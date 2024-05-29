document.addEventListener('DOMContentLoaded', function() {
  // Retrieve liked songs from localStorage
  var likedSongs = JSON.parse(localStorage.getItem('likedSongs')) || [];

  // Apply liked status to the corresponding like buttons
  var likeButtons = document.querySelectorAll('.like-icon');
  likeButtons.forEach(function(likeButton) {
    try {
      var galleryItem = likeButton.closest('.responsive');
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
        var title = document.getElementById('titlef').innerHTML;
        var artist = document.getElementById('artistf').innerHTML;
      }
    }

    // Check if the current song is in the liked songs array
    var isLiked = likedSongs.some(function(song) {
      return song.title === title && song.artist === artist;
    });

    // If liked, add 'liked' class to the like button
    if (!isLiked) {
      galleryItem.style.display = 'none';
    }
  });
});