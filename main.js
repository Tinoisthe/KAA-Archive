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

  <style>
    /* Default tab content styling */
    .tab-content-item {
      display: none;
    }

    .tab-content-item.show {
      display: block;
    }

    .tab-item {
      cursor: pointer;
      padding: 10px;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: inline-block;
      width: 33%;
    }

    .tab-item:hover {
      background-color: #f0f0f0;
      transform: scale(1.05); /* Slight zoom effect */
    }

    .tab-item.show {
      background-color: #ddd;
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
    <div class="showcase-content"></div>
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
        <i class="fas fa-book fa-3x" aria-hidden="true"></i>
        <p class="hide-sm">Manga</p>
      </button>
    </div>
  </nav>

  <!-- Tab Content -->
  <section class="tab-content">
    <div class="container">
      <!-- Tab 1: All Anime Shows -->
      <div id="tab-1-content" class="tab-content-item show" role="tabpanel" aria-labelledby="tab-1">
        <div class="row">
          <div class="column">
            <a href="/Home/DAN DA DAN">
              <img src="https://cdn.myanimelist.net/images/anime/1990/139975l.jpg?_gl=1*38yin9*_gcl_au*MTAxODQ1NDc1Ny4xNzMzMDExMDg0*_ga*NTU3Nzk0MzgzLjE3MzIzNTI3ODQ.*_ga_26FEP9527K*MTczNjQ5NjYzMy43LjEuMTczNjQ5Njg4OS41OC4wLjA.." alt="DAN DA DAN">
            </a>
          </div>
          <div class="column">
            <a href="/Home/spyxfamily/">
              <img src="https://cdn.myanimelist.net/images/anime/1441/122795.jpg" alt="spy">
            </a>
          </div>
          <div class="column">
            <a href="/Home/Fullmetal-Alchemist/">
              <img src="https://cdn.myanimelist.net/images/anime/1584/143719.jpg" alt="Fullmetal Alchemist Anime Poster">
            </a>
          </div>
        </div>
      </div>

      <!-- Tab 2: Popular Anime -->
      <div id="tab-2-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-2">
        <div class="row">
          <div class="column">
            <a href="/Home/Demon/">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Demon Slayer Anime Poster">
            </a>
          </div>
          <div class="column">
            <a href="/Home/Pokémon X and Y/index.html">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Attack on Titan Anime Poster">
            </a>
          </div>
          <div class="column">
            <a href="/Home/Fullmetal-Alchemist/">
              <img src="https://cdn.myanimelist.net/images/anime/1660/121553.jpg" alt="Fullmetal Alchemist Anime Poster">
            </a>
          </div>
        </div>
      </div>

      <!-- Tab 3: Kickassanime -->
      <div id="tab-3-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-3">
        <iframe src="https://www1.kickassanime.mx/" width="100%" height="800px" title="Watch anime on KickAssAnime"></iframe>
      </div>

      <!-- Tab 4: Manga -->
      <div id="tab-4-content" class="tab-content-item" role="tabpanel" aria-labelledby="tab-4">
        <iframe src="https://mangaplus.shueisha.co.jp/" width="100%" height="800px" title="Read manga on MangaPlus"></iframe>
      </div>
    </div>
  </section>

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
      }

      function removeBorder() {
        tabItems.forEach((item) => item.classList.remove('tab-border'));
      }

      function removeShow() {
        tabContentItems.forEach((item) => item.classList.remove('show'));
      }
    });
  </script>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Anime Archive. All rights reserved.</p>
  </footer>

</body>

</html>
