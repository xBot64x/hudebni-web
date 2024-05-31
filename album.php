<!DOCTYPE html>
<html>

<head>
	<title>Hudba web</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" href="css/styles.css">
	<meta charset="UTF-8">
	<meta name="description" content="hudbaweb">
	<meta name="keywords" content="music, lil vidlák">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<?php require 'header.php';?>
	<div class="main">
		
		<?php
		// Include Composer's autoloader
		require_once 'vendor/autoload.php';

		// Import the getID3 class
		use getID3 as getID3;

		// Directory where your music files are stored
		$musicFolder = 'music';

		// najdi skladbu z alba
		$songs = glob($musicFolder . '/*.mp3');

		// Loop through each song
		foreach ($songs as $song) {
			// Extract metadata using getID3
			$getID3 = new getID3();
			$tags = $getID3->analyze($song);

			// Access metadata like title, artist, album, etc.
			$artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
			$album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';
			$releaseyear = $tags['tags']['id3v2']['year'][0] ?? 'Unknown release year';
			$genre = $tags['tags']['id3v2']['genre'][0] ?? 'Unknown genre';
			
			if ($album == $_GET['id']){
				break;
			}
			else{
				$artist = 'Unknown Artist';
				$album = 'Unknown Album';
				$releaseyear = 'Unknown release year';
				$genre = 'Unknown genre';
			}
		}
		
		$coverPath = 'albums/' . $album . '.jpg';
		if (file_exists($coverPath)){
			$coverImage = $coverPath;
		}
		else {
			$coverImage = 'placeholder.png';
		}

		// Generate HTML for each song
		echo '<div style="width: 100%; margin-right: 50px; margin-top: 50px; display: flex;">';
			echo '<div style="height: unset; float:left;" class="responsive">';
				echo '<div class="gallery">';
					echo '<img class="blur" src="' . $coverImage . '">';
					echo '<img src="' . $coverImage . '">';
				echo '</div>';
			echo '</div>';
			echo '<div style="margin-left: 3%;">';
				echo '<h2>' . htmlspecialchars($album) . '</h2>';
				echo '<a id="artistid" href="artist.php?id=' . htmlspecialchars($artist) . '"><h3>' . htmlspecialchars($artist) . '</h3></a>';
				echo '<p>'. htmlspecialchars($genre) .' · ' . htmlspecialchars($releaseyear) . '</p>';
			echo '</div>';
		echo '</div>';
		?>

	<br><br><br>
	<?php
        // Include Composer's autoloader
        require_once 'vendor/autoload.php';

        // Directory where your music files are stored
        $musicFolder = 'music';

        // Scan the music folder for files
        $songs = glob($musicFolder . '/*.mp3');

        // Loop through each song
        $pass = 0;
        foreach ($songs as $song) {
            // Extract metadata using getID3
            $getID3 = new getID3();
            $tags = $getID3->analyze($song);

            // Access metadata like title, artist, album, etc.
			$album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';
			if($album == $_GET['id']){
				$title = $tags['tags']['id3v2']['title'][0] ?? 'Unknown Title';
				$artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
				$playtime = $tags['playtime_string'] ?? '0:00';

				$coverPath = 'LQ albums/' . $album . '.png';
				if (file_exists($coverPath)){
					$coverImage = $coverPath;
				}
				else {
					$coverImage = 'placeholder.png';
				}
				
				

				$link = substr($song, 6);

				// Generate HTML for each song
				if ($pass % 2 == 0) {
					echo '<div class="skladbadiv skladbadiv3">';
				}
				else {
					echo '<div class="skladbadiv skladbadiv2 skladbadiv3">';
				}
				echo '<div class="like-icon" onclick="toggleLike(this)"></div>';
				echo '<span class="cislo">' . htmlspecialchars($pass + 1) . '</span>';
				echo '<div class="play-icon" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"></div>';
				echo '<a onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"><span class="nazevskladbyspan pc">' . htmlspecialchars($title) . '</span></a>';
				echo '<span>' . htmlspecialchars($playtime) . '</span>';
				echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) . '"><div class="download-icon"></div></a>';
				echo '</div>';

				$pass = $pass + 1;
			}
        }
        ?>


	</div>
	<?php require 'footer.php';?>
    
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</body>
</html>