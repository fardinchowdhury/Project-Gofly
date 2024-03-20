<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();

}

// Check if the user is logged in and has the user type "admin"
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    // The user is not an admin, so redirect to regular users' landing page.
    header('Location: landing.php');
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="stylesheet" href="admin_land.css">
    <title>Gofly</title>
</head>

<body>
<?php 
    // Check the session status
    $status = session_status();

    if ($status === PHP_SESSION_ACTIVE) {
        // Session is active
        include_once 'admin_navbar.php';
    } else {
        session_start();
        // Session is not active
        include_once 'admin_navbar.php';

    }
        
    ?>

    <div class="wel">
        <?php

        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            echo "<h1>Welcome Admin User: $username!</h1>";
        }
        
        ?>
    </div>
    <main class="page-content">
        <div class="card">
            <div class="content">
                <h2 class="title">View Flight Listings</h2>
                <p class="copy">Check out all the flight Listings</p>
                <a class="btn-a" href= "admin_displaylist.php">View Flight</a>
            </div>
        </div>

        <div class="card">
            <div class="content">
                <h2 class="title">View Hotel Lisiting</h2>
                <p class="copy">See all the hotels Lisiting </p>
                <a class="btn-a" href='admin_hotelDisplay.php'>View Hotel</a>
            </div>
        </div>

    </main>

    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>
</body>

</html>