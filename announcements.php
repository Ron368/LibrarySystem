<?php
require_once("include/initialize.php");

// Check if the user is logged in (optional)
if (!isset($_SESSION['USERID'])) {
    redirect(web_root . "index.php?q=login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | Alexandria Library</title>
    <style>
        /* Base Styles */
        :root {
            --primary-color: #7B3F00;
            --primary-dark: #5a2d00;
            --secondary-color: #6c8e8d;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --text-color: #495057;
            --white: #ffffff;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Header Section */
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            padding-top: 30px;
        }
        
        .section-title h2 {
            font-size: 48px;
            color: var(--dark-gray);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-title p {
            font-size: 18px;
            color: var(--text-color);
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Main Content Layout */
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .blog-posts {
            flex: 1;
            min-width: 300px;
        }
        
        .sidebar {
            width: 300px;
        }
        
        /* Blog Post Cards */
        .blog-post {
            background: var(--white);
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .blog-post:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        
        .blog-post img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 4px solid var(--primary-color);
        }
        
        .blog-post-content {
            padding: 25px;
        }
        
        .blog-post-title {
            font-size: 35px;
            margin-bottom: 10px;
            color: var(--dark-gray);
            line-height: 1.3;
        }
        
        .blog-post-meta {
            display: flex;
            align-items: center;
            font-size: 20px;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .blog-post-meta i {
            margin-right: 8px;
        }
        
        .blog-post-excerpt {
            margin-bottom: 20px;
            color: var(--text-color);
            font-size: 15px;
        }
        
        .read-more {
            display: inline-flex;
            align-items: center;
            background: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .read-more:hover {
            background: var(--primary-dark);
            transform: translateX(5px);
        }
        
        .read-more i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .read-more:hover i {
            transform: translateX(3px);
        }
        
        /* Featured Post */
        .featured-post {
            position: relative;
        }
        
        .featured-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: var(--white);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 1;
        }
        
        /* Sidebar */
        .sidebar {
            background: var(--white);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: fit-content;
        }
        
        .sidebar h3 {
            font-size: 35px;
            color: var(--dark-gray);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .recent-post {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .recent-post:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .recent-post-title {
            font-size: 20px;
            margin-bottom: 5px;
            color: var(--dark-gray);
            transition: color 0.3s ease;
        }
        
        .recent-post-title:hover {
            color: var(--primary-color);
        }
        
        .recent-post-date {
            font-size: 15px;
            color: var(--secondary-color);
        }
        
        /* Categories */
        .sidebar-categories {
            margin-top: 30px;
        }
        
        .category-list {
            list-style: none;
            padding: 0;
        }
        
        .category-item {
            margin-bottom: 10px;
        }
        
        .category-link {
            display: flex;
            align-items: center;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 0;
        }
        
        .category-link:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .category-link i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .blog-post img {
                height: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .section-title h2 {
                font-size: 2rem;
            }
            
            .blog-post-title {
                font-size: 1.5rem;
            }
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-bullhorn"></i> Announcements & News</h2>
            <p>Stay updated with the latest news and announcements from Alexandria Library</p>
        </div>

        <div class="main-content">
            <!-- Blog Posts Section -->
            <div class="blog-posts">
                <!-- Featured Blog Post -->
                <div class="blog-post featured-post">
                    <div class="featured-badge">Featured</div>
                    <img src="asset/images/announcement-bg.jpg" alt="Summer Reading Challenge">
                    <div class="blog-post-content">
                        <h2 class="blog-post-title">Summer Reading Challenge 2025</h2>
                        <p class="blog-post-meta"><i class="far fa-calendar-alt"></i> Posted on June 15, 2025</p>
                        <p class="blog-post-excerpt">Join our annual summer reading program with exciting prizes for all age groups. This year's theme is "Adventures Through Time" where readers will explore books from different historical periods. Participants can track their reading through our app and earn digital badges.</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Blog Post 2 -->
                <div class="blog-post">
                    <img src="asset/images/digital-resources.jpg" alt="New Digital Resources">
                    <div class="blog-post-content">
                        <h2 class="blog-post-title">New Digital Resources Added</h2>
                        <p class="blog-post-meta"><i class="far fa-calendar-alt"></i> Posted on June 10, 2025</p>
                        <p class="blog-post-excerpt">We've expanded our digital collection with over 500 new e-books and audiobooks, including bestsellers and academic resources. Our new partnership with DigitalRead gives you access to exclusive content available 24/7.</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Blog Post 3 -->
                <div class="blog-post">
                    <img src="asset/images/children-program.jpg" alt="Children's Program">
                    <div class="blog-post-content">
                        <h2 class="blog-post-title">New Children's Storytime Program</h2>
                        <p class="blog-post-meta"><i class="far fa-calendar-alt"></i> Posted on June 5, 2025</p>
                        <p class="blog-post-excerpt">Starting July 7th, we're launching a new weekly storytime program for children ages 3-6. Every Tuesday at 10am, our children's librarian will lead interactive story sessions with crafts and activities.</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="sidebar">
                <h3><i class="fas fa-clock"></i> Recent Posts</h3>
                <div class="recent-post">
                    <a href="#" class="recent-post-title">Summer Reading Challenge 2025</a>
                    <p class="recent-post-date">June 15, 2025</p>
                </div>
                <div class="recent-post">
                    <a href="#" class="recent-post-title">New Digital Resources Added</a>
                    <p class="recent-post-date">June 10, 2025</p>
                </div>
                <div class="recent-post">
                    <a href="#" class="recent-post-title">New Children's Storytime Program</a>
                    <p class="recent-post-date">June 5, 2025</p>
                </div>
                
                <div class="sidebar-categories">
                    <h3><i class="fas fa-tags"></i> Categories</h3>
                    <ul class="category-list">
                        <li class="category-item"><a href="#" class="category-link"><i class="fas fa-book-open"></i> Reading Programs</a></li>
                        <li class="category-item"><a href="#" class="category-link"><i class="fas fa-laptop"></i> Digital Resources</a></li>
                        <li class="category-item"><a href="#" class="category-link"><i class="fas fa-child"></i> Children's Events</a></li>
                        <li class="category-item"><a href="#" class="category-link"><i class="fas fa-user-edit"></i> Author Events</a></li>
                        <li class="category-item"><a href="#" class="category-link"><i class="fas fa-calendar-alt"></i> Library Hours</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>