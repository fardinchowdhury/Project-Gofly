<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();

}

// Check if the user is logged in and has the user type "admin"
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user') {
    // The user is not an admin, so redirect to regular users' landing page.
    header('Location: admin_displaylist.php');
    exit();
}

$_SESSION['firstflight'] = $_GET['id'];


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
        <h1>Return Flights</h1>
    </div>

        

<?php
	require_once("config.php");

	$limit = 5;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($page - 1) * $limit;

    // Retrieve input values from the form
//   $flight_type = $_SESSION['flight-type'];
$_SESSION['first_flight'] = $_GET['id'];
  
  $origin = $_SESSION['Origin'];
  $destination = $_SESSION['Destination'];
  $departure_date = $_SESSION['Departure'];
  $arrival_date = $_SESSION['Arrival'];
//   $num_adults = $_SESSION['adults'];
  $class_type = $_SESSION['class-type'];

   
  $sql = "SELECT * FROM flight_listings 
            WHERE departure = '$destination' 
            AND arrival = '$origin' 
            AND departure_date = '$arrival_date'

            LIMIT $limit OFFSET $offset";

	$result = mysqli_query($db_connection, $sql);
    

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			?>

			<!-- Creating Lufthansa Listing -->
			<div class="container">
				<div class="box">
                    <?php $_SESSION['return_flight'] = $row['id']; ?>

					<div action='editlistings.php' class="ticket" method="get">
						<span class="airline"><?php echo $row["airline"]; ?></span>
						<span class="airline airlineslip">Price</span>
						<div class="content">
							<span class="logo-1">
								<img src="photos/lufthansa.svg">
							</span>
							<span class="jfk"><?php echo $row["departure"]; ?></span>
                            <span class="plane">
                            <svg
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                height="60"
                                width="60"
                                image-rendering="optimizeQuality"
                                shape-rendering="geometricPrecision"
                                text-rendering="geometricPrecision"
                                viewBox="0 0 500 500"
                                xmlns="http://www.w3.org/2000/svg">
                                <g stroke="#222">
                                    <line
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-width="30"
                                        x1="300"
                                        x2="55"
                                        y1="390"
                                        y2="390"/>
                                    <path
                                        d="M98 325c-9 10 10 16 25 6l311-156c24-17 35-25 42-50 2-15-46-11-78-7-15 1-34 10-42 16l-56 35 1-1-169-31c-14-3-24-5-37-1-10 5-18 10-27 18l122 72c4 3 5 7 1 9l-44 27-75-15c-10-2-18-4-28 0-8 4-14 9-20 15l74 63z"
                                        fill="#222"
                                        stroke-linejoin="round"
                                        stroke-width="10"/>
                                </g>
                            </svg>
                            
                        </span>
							<span class="sfo"><?php echo $row["arrival"]; ?></span>
                            
							<span style="align-items: center;" class="plane price">
								<h1><?php echo "$" . " " . $row["price"]; ?></h1>
                                

							</span>
							<div class="sub-content">
								<span style="display:inline-block; white-space: nowrap; overflow: hidden; max-width: 9ch;" class="watermark"><?php echo $row["airline"]; ?></span>
								<span class="name">BOARDING TIME<span>
										<br>
										<span><?php echo $row["departure_date"] . " " . $row["departure_time"]; ?></span>
									</span>
								</span>

								<span class="gate">FLIGHT N&deg;<br>
									<span><?php echo $row["flight_number"]; ?></span>
									
								</span>
                                <span class="price plane">
                                    <?php echo '<a class="btn-3" href="addbooking.php?id=' . $row["id"]. '">Book Now</a>' ?>
                                </span>
							</div>
						</div>
					</div>
				</div>
			</div>

		<br>
        <?php
		}
		
	 } else {
        ?>
        <div class="wel">
            <h1>
                <?php echo "No results found. Use a different Date";?>
                
            </h1>
            <a class="btn-3" style="width:30%; margin:0 auto; " href="landing.php">Search Again</a>'
            
        </div>
		<?php
	}

  
    

    mysqli_close($db_connection);
?>






    

    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>
</body>
</html>