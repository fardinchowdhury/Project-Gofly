<?php
require_once("config.php");
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit();

}

// Check if the user is logged in and has the user type "admin"
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    // The user is not an admin, so redirect to regular users' landing page.
    header('Location: displayhotel1.php');
    exit();
}



//Get the ticket ID from the query parameter.
$hotel_id = $_GET['id'];


// Get the current ticket information from the database
$stmt = mysqli_prepare($db_connection, "SELECT * FROM hotel_listings WHERE id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $hotel_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$ticket = mysqli_fetch_assoc($result);

$hotelName = $ticket['hotel_name'];
$hotelAddress = $ticket['hotel_address'];
$hotelCity = $ticket['hotel_city'];
$hotelZipcode = $ticket['hotel_zipcode'];
$hotel_room = $ticket['hotel_room'];
$hotel_description = $ticket['hotel_description'];
$hotel_price = $ticket['hotel_price'];
$hotel_image = $ticket['hotel_image'];


mysqli_close($db_connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Edit Listings</title>
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

    <div class="form-container">
        <h2>Hotel Listing</h2>
        <p class="failed">
            <?php
                if(isset($_SESSION['status'])){
                    echo $_SESSION['status'];
                    unset($_SESSION['status']);
                }
            ?>
        </p>
        <form method="post" action="updateHotelListing.php">
            <label for="name">Hotel name:</label>
            <input type="text" id="name" name="hotel_name" value="<?php echo $hotelName; ?>" readonly>

            <label for="address">Hotel address:</label>
            <input class="box" type="text" name="hotel_address" value="<?php echo $hotelAddress; ?>">

            <label for="city">City:</label>
            <select id="city" name="city" required>
                <option value="<?php echo $hotelCity ;?>">Select a city</option>
                <?php
      $us_cities = array("New York City", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville", "Fort Worth", "Columbus", "San Francisco");
      foreach ($us_cities as $city) {
        echo "<option value='$city'>$city</option>";
      }
    ?>
            </select>

            <label for="zipcode">Zip code:</label>
            <input list="hotels" class="box" type="number" id="zipcode" name="hotel_zipcode"
                value="<?php echo $hotelZipcode; ?>" maxlength="5" required><br>

            <label for="room_type">Room type:</label>
            <select class="box" id="room" name="hotel_room" value="<?php echo $hotel_room; ?>">
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="King">King</option>
                <option value="Queen">Queen</option>
                <option value="Suite">Suite</option>

            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter hotel description" required></textarea>

            <label for="price">Price per night:</label>
            <input class="box" type="number" id="price" name="hotel_price" value="<?php echo $hotel_price; ?>"
                required><br>

            <input type="submit" value="Submit">
            <a type="submit"class="btn-4" href="admin_hotelDisplay.php">Cancel</a>
        </form>

    </div>



    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>

</body>

</html>