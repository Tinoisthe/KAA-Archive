<?php
// Dynamic PHP variables
$animeTitle = 'Spy x Family';
$animeDescription = 'A spy on a mission to create the perfect family, but his new family members have secrets of their own. This thrilling anime combines espionage, comedy, and family drama.';
$animeYear = 2022;
$animeGenres = ['Action', 'Comedy', 'Drama', 'Mystery'];
$animePoster = 'https://cdn.myanimelist.net/images/anime/1441/122795.jpg';
$trailerUrl = 'https://www.youtube.com/embed/ofXigq9aIpo?enablejsapi=1&wmode=opaque&autoplay=1';
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

    <script src="/scripts/snow.js" defer></script> <!-- Path to snow.js -->

</head>
<body>
    <header>
        <a href="#" class="logo"><img src=""></a>
        <ul class="navigation">
            <li><a href="https://kaalinks.xyz/">Home</a></li>
            <li><a href="/Home/Anime Shows/">Anime Shows</a></li>
            <li><a href="#">Latest</a></li>
            <li><a href="#">My List</a></li>
        </ul>
        <div class="search">
            <section role="search" data-ss360="true">
                <input type="search" id="searchBox" placeholder="Search…">
            </section>
        </div>
    </header>

    <!-- Banner Section -->
    <div class="banner">
        <!-- Spy x Family Trailer -->
        <iframe 
        src="<?php echo $trailerUrl; ?>"
        frameborder="0" 
        allowfullscreen 
        class="bg" 
        allow="autoplay">
      </iframe>
        
        <div class="content">
            <img src="<?php echo $animePoster; ?>" height="200" class="movieTitle" alt="<?php echo $animeTitle; ?> Poster"> 
            <h4>
                <span style="color: white;"><?php echo $animeYear; ?></span>
                <span><i>PG-13</i></span>
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
                <a href="Episode1.php"><i class="fa fa-play"></i>Play</a>
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
