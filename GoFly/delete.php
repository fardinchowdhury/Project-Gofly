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
    <title>Delete Account</title>
</head>
<body>
<nav>
    <div class="logo">
        <h4>
            <a href="landing.php">Gofly</a>
        </h4>
    </div>
    <ul class="nav-links">
        <li>
            <a href="displaylist.php">Listings</a>
        </li>
        <li>
            <a href="#">Reviews</a>
        </li>
        <li>
            <a href="#">Contact Us</a>
        </li>
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
                    <a href="profile.php">My Profile</a>
                    <a href="post_listing.php">Post Listing</a>
                    <a class="fpwd" href="change_pass.php">Change Password</a>
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
        <form action="deleteProfile.php" method="post" class="form">
            <h2 style="font-size: 2rem;">Are you sure you want to delete your account?</h2>
            <p class="failed">
                <?php
                    if(isset($_SESSION['status'])){
                        echo $_SESSION['status'];
                        unset($_SESSION['status']);
                    }
                ?>
            </p>
            <input class="box" type="password" name="password" placeholder="Current Password" id = 'password' required>
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