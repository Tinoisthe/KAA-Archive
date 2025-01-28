<?php
// Start the session to access session variables
session_start();

// Include the database connection file
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch anime data from the database
$sql = "SELECT * FROM anime";  
$result = $conn->query($sql);

$animeList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $animeList[] = [
            'title' => $row['title'],
            'slug' => $row['slug'],
            'image' => $row['image_url'],
        ];
    }
} else {
    $animeList = [];  // In case no data is returned
}

$conn->close();  // Close the database connection
?>
<?php
// Include the auth.php file to protect the page
include('auth.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Anime Archive - Discover, Watch, and Explore Your Favorite Anime Shows.">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="Anime, Manga, Shows, KickAssAnime, MangaPlus">
  <meta property="og:title" content="Anime Archive – Discover Your Favorite Shows">
  <meta property="og:description" content="Discover, Watch, and Explore Your Favorite Anime Shows.">
  <meta property="og:image" content="/images/logo_size_invert.jpg">
  <meta property="og:url" content="http://yourwebsite.com">
  <meta name="twitter:card" content="summary_large_image">
  <title>Anime Archive – Discover Your Favorite Shows</title>
  <link rel="icon" type="image/png" href="/images/logo_size_invert.jpg">
  <link rel="stylesheet" href="/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="/toggle.js" defer></script>
  <script src="/scripts/snow.js" defer></script> <!-- Path to snow.js -->
  <style>
    /* Snow Effect Styles - Smaller Snowflakes */
    .snowflake {
      position: fixed;
      top: -10px;
      color: #fff;
      font-size: 0.8em; /* Smaller snowflakes */
      user-select: none;
      pointer-events: none;
      z-index: 9999;
      animation: fall linear infinite;
    }

    @keyframes fall {
      0% {
        transform: translateY(-10px) rotate(0deg);
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
      }
    }

    .snowflake:nth-child(odd) {
      animation-duration: 12s;
      animation-timing-function: ease-in;
    }

    .snowflake:nth-child(even) {
      animation-duration: 8s;
      animation-timing-function: ease-out;
    }

    /* Default tab content styling */
    .tab-content-item {
      display: none;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }

    .tab-content-item.show {
      display: block;
      opacity: 1;
    }

    /* Tab Item Styling with Animation */
    .tab-item {
      cursor: pointer;
      padding: 10px;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: inline-block;
      width: 33%;
      opacity: 0;
      animation: fadeIn 0.5s forwards;
    }

    .tab-item:hover {
      background-color: #f0f0f0;
      transform: scale(1.05); /* Slight zoom effect */
    }

    .tab-item.show {
      background-color: #ddd;
    }

    /* Animating tab items */
    .tab-item:nth-child(1) {
      animation-delay: 0.1s;
    }

    .tab-item:nth-child(2) {
      animation-delay: 0.3s;
    }

    .tab-item:nth-child(3) {
      animation-delay: 0.5s;
    }

    .tab-item:nth-child(4) {
      animation-delay: 0.7s;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Image Animation (Slide-up) */
    .anime-image {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }

    .anime-image.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Responsive styling for mobile (iPhone screen sizes) */
    @media (max-width: 767px) {
      .showcase {
        text-align: center;
      }

      .showcase-top img {
        max-width: 80%;
        height: auto;
      }

      .tabs .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
      }

      .tab-item {
        width: 32%;
        padding: 8px;
        text-align: center;
      }

      .tab-item i {
        font-size: 2em;
      }

      /* Tab Content */
      .tab-content-item iframe {
        width: 100%;
        height: 500px;
      }

      /* Adjust images in rows for better spacing */
      .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin: 0;
      }

      .column {
        width: 48%;
        margin-bottom: 10px;
        text-align: center;
      }

      /* Mobile Search Input */
      #searchBox {
        width: 80%;
        padding: 10px;
        margin-top: 10px;
      }

      /* Smaller padding for the footer */
      footer p {
        font-size: 0.8em;
        padding: 10px 0;
      }
    }

    /* Additional styling for larger screens */
    @media (min-width: 768px) {
      .tabs .container {
        display: flex;
        justify-content: space-around;
      }

      .tab-item {
        width: auto;
        padding: 15px;
      }

      .tab-item i {
        font-size: 2.5em;
      }

      .tab-content-item iframe {
        height: 800px;
      }
    }
  </style>
</head>

<body>
  <header class="showcase">
  <div class="showcase-top">
    <img src="/images/logo_size_invert.jpg" alt="Anime Archive Logo">
  </div>

  <div class="showcase-content">
    <?php if (!isset($_SESSION['user_id'])): ?>
      <!-- Login Button (Visible if user is not logged in) -->
      <div class="login-container">
        <a href="login.php" class="login-btn" aria-label="Login">
          <i class="fas fa-sign-in-alt"></i> login
        </a>
      </div>
    <?php endif; ?>
  </div>
</header>
  <!-- Search Section -->
  <section role="search" data-ss360="true">
    <label for="searchBox" class="sr-only">Search for anime, manga, or shows</label>
    <input type="search" id="searchBox" placeholder="Search for anime, manga, or shows..." aria-label="Search for anime or manga">
    <button id="searchButton" aria-label="Search Button">
      <i class="fas fa-search"></i>
    </button>
  </section>

  <!-- Tab Navigation -->
  <nav class="tabs">
    <div class="container">
      <button id="tab-1" class="tab-item tab-border show" role="tab" aria-controls="tab-1-content" aria-selected="true">
        <i class="fas fa-door-open fa-3x" aria-hidden="true"></i>
        <p class="hide-sm">All Anime Shows</p>
      </button>
      <button id="tab-2" class="tab-item" role="tab" aria-controls="tab-2-content">
        <i class="fas fa-star fa-3x" aria-hidden="true"></i>
        <p class="hide-sm">Popular Anime</p>
      </button>
      <button id="tab-3" class="tab-item" role="tab" aria-controls="tab-3-content">
        <i class="fas fa-star fa-3x" aria-hidden="true"></i>
        <p class="hide-sm">KickAssAnime</p>
      </button>
       <button id="tab-4" class="tab-item" role="tab" aria-controls="tab-4-content">
      <i class="fas fa-cog fa-3x" aria-hidden="true"></i>
      <p class="hide-sm">Settings</p>
    </button>
  </div>
    </div>
  </nav>

  <!-- Tab Content -->
  <section class="tab-content">
    <div class="container">
      <!-- Tab 1: All Anime Shows -->
      <div id="tab-1-content" class="tab-content-item show" role="tabpanel" aria-labelledby="tab-1">
        <div class="row">
          <?php
          // Loop through the anime list to display images dynamically
          foreach ($animeList as $anime) {
              echo '<div class="column">';
              echo '<a href="/Home/' . urlencode($anime['slug']) . '/index.php">';
              echo '<img src="' . $anime['image'] . '" alt="' . htmlspecialchars($anime['title']) . '" loading="lazy" class="anime-image">';
              echo '<p>' . htmlspecialchars($anime['title']) . '</p>';
              echo '</a>';
              echo '</div>';
          }
          ?>
        </div>
      </div>

      <!-- Tab 2: Popular Anime -->
      <div id="tab-2-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-2">
        <div class="row">
          <div class="column">
            <a href="/Home/Demon/">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Demon Slayer Anime Poster" class="anime-image" loading="lazy">
            </a>
          </div>
          <div class="column">
            <a href="/Home/Pokémon X and Y/index.html">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Attack on Titan Anime Poster" class="anime-image" loading="lazy">
            </a>
          </div>
          <div class="column">
            <a href="/Home/Fullmetal-Alchemist/">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Fullmetal Alchemist Anime Poster" class="anime-image" loading="lazy">
            </a>
          </div>
        </div>
      </div>

      <!-- Tab 3: Kickassanime -->
      <div id="tab-3-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-3">
        <iframe src="https://www1.kickassanime.mx/" width="100%" height="800px" title="Watch anime on KickAssAnime"></iframe>
      </div>

    <!-- Tab Content for Settings (formerly Manga) -->
<section class="tab-content">
  <div class="container">
    <!-- Other tabs content -->

<!-- Tab 4: Settings (Embedded profile.php in iframe) -->
<div id="tab-4-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-4">
  <?php if (isset($_SESSION['user_id'])): ?>
    <iframe src="profile.php?user_id=<?php echo $_SESSION['user_id']; ?>" width="100%" height="800px" title="Profile Settings"></iframe>
  <?php else: ?>
    <p>You must be logged in to view the profile settings.</p>
  <?php endif; ?>
</div>



  <!-- Site Search 360 Scripts -->
  <script type="text/javascript">
    var ss360Config = {
      siteId: 'kaalinks.xyz',
      searchBox: {
        selector: '#searchBox'
      }
    }
  </script>
  <script src="https://cdn.sitesearch360.com/v13/sitesearch360-v13.min.js" defer></script>

  <!-- Tab Switching Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tabItems = document.querySelectorAll('.tab-item');
      const tabContentItems = document.querySelectorAll('.tab-content-item');
      const animeImages = document.querySelectorAll('.anime-image');
      
      // Tab Item Click Event Handler
      tabItems.forEach((item) => {
        item.addEventListener('click', selectItem);
      });

      function selectItem(event) {
        removeBorder();
        removeShow();

        const tabItem = event.target.closest('.tab-item');
        tabItem.classList.add('tab-border');
        const tabId = tabItem.id;
        const tabContentItem = document.querySelector("#" + tabId + "-content");
        tabContentItem.classList.add('show');

        // Reset Image Animations
        resetImageAnimations();
      }

      function removeBorder() {
        tabItems.forEach((item) => item.classList.remove('tab-border'));
      }

      function removeShow() {
        tabContentItems.forEach((item) => item.classList.remove('show'));
      }

      // Adding visibility animation for images when they come into view
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.2 // Trigger when 20% of the image is visible
      });

      animeImages.forEach(image => {
        observer.observe(image);
      });

      // Reset image animations (for example, when tab is switched)
      function resetImageAnimations() {
        animeImages.forEach(image => {
          image.classList.remove('visible'); // Remove the 'visible' class for image animation
          image.offsetHeight; // Trigger reflow to restart animation
          image.classList.add('visible'); // Reapply the 'visible' class to restart animation
        });
      }

      // Optional: Reset animations when the page/tab becomes visible again
      document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
          resetImageAnimations(); // Reset animations when tab becomes visible
        }
      });
    });
  </script>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Anime Archive. All rights reserved.</p>
  </footer>

</body>

</html>
