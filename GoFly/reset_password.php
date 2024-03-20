<?php
// Connect to SQL database
require_once ("config.php");

// Define a variable to hold the error message, if any
$error_msg = "";

// Check if the form has been submitted
if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['token'])) {
    // Get the password and token from the form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Check if the passwords match
    if ($password != $confirm_password) {
        $error_msg = "The passwords do not match.";
    }

    // Check if the token is valid
    $sql = "SELECT * FROM users WHERE reset_token='$token'";
    $result = mysqli_query($db_connection, $sql);

    if (mysqli_num_rows($result) == 0) {
        $error_msg = "Invalid reset token.";
    }

    // If there are no errors, update the user's password in the database
    if (empty($error_msg)) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$hashedPassword', reset_token=NULL WHERE username='$username'";
        mysqli_query($db_connection, $sql);
        header("Location: successpw2.html");
        exit;
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
    <title>Change Password</title>
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
            <li>
                <div class="dropdown">
                    <a href="#">
                    <i class="fa-solid fa-user"></i>
                    <?php
                        session_start();

                        if(isset($_SESSION["username"])) {
                            $username = $_SESSION['username'];
                            echo "$username";
                        }
                    ?>
                    </a>
                <!-- dropdown for the user -->
                    <div class="dropdown-content">
                        <a href="post_listing.php">Post Listing</a>
                        <a href="profile.php">My Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
            
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="container">
        <form method="post" class="form">
            <h2 style="font-size: 2rem;">Reset Password</h2>
            <?php
                // Display the error message, if any
                if (!empty($error_msg)) {
                    echo "<p style='color:red;'>$error_msg</p>";
                }
                ?>
            <input class="box" type="text" name="token" placeholder="Token">
            <input class="box" type="password" name="password" placeholder="New Password" id = 'password'required>
            <input class="box" type="password" name="confirm_password" placeholder="Confirm New Password" id = 'password'required>
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