<nav>
        <div class="logo">
            <h4><a href="admin_landing.php">Gofly</a></h4>
        </div>
        <ul class="nav-links">

            <li><a href="post_listing.php">Post Flights</a></li>
            <li><a href="posthotel.php">Post Hotels</a></li>


            
            <li>
                <div class="dropdown">
                    <a href="#">
                    <i class="fa-solid fa-user"></i>
                    <?php
                    if(isset($_SESSION["username"])) {
                        $username = $_SESSION['username'];
                        echo "$username";
                    }
                    ?>
                </a>
                <!-- dropdown for the user -->
                    <div class="dropdown-content">
                        <a href="profile.php">My Profile</a>
                        <a class="fpwd" href="change_pass.php">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
        
        <!-- Create a burger for mobile view -->
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    