<?php
// Set dynamic content for each page
$title = "2.5 Dimensional Seduction";
$description = "After a disastrous romantic confession, Masamune Okumura finds solace in the fictional world of anime and manga. Now a second-year high school student and the president of the Manga Research Club, Masamune spends a peaceful existence watching the adventures of the angel Liliel, his favorite character..";
$videoSrc = "https://customer-096zugw79zbwa3w1.cloudflarestream.com/d167463980e79020c45276a2171a2a5e/iframe?poster=https%3A%2F%2Fcustomer-096zugw79zbwa3w1.cloudflarestream.com%2Fd167463980e79020c45276a2171a2a5e%2Fthumbnails%2Fthumbnail.jpg%3Ftime%3D%26height%3D600";
$episodeLink = "/Home/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">

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
        <a href="#" class="logo"><img src="#" alt="KAA" /></a>
        <ul class="navigation">
            <li><a href="<?php echo $episodeLink; ?>">Episode 2</a></li>
            <li><a href="https://kaa-archive.com/">Home</a></li>
        </ul>
    </header>

    <!-- Banner with Video -->
    <div class="banner">
        <iframe
            src="<?php echo $videoSrc; ?>"
            loading="lazy"
            style="border: none; position: absolute; top: 0; left: 0; height: 100%; width: 100%;"
            allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"
            allowfullscreen="true"
        ></iframe>
    </div>

   

</body>
</html>
