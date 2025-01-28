
<?php
session_start();
var_dump($_SESSION);  // Debug: Check the session variables
?>
<?php
// Example of dynamic data that can be fetched from a database or an API
// Replace this with actual data if needed
$animeTitle = 'Solo Leveling'; // Title of the anime
$animeImage = 'https://cdn.myanimelist.net/images/anime/1801/142390.jpg'; // Poster image URL
$animeDescription = 'Sung Jin-Woo is an E-rank hunter dubbed as the weakest hunter of all mankind. While exploring a supposedly safe dungeon, he and his party encounter an unusual tunnel leading to a deeper area. Enticed by the prospect of treasure, the group presses forward, only to be confronted with horrors beyond their imagination. Miraculously, Jin-Woo survives the incident and soon finds that he now has access to an interface visible only to him. This mysterious system promises him the power he has long dreamed of—but everything comes at a price..';
$animeYear = '2022';
$animeGenres = ['Action', 'Comedy', 'Drama', 'Mystery'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $animeTitle; ?></title>
    <meta name="description" content="<?php echo $animeDescription; ?>">

    <link rel="shortcut icon" type="image/png" href="/images/logo_size_invert.jpg">
    <link rel="import" href="https://animeparadise.org/apis/fetchseries.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@algolia/algoliasearch-netlify-frontend@1/dist/algoliasearchNetlify.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@algolia/algoliasearch-netlify-frontend@1/dist/algoliasearchNetlify.js"></script>
  <script src="/scripts/snow.js" defer></script> <!-- Path to snow.js -->
    <!-- Site Search 360 -->
    <script type="text/javascript">
        var ss360Config = {
           siteId: 'kaalinks.xyz',
           searchBox: {
              selector: '#searchBox'
           }
        }
    </script>
    <script src="https://cdn.sitesearch360.com/v13/sitesearch360-v13.min.js" defer></script>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="/animestyle.css">
</head>
<body>
    <header>
        <a href="#" class="logo"><img src="/images/logo_size_invert.jpg" alt="Logo"></a>
        <ul class="navigation">
            <li><a href="https://kaalinks.xyz/">Home</a></li>
            <li><a href="/Home/Anime Shows/">Anime Shows</a></li>
            <li><a href="#">Latest</a></li>
            <li><a href="#">My List</a></li>
        </ul>
        <div class="search">
        <section role="search" data-ss360="true">
            <input type="search" id="searchBox" placeholder="Search…">
        </div>
        </section>
    </header>

    <!-- Banner Section -->
    <div class="banner">
        <!-- Spy x Family Trailer -->
        <iframe 
        src="https://www.youtube.com/embed/1kQwjK4rGYg?enablejsapi=1&wmode=opaque&autoplay=1"
        frameborder="0" 
        allowfullscreen 
        class="bg" 
        allow="autoplay">
      </iframe>
        
        <div class="content">
            <!-- Dynamically display the anime poster -->
            <img src="<?php echo $animeImage; ?>" height="200" class="movieTitle" alt="<?php echo $animeTitle; ?> Poster"> 
            <h4>
                <span style="color: white;"><?php echo $animeYear; ?></span>
                <span><i>R - 17+</i></span>
                <span><i> 24 min</i></span>
                <?php 
                foreach ($animeGenres as $genre) {
                    echo "<span style='color: rgb(0, 0, 0);'>$genre</span> ";
                }
                ?>
            </h4>
            <p>
                <?php echo $animeDescription; ?>
            </p>
            <div class="buttons">
                <a href="episode1.php"><i class="fa fa-play"></i>Play</a>
                <a href="#"><i class="fa fa-plus"></i>My List</a>
            </div>
        </div>
        <a href="#" class="play" onclick="toggleVideo();"><img src="#" alt="Play Button"></a>
    </div>

    <!-- TRAILER Section -->
    <div class="trailer">
        <video src="" controls="true" autoplay="false"></video>
        <img src="/" class="close" alt="Close" onclick="toggleVideo();">
    </div>

    <script>
        function toggleVideo() {
            const trailer = document.querySelector('.trailer');
            trailer.classList.toggle('active');
        }
    </script>
</body>
</html>
