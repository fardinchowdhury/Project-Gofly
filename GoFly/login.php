<?php
require_once('config.php');
// Establish database connection
session_start();


// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($db_connection, $_POST['uid']);
    $password = mysqli_real_escape_string($db_connection, $_POST['pwd']);

        // Check if username or password is empty
        if (empty($username) || empty($password)) {
            $_SESSION['status'] = "Both Username and password are required.";
            header("Location: login.php");
            exit();
        }
    

    // Query the database

    $stmt = $db_connection->prepare("SELECT username, password, user_type FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

        if($stmt->num_rows == 1){
            $stmt->bind_result($username, $hashed_password, $user_type);
            $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Login successfull
            
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user_type;
            
            if($user_type == 'admin') {
                header("Location: admin_landing.php");
                exit();
            }
            else{
                //The user_type = user
                header("Location: landing.php");
                exit();
            }

        } else {
            // Login failed
            header("Location: login.php");
            $_SESSION['status'] = "Invalid username or password";
            exit();
            
        }
    } else {
        // Login failed
        header("Location: login.php");
        $_SESSION['status'] = "Invalid username or password";
        exit();

    }
}

mysqli_close($db_connection);

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
    <title>Login</title>
</head>
<body>
    <nav>
        <div class="logo">
            <h4><a href="landing2.php">Gofly</a></h4>
        </div>
        <ul class="nav-links">
            <li><a href="reviews.php">Reviews</a></li>
           
            <li><a href="landing2.php#contact">Contact Us</a></li>
            <li><a href="signup.php">Register</a></li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="container">
        <form action="login.php" method="post" class="form color-g">
            <h2>Login</h2>
            <p class="failed">
                <?php
                    if(isset($_SESSION['status'])){
                        echo $_SESSION['status'];
                        unset($_SESSION['status']);
                    }
                ?>
            </p>
            <input class="box" type="text" name="uid" placeholder="Username" >
            <input class="box" type="password" name="pwd" placeholder="password" >
            <a class="fpwd" href="forgotpwd.php"><u>Forgot Password?</u></a>
            <input type="submit" value="Login" id="submit">
            <p1 id="p-login"> Don't have a Account? <a href="signup.php"><u>Register</u></a></p1>
        </form>
        <div class="side">
            <img src="photos/bgpic1.png" alt="">
        </div>
    </div>

    <script src="land.js"></script>
    
</body>
</html>

