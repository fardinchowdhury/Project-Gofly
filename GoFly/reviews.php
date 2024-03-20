<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
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
    <title>Reviews</title>
</head>
<body>
<?php 
        // Check the session status
        $status = session_status();
        if ($status === PHP_SESSION_ACTIVE) {
            // Session is active
            include_once 'navbar.php';
        } else {
            session_start();
            // Session is not active
            include_once 'navbar.php';

        }
        
    ?>

    <div class="container">
        <form action="submit_review.php" method="post" class="form color-g">
            <h2>Leave a Review</h2>
            
            <input class="box" type="text" name="full_name" pattern="[a-zA-Z\s]+" title="Please enter only alphabetical letters and spaces." placeholder="Enter Your Full Name" required>
            
            <div class="rating">
                <span class="rating-star" data-hovered="1" onclick="setRating(1)" onmouseover="hoverRating(1)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="2" onclick="setRating(2)" onmouseover="hoverRating(2)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="3" onclick="setRating(3)" onmouseover="hoverRating(3)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="4" onclick="setRating(4)" onmouseover="hoverRating(4)" onmouseout="resetRating()">&#9733;</span>
                <span class="rating-star" data-hovered="5" onclick="setRating(5)" onmouseover="hoverRating(5)" onmouseout="resetRating()">&#9733;</span>
                <input type="hidden" name="rating" id="rating-value" required>
            </div>


            <textarea class="box" name="comment" rows="4" cols="50" placeholder="Share your experience with us..."></textarea>
            <input type="submit" value="Submit" id="submit">
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
