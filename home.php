       
    <!-- Start Header Section -->
    <div class="banner">
        <div class="overlay">
            <div class="container">
                <div class="intro-text">
                    <h1>Welcome To <span>Alexandria</span></h1>
                    <p>Explore and Borrow Books <br> Through Butuan City's Online Library Management System</p> 
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Section -->

    <!-- Start Announcements Section -->
    <section id="announcements-section" class="announcements-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                        <h2>Announcements & News</h2>
                        <p>Stay updated with the latest from Alexandria Library</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Main Featured Announcement -->
                <div class="col-lg-6 mb-4">
                    <div class="featured-announcement papyrus-effect">
                        <div class="announcement-badge">Featured</div>
                        <img src="asset/images/announcement-bg.jpg" alt="Library Event" class="img-fluid">
                        <div class="announcement-content">
                            <div class="announcement-date">
                                <span class="day">15</span>
                                <span class="month">Jun</span>
                            </div>
                            <h3>Summer Reading Challenge 2025</h3>
                            <p>Join our annual summer reading program with exciting prizes for all age groups. Registration opens June 20th.</p>
                            <a href="index.php?q=announcements" class="btn btn-alexandria">Learn More</a>
                        </div>
                    </div>
                </div>
                
                <!-- Secondary Announcements -->
                <div class="col-lg-6">
                    <div class="announcement-list">
                        <!-- Announcement Item 1 -->
                        <div class="announcement-item wow fadeInRight" data-wow-delay="100ms">
                            <div class="announcement-icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="announcement-text">
                                <h4>New Digital Resources Added</h4>
                                <p class="announcement-meta"><i class="fa fa-calendar-alt"></i> June 10, 2025</p>
                                <p>We've expanded our library with new book entries.</p>
                            </div>
                        </div>
                        
                        <!-- Announcement Item 2 -->
                        <div class="announcement-item wow fadeInRight" data-wow-delay="200ms">
                            <div class="announcement-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="announcement-text">
                                <h4>Author Meet & Greet</h4>
                                <p class="announcement-meta"><i class="fa fa-calendar-alt"></i> June 25, 2025</p>
                                <p>Local author Maria Santos will discuss her new novel "Island Whispers" at 2pm.</p>
                            </div>
                        </div>
                        
                        <!-- Announcement Item 3 -->
                        <div class="announcement-item wow fadeInRight" data-wow-delay="300ms">
                            <div class="announcement-icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="announcement-text">
                                <h4>Holiday Hours Update</h4>
                                <p class="announcement-meta"><i class="fa fa-calendar-alt"></i> June 12, 2025</p>
                                <p>Special operating hours for Independence Day weekend - check before you visit.</p>
                            </div>
                        </div>
                        
                        <!-- View All Link -->
                        <div class="text-center mt-4">
                            <a href="index.php?q=announcements" class="view-all-link">
                                View All Announcements <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Announcements Section -->
        
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
                        <h2>Our Books</h2>
                        <p>Available Books in the Library</p>
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
        
 