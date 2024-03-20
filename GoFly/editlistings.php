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
    header('Location: displaylist.php');
    exit();
}



//Get the ticket ID from the query parameter.
$ticket_id = $_GET['id'];


// Get the current ticket information from the database
$stmt = mysqli_prepare($db_connection, "SELECT * FROM flight_listings WHERE id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $ticket_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$ticket = mysqli_fetch_assoc($result);

$airline = $ticket['airline'];
$flight_number = $ticket['flight_number'];
$departure = $ticket['departure'];
$arrival = $ticket['arrival'];
$date = $ticket['departure_date'];
$time = $ticket['departure_time'];
$duration = $ticket['duration'];
$price = $ticket['price'];
$seats = $ticket['seats'];
$class = $ticket['class'];

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


    <div class="container">
        <form autocomplete="off" method="post" class="form" action='updateListing.php?id=' .$ticket_id .>
            <h2>Edit Flight Listing</h2>
            <p class="failed">
                <?php
                if(isset($_SESSION['status'])){
                    echo $_SESSION['status'];
                    unset($_SESSION['status']);
                }
            ?>
            </p> 


            <section class="child">
                <p>Airline Name</p>
                <input list="air-name-lists" class="box" type="text" name="airline" value="<?php echo $airline; ?>"
                    required>
                <datalist id="air-name-lists">
                    <option>Emirates</option>
                    <option>Delta</option>
                    <option>Jet Blue</option>
                    <option>American Airlines</option>
                    <option>Qatar</option>
                </datalist>

                <p>Flight Number</p>
                <input class="box" type="text" name="flightnumber" value="<?php echo $flight_number; ?>" readonly>

                <p><label for="departure">Departure Airport:</label></p>
                <input list="airports" class="box" type="text" id="departure" name="departure" 
                    value="<?php echo $departure; ?>"
                    maxlength="3" required><br>

                <datalist id="airports">
                    <option>JFK</option>
                    <option>BUF</option>
                    <option>SAF</option>
                    <option>LAG</option>
                    <option>DAC</option>
                </datalist>

                <p><label for="arrival">Arrival Airport:</label></p>
                <input list="airports" class="box" type="text" id="arrival" name="arrival" 
                    value="<?php echo $arrival; ?>"
                    maxlength="3" required><br>

                <datalist id="airports">
                    <option>JFK</option>
                    <option>BUF</option>
                    <option>SAF</option>
                    <option>LAG</option>
                    <option>DAC</option>
                </datalist>

                <p><label for="date">Departure Date:</label></p>
                <input class="box" type="date" id="date" name="date" value="<?php echo $date; ?>" required><br>



            </section>
            <section class="child">
                <p><label for="price">Price:</label></p>
                <input class="box" type="number" id="price" name="price" value="<?php echo $price; ?>" required><br>

                <p><label for="seats">Available Seats:</label></p>
                <input class="box" type="number" id="seats" name="seats" value="<?php echo $seats; ?>" required><br>


                <p><label for="seats">Flight Class:</label></p>
                <select class="box" id="seats"  name="fclass" value="<?php echo $class; ?>">
                    <option >Economy</option>
                    <option >Economy Premium</option>
                    <option >Busines Class</option>
                    <option >First Class</option>
                </select>






                <p><label for="time">Departure Time:</label></p>
                <input class="box" type="time" id="time" name="time"  value="<?php echo $time; ?>" required><br>

                <p><label for="duration">Duration In Hours:</label></p>
                <input class="box" type="text" id="duration" name="duration" value="<?php echo $duration; ?>" required><br>
            </section>





            <input type="submit" value="Save Listing" id="submit">
            <a class="btn-4" href="admin_displaylist.php">Cancel</a>
            
        </form>
        
        
    </div> 



    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>

</body>

</html>