<!-- Start Header Section -->
    <div class="home-v2">
    <div class="container">
        <!-- Hero -->
        <section class="home-v2__hero">
        <div class="home-v2__hero-inner">
            <div class="home-v2__hero-left">
            <h1 class="home-v2__title">Welcome to Alexandria</h1>
            <p class="home-v2__subtitle">
                Explore and Borrow Books Through the<br>
                innovative Online Library Management<br>
                System
            </p>
            </div>

            <!-- Placeholder for hero image -->
            <div class="home-v2__hero-right" aria-label="Hero image"></div>
        </div>
        </section>

        <!-- Feature tiles -->
        <section class="home-v2__features">
        <a class="home-v2__feature" href="index.php?q=books">
            <div class="home-v2__feature-media home-v2__feature-media--discover" aria-label="Discover Books image"></div>
            <div class="home-v2__feature-body">
            <div class="home-v2__feature-title">Discover Books</div>
            <div class="home-v2__feature-cta" aria-hidden="true"></div>
            </div>
        </a>

        <a class="home-v2__feature" href="index.php?q=find">
            <div class="home-v2__feature-media home-v2__feature-media--specific" aria-label="Find Specific Books image"></div>
            <div class="home-v2__feature-body">
            <div class="home-v2__feature-title">Find Specific Books</div>
            <div class="home-v2__feature-cta" aria-hidden="true"></div>
            </div>
        </a>
        </section>
    </div>
    </div>
    <!-- End Header Section -->
        
    <!-- Start Call to Action Section -->
    <section class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow zoomIn" data-wow-duration="2s" data-wow-delay="300ms">
                    <p>Discover a world where stories come alive and knowledge is just a click away. Start exploring Alexandria today and unlock endless learning opportunities.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Call to Action Section -->
        
        
    <!-- Start Service Section -->
    <section id="service-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                        <h1>Discover Your Next Great Read</h1>
                        <p>Books available in the library</p>
                    </div>
                </div>
            </div>

            <!-- Owl Carousel -->
            <div class="owl-carousel owl-theme">
                <?php
                $mydb->setQuery("SELECT * FROM `tblbooks` WHERE Status='Available' GROUP BY BookTitle");
                $cur = $mydb->loadResultlist();
                foreach ($cur as $result) {
                    // Path to the book cover image
                    $coverImage = "asset/images/covers/" . $result->IBSN . ".jpg";

                    // Check if the cover image exists
                    if (!file_exists($coverImage)) {
                        $coverImage = "asset/images/covers/default.jpg"; // Fallback to a default image
                    }

                    echo '<div class="item">
                            <div class="services-post text-center">
                                <a href="index.php?q=borrow&id=' . $result->IBSN . '">
                                    <img src="' . $coverImage . '" alt="' . htmlspecialchars($result->BookTitle) . '" class="book-cover">
                                </a>
                                <h2 class="book-title">' . htmlspecialchars($result->BookTitle) . '</h2>
                                <p class="book-desc">' . htmlspecialchars($result->BookDesc) . '</p>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </section>
    <!-- End Service Section -->

    <!-- Specific Book Search (bottom section) -->
    <section class="home-find">
        <div class="container">
            <h2 class="home-find__title">Got a specific book in mind?</h2>
            <p class="home-find__subtitle">
                Search through our extensive collection of books by title, author, or genre
            </p>

            <form class="home-find__form" action="index.php" method="GET" autocomplete="off">
                <input type="hidden" name="q" value="find" />
                <div class="home-find__field">
                    <span class="home-find__icon" aria-hidden="true">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        class="home-find__input"
                        type="text"
                        name="query"
                        placeholder="Search by Title, Author, or ISBN..."
                        aria-label="Search by Title, Author, or ISBN"
                    />
                </div>
            </form>
        </div>
    </section>

    <script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            loop: true, // Enables infinite looping
            margin: 10, // Space between items
            nav: true, // Navigation arrows
            dots: true, // Pagination dots
            autoplay: true, // Enables autoplay
            autoplayTimeout: 5000, // Time between slides (in milliseconds)
            autoplayHoverPause: true, // Pause on hover
            rewind: true, // Ensures the carousel rewinds if looping is not possible
            responsive: {
                0: {
                    items: 1 // Number of items on small screens
                },
                600: {
                    items: 2 // Number of items on medium screens
                },
                1000: {
                    items: 3 // Number of items on large screens
                }
            },
            navText: [
                '<i class="fa fa-chevron-left"></i>', // Left arrow
                '<i class="fa fa-chevron-right"></i>' // Right arrow
            ]
        });
    });
    </script>



