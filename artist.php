<!DOCTYPE html>
<html>

<head>
	<title>Hudba web</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" href="css/styles.css">
	<meta charset="UTF-8">
	<meta name="description" content="Nalezněte skvělé skladby pro komerční i hobby použití. Užjte si stylové prostředí Hudba webu a poslouchejte své oblíbené umělce.">
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
		$songus = 'music/' . $_GET['id'];

		$songs = glob($musicFolder . '/*.mp3');

		// Loop through each song
		foreach ($songs as $song) {
			// Extract metadata using getID3
			$getID3 = new getID3();
			$tags = $getID3->analyze($song);

			// Access metadata like title, artist, album, etc.
			$artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
			
			if ($artist == $_GET['id']){
				break;
			}
			else{
				$artist = 'Unknown Artist';
			}
		}
		
		$coverPath = 'artists/' . $artist . '.jpg';
		if (file_exists($coverPath)){
			$coverImage = $coverPath;
		}
		else {
			$coverImage = 'placeholder.png';
		}

		// Generate HTML for artist
		echo '<div style="width: 100%; margin-right: 50px; margin-top: 50px; padding-bottom: 30px; display: flex;">';
				echo '<div style="height: unset; float:left;" class="responsive">';
				echo '<div class="gallery">';
					echo '<img class="blur artist" src="' . $coverImage . '">';
					echo '<img class="artist" src="' . $coverImage . '">';
				echo '</div>';
			echo '</div>';
			echo '<div style="margin-left: 3%;">';
				echo '<h1 id="artistid">' . htmlspecialchars($artist) . '</h1>';
			echo '</div>';
		echo '</div>';
		?>


	<h1>Alba</h1>
	<div style="overflow:hidden">
        <?php
        // Include Composer's autoloader
        require_once 'vendor/autoload.php';

        // Directory where your music files are stored
        $musicFolder = 'music';

        $albumsAlready = array();

        // Scan the music folder for files
        $songs = glob($musicFolder . '/*.mp3');

        // Loop through each song
        foreach ($songs as $song) {
            $getID3 = new getID3();
            $tags = $getID3->analyze($song);

            $artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
			if ($artist == $_GET['id']){
				$album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';

				if (in_array($album,$albumsAlready) != true){
					$albumsAlready[] = $album;

					$coverPath = 'albums/' . $album . '.jpg';
					if (file_exists($coverPath)){
						$coverImage = $coverPath;
					}
					else {
						$coverImage = 'placeholder.png';
					}
					
						
					// Generate HTML for each song
					echo '<div class="responsive">';
						echo '<div class="gallery">';
							echo '<img class="blur" src="' . $coverImage . '">';
							echo '<a href="album.php?id=' . $album . '">';
							echo '<img src="' . $coverImage . '">';
							echo '</a>';
							echo '<div class="desc">';
								echo '<b>' . htmlspecialchars($album) . '</b>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			}  
        }
        ?>
	</div>

	<h1>Skladby</h1>	
	<div style="overflow:hidden">
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
				$artist = $tags['tags']['id3v2']['artist'][0] ?? 'Unknown Artist';
				if($artist == $_GET['id']){
					$title = $tags['tags']['id3v2']['title'][0] ?? 'Unknown Title';
					$album = $tags['tags']['id3v2']['album'][0] ?? 'Unknown Album';
					$playtime = $tags['playtime_string'] ?? '0:00';
					$releaseyear = $tags['tags']['id3v2']['year'][0] ?? 'Unknown release year';

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
						echo '<div class="skladbadiv">';
					}
					else {
						echo '<div class="skladbadiv skladbadiv2">';
					}
					echo '<div class="like-icon" onclick="toggleLike(this)"></div>';
					echo '<img class="coverskladba" src="' . $coverImage . '">';
					echo '<div class="play-icon" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"></div>';

					echo '<a class="pc" onclick="changeMusic(\'music/' . htmlspecialchars(basename($song)) . '\')"><span class="nazevskladbyspan">' . htmlspecialchars($title) . '</span></a>';
					echo '<a class="pc" href="artist.php?id=' . htmlspecialchars($artist) . '"><span class="artistspan">' . htmlspecialchars($artist) . '</span></a>';
					echo '<a class="pc" href="album.php?id=' . htmlspecialchars($album) . '"><span>' . htmlspecialchars($album) . '</span></a>';

					echo '<div class="mobil">';
						echo '<span class="nazevskladbyspan">' . htmlspecialchars($title) . '</span>';
						echo '<div>';
							echo '<a href="artist.php?id=' . htmlspecialchars($artist) . '"><span class="artistspan">' . htmlspecialchars($artist) . '</span></a> · ';
							echo '<a href="album.php?id=' . htmlspecialchars($album) . '"><span>' . htmlspecialchars($album) . '</span></a>';
						echo '</div>';
					echo '</div>';

					echo '<span class="playtime">' . htmlspecialchars($playtime) . '</span>';
					echo '<a href="' . htmlspecialchars($song) . '" download="' . htmlspecialchars($title) . ' - ' . htmlspecialchars($artist) . '"><div class="download-icon"></div></a>';
					echo '</div>';
		
					$pass = $pass + 1;
				}
			}
			?>

		</div>

	</div>
	<!-- megagay  https://www.youtube.com/watch?v=FI7DdOxCLaI -->
	<?php require 'footer.php';?>
    
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</body>
</html>