<?php
// This could be used to set dynamic content such as title or description from a PHP variable
$title = "DAN DA DAN";
$description = "Despite their initial clash over their opposing beliefs, Momo and Ken form an unexpected but intimate friendship, a bond forged in a series of supernatural battles and bizarre encounters with urban legends and paranormal entities.";
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
    <style>
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
        <a href="#" class="logo"><img src="https://example.com/spx_logo.png" alt="Spy x Family Logo" /></a>
        <ul class="navigation">
            <li><a href="/Home/SpyxFamily/player2.php">Episode 2</a></li>
            <li><a href="https://kaalinks.xyz/">Home</a></li>
        </ul>
    </header>

    <!-- Banner with Video -->
    <div class="banner">
        <!-- Embed Video from an external source -->
        <iframe
            src="https://customer-096zugw79zbwa3w1.cloudflarestream.com/77d73c2cb136febed3923bc1d8e45515/iframe?poster=https%3A%2F%2Fcustomer-096zugw79zbwa3w1.cloudflarestream.com%2F77d73c2cb136febed3923bc1d8e45515%2Fthumbnails%2Fthumbnail.jpg%3Ftime%3D%26height%3D600"
            loading="lazy"
            style="border: none; position: absolute; top: 0; left: 0; height: 100%; width: 100%;"
            allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"
            allowfullscreen="true"
        ></iframe>
    </div>

</body>
</html>
