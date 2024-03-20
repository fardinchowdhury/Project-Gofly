<?php
require_once("config.php");

if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
    $full_name = urldecode($_GET['full_name']);

    $stmt = $db_connection->prepare("SELECT * FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $rating = $row['rating'];
    $comment = $row['comment'];
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    function setRating(ratingValue) {
        document.getElementById("rating-value").value = ratingValue;
        const ratingStars = document.querySelectorAll('.rating-star');
        ratingStars.forEach(star => {
            if (parseInt(star.getAttribute('data-hovered')) <= ratingValue) {
                star.style.color = 'rgb(124, 100, 231)';
            } else {
                star.style.color = '#ccc';
            }
        });
    }

    function hoverRating(ratingValue) {
        const ratingStars = document.querySelectorAll('.rating-star');
        ratingStars.forEach(star => {
            if (parseInt(star.getAttribute('data-hovered')) <= ratingValue) {
                star.style.color = 'rgb(124, 100, 231)';
            } else {
                star.style.color = '#ccc';
            }
        });
    }

    function resetRating() {
        const ratingValue = document.getElementById("rating-value").value;
        const ratingStars = document.querySelectorAll('.rating-star');
        ratingStars.forEach(star => {
            if (parseInt(star.getAttribute('data-hovered')) <= ratingValue) {
                star.style.color = 'rgb(124, 100, 231)';
            } else {
                star.style.color = '#ccc';
            }
        });

    }
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Edit Review</title>
</head>
<body>
    <nav>
        <div class="logo">
            <h4><a href="landing.php">Gofly</a></h4>
        </div>
        <ul class="nav-links">
            <li><a href="displaylist.php">Listings</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="profile.php">My Profile</a></li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="container">
    <form action="update_review.php" method="post" class="form color-g">
            <input type="hidden" name="review_id" id="review-id" required>
            <h2>Edit Your Review</h2>
            
            <input class="box" type="text" name="full_name" pattern="[a-zA-Z\s]+" title="Please enter only alphabetical letters and spaces." placeholder="Enter Your Full Name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            
            <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
            
            <div class="rating">
                <span class="rating-star" data-hovered="1" onclick="setRating(1)" onmouseover="hoverRating(1)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="2" onclick="setRating(2)" onmouseover="hoverRating(2)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="3" onclick="setRating(3)" onmouseover="hoverRating(3)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="4" onclick="setRating(4)" onmouseover="hoverRating(4)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="5" onclick="setRating(5)" onmouseover="hoverRating(5)" onmouseout="resetRating()">&#9733;</span>
                <input type="hidden" name="rating" id="rating-value" required>
            </div>

            <textarea class="box" name="comment" rows="4" cols="50" placeholder="Share your experience with us..."><?php echo htmlspecialchars($comment); ?></textarea>
            <input type="submit" value="Update" id="submit">
        </form>
        <div class="side">
            <img src="photos/bgpic1.png" alt="">
        </div>
    </div>
    <div class="reviews-btn-container">
        <button class="view-reviews-btn" onclick="window.location.href='reviews_list.php'">View Customer Reviews</button>
    </div>
</body>
</html>


    
</body>
</html>
