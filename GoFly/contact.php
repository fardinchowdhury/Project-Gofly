<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Login</title>
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
        <form action="https://formspree.io/f/mlekpwqw" method="post" class="form color-g">
            <h2>Contact Us</h2>
            
            <input class="box" type="text" name="name" pattern="[a-zA-Z]+" title="Please enter only alphabetical letters." placeholder="Enter Your Name" required>
            <input class="box" type="email" name="email" placeholder="Enter Your Email Address" required>
            <textarea class="box" name="message" rows="4" cols="50" placeholder="Enter text here..."></textarea>
            <input type="submit" value="Submit" id="submit">
        </form>
        <div class="side">
            <img src="photos/bgpic1.png" alt="">
        </div>
    </div>
    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>
    
</body>
</html>