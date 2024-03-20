<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="landing.css">
        <link rel="stylesheet" href="reviews_list.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
        <title>Reviews List</title>
    </head>
    <body>
        <nav>
            <div class="logo">
                <h4><a href="landing.php">Gofly</a></h4>
            </div>
            <ul class="nav-links">
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="signup.php">Register</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>

        <div class="container">
            <h2>Our Customer Reviews</h2>
            <div class="slider-container">
                <span class="arrow arrow-left" onclick="scrollSlider(-1);">&#10094;</span>
                <div class="reviews-container">
                    <?php
                    $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
                    $result = $db_connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $review_id = $row['id'];
                            $full_name = $row['full_name'];
                            $rating = $row['rating'];
                            $comment = $row['comment'];
                            $username = $row['username'];
                    ?>
                    <div class="review-container">
                        <div class="review">
                            <div class="review-header">
                                <h3><?php echo htmlspecialchars($full_name); ?></h3>
                                <?php
                                    // checking if the current user's username matches the username associated with the review
                                    if ($_SESSION['username'] == $username) {
                                ?>
                                <div class="dropdown">
                                    <button class="dropbtn">&#8942;</button>
                                    <div class="dropdown-content">
                                        <a href="javascript:void(0);" onclick="editReview(<?php echo $review_id; ?>, '<?php echo htmlspecialchars(addslashes($full_name)); ?>')">Edit</a>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '&#9733;' : '&#9734;';
                                }
                                ?>
                            </div>
                            <p><?php echo htmlspecialchars($comment); ?></p>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo '<p>No reviews found.</p>';
                    }
                    ?>
                </div>
                <span class="arrow arrow-right" onclick="scrollSlider(1);">&#10095;</span>
            </div>
        </div>

        <script>
            function scrollSlider(direction) {
                const slider = document.querySelector('.reviews-container');
                const singleSlideWidth = slider.querySelector('.review-container').clientWidth;
                const scrollAmount = singleSlideWidth * direction;
                slider.scrollBy({ top: 0, left: scrollAmount, behavior: 'smooth' });
            }

            function editReview(review_id, full_name) {
                window.location.href = 'edit_review.php?review_id=' + review_id + '&full_name=' + encodeURIComponent(full_name);
            }


        </script>
        <div class="reviews-btn-container">
            <button class="view-reviews-btn" onclick="window.location.href='reviews.php'">Leave a Review</button>
        </div>
    </body>
</html>
