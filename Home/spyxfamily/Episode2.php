<?php
// Dynamic PHP variables for the anime and episode
$animeTitle = 'Spy x Family';
$episodeTitle = 'Episode 2';
$episodeDescription = 'Watch Spy x Family Episode 2. The anime follows a spy family with unique abilities and their journey through covert missions and family dynamics.';
$episodeVideoUrl = 'https://iframe.mediadelivery.net/embed/366943/6da731c6-81dc-4110-a14a-c186b41a4d47?autoplay=true&loop=false&muted=false&preload=true&responsive=true';
$logoUrl = 'https://example.com/spx_logo.png';
$episode2Url = '/Home/SpyxFamily/Episode 1';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $animeTitle . ' - ' . $episodeTitle; ?></title>
    <meta name="description" content="<?php echo $episodeDescription; ?>">
    <link rel="shortcut icon" type="image/png" href="/images/logo_size_invert.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="/animestyle.css">

    <script src="/scripts/snow.js" defer></script> <!-- Path to snow.js -->
    <script src="https://vjs.zencdn.net/7.17.0/video.js"></script>
    <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/forest/index.css" rel="stylesheet">
    <style>
        .my-video {
            width: 100%; /* Ensure the video takes up the full width */
            display: block; /* Ensures proper layout of the video */
            max-width: 100%; /* Prevents the video from exceeding the container's width */
        }
        .navigation li a {
            font-size: 18px;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 5px;
        }
        .navigation li a:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }
        .banner {
            position: relative;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <a href="#" class="logo"><img src="<?php echo $logoUrl; ?>" alt="<?php echo $animeTitle; ?> Logo" /></a>
        <ul class="navigation">
            <li><a href="<?php echo $episode2Url; ?>">Episode 2</a></li>
            <li><a href="https://kaalinks.xyz/">Home</a></li>
        </ul>
    </header>

    <!-- Banner with Video -->
    <div class="banner">
       <iframe src="<?php echo $episodeVideoUrl; ?>" loading="lazy" style="border:0;position:absolute;top:0;height:100%;width:100%;" allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;" allowfullscreen="true"></iframe>
    </div>

    

</body>
</html>
