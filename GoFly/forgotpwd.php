<?php
require_once "vendor/autoload.php";
require_once ("config.php");

use SendGrid\Mail\Mail;

// Define an empty message variable

// Check if the form has been submitted
if (isset($_POST['email'])) {

    // Get the username from the form
    $username = $_POST['email'];

    // Generate a unique token for the password reset link
    $token = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

    $reset_link = 'https://www-student.cse.buffalo.edu/CSE442-542/2023-Spring/cse-442y/reset_password.php';

    // Save the token and expiration time in the database
    $sql = "UPDATE users SET reset_token='$token' WHERE email='$username'";
    mysqli_query($db_connection, $sql);

    // Set up the email message
    $email = new Mail();
    $email->setFrom("jkace0252@gmail.com", "GoFly");
    $email->setSubject("Password Reset Request");
    $email->addTo($username);
    $email->addContent(
        "text/html",
        "<p>Hello,</p><p>We have received a request to reset the password for your GoFly account. Please copy and paste the following token into the reset password page below: <strong>{$token}</strong></p><p>Reset your password now: <a href='{$reset_link}'>{$reset_link}</a></p><p>If you did not request to reset your password, please disregard this email.</p><p>If you have any questions or need further assistance, please do not hesitate to contact our support team at GoFly@gmail.com.</p><p>Thank you,<br>GoFly</p>"

    );

    // Send the email using SendGrid API
    $sendgrid = new \SendGrid(SENDGRID_API_KEY);
    try {
        $response = $sendgrid->send($email);
        header("Location: emailsent.html");
        exit;
    } catch (Exception $e) {
        $message = "Error sending email: " . $e->getMessage();
    }
}
?>

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
    <title>Forgot password</title>
</head>
<body>
    <nav>
        <div class="logo">
            <h4><a href="landing2.html">Gofly</a></h4>
        </div>
        <ul class="nav-links">
            <li><a href="#">Reviews</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="signup.php">Register</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="container">
        <form method="post" class="form">
            <h2 style="font-size: 2rem;">Forgot Password</h2>
            <input class="box" type="email" name="email" placeholder="Email" required>
            <input type="submit" value="Reset" id="submit">
            <p1 id="p-login"> Return to <a href="login.php"><u>Login</u></a></p1>
        </form>
        
        <div class="side">
            <img src="photos/bgpic1.png" alt="">
        </div>
    </div>

    <script src="land.js"></script>
    
</body>
</html>