<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();

}

// // Check if the user is logged in and has the user type "admin"
// if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user') {
//     // The user is not an admin, so redirect to regular users' landing page.
//     header('Location: admin_displaylist.php');
//     exit();
// }


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
    <link rel="stylesheet" href="display.css">
    <link rel="stylesheet" href="hoteldisplay.css">
    <title>Listings</title>
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

    <div class="wel"> 
    <?php
        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            echo "<h1>Welcome, $username!</h1>";
        }
    ?>
    </div>

    <div class="sort-dropdown">
        <form action="sort_hotel.php" method="post">
            <label for="sort" class="sort-label">Sort by:</label>
            <div class="select-container">
                <select name="sort" id="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="">Select</option>
                    <option value="price_high_low"
                        <?= isset($_SESSION['selected_sort']) && $_SESSION['selected_sort'] == 'price_high_low' ? 'selected' : ''; ?>>
                        Price High-Low</option>
                    <option value="price_low_high"
                        <?= isset($_SESSION['selected_sort']) && $_SESSION['selected_sort'] == 'price_low_high' ? 'selected' : ''; ?>>
                        Price Low-High</option>
                    <option value="hotel_name"
                        <?= isset($_SESSION['selected_sort']) && $_SESSION['selected_sort'] == 'hotel_name' ? 'selected' : ''; ?>>
                        Hotel Name</option>
                    <option value="hotel_city"
                        <?= isset($_SESSION['selected_sort']) && $_SESSION['selected_sort'] == 'hotel_city' ? 'selected' : ''; ?>>
                        Hotel City</option>
                </select>
            </div>
        </form>
    </div>


 
    <?php
	require_once("config.php");

    $city = $_SESSION['search_city'];
    $check_in = $_SESSION['check_in'];
    $check_out = $_SESSION['check_out'];
    $adults = $_SESSION['hotel_adults'];

        // Create DateTime objects from the date strings
    $check_in = new DateTime($check_in);
    $check_out = new DateTime($check_out);

    // Calculate the difference between the check-in and check-out dates
    $interval = $check_in->diff($check_out);
    $duration = $interval->format('%a'); // Get the difference in days

    

	$limit = 5;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($page - 1) * $limit;

    if (isset($_SESSION["sorted_listings"])) {
        $listings = $_SESSION["sorted_listings"];
    } else {
        

        $sql = "SELECT * FROM hotel_listings
        WHERE hotel_city = '$city'
        LIMIT $limit OFFSET $offset";

        $result = mysqli_query($db_connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $listings = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $listings = [];
        }
    }
    

	if (count($listings) > 0) {
		// output data of each row
		foreach ($listings as $row) {
			?>

    <div class="wrapper">
            <h1><?php echo $row["hotel_name"]; ?></h1>
            <div class="image hotel-image">
                <?php
                $image_data = $row["hotel_image"];
                $encoded_image = base64_encode($image_data);
                $image_src = "data:image/jpeg;base64," . $encoded_image;
                ?>
                
                <img src="<?php echo $image_src; ?>" alt="Hotel Image">
            </div>
            <div class="details">
                <h1>
                    <em><?php echo $row["hotel_city"]; ?></em>
                </h1>
                <h4><?php echo $row["hotel_room"]; ?></h4>
                <p><?php echo $duration . " days " . ($duration - 1) . " nights"; ?></p>
            </div>
            <h1><?php echo "$".$row["hotel_price"]* ($duration-1); ?></h1>
            <div class="btn-frame"><a href="addbookinghotel.php?id=hotel<?php echo $row['id']; ?>" style="width:45%;" class="custom-btn btn-3">Book Now</a>
            <a href="hotel_details.php?id=<?php echo $row['id']; ?>" style="width:45%;" class="custom-btn btn-3" id="view-details">View Details</a>
            </div>
            

            
        </div>

		<br>
        <?php
		}
        unset($_SESSION["sorted_listings"]); // Unset the sorted_listings session variable so that the next time the page is loaded, the listings are not sorted.

		// add pagination links
		$sql = "SELECT COUNT(*) AS count FROM hotel_listings";
		$result = mysqli_query($db_connection, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = $row['count'];
		$pages = ceil($count / $limit);
		if ($pages > 1) {
			?>
            <div class="pagination">
            <?php
			for ($i = 1; $i <= $pages; $i++) {
				if ($i == $page) {
					echo "<span class='current'>$i</span>";
				} else {
					echo "<a href='?page=$i'>$i</a>";
				}
			}
			?>
            </div>
            <?php
		}
	} else {
		echo "<p>No results found.</p>";
	}

	mysqli_close($db_connection);
?>





    

    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>
</body>
</html>