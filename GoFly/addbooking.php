<?php
session_start();
require_once ("config.php");


// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}



if($_SESSION['flight-type'] =='Return'){
  $first_flight = $_SESSION['first_flight']; // First Flight ID 
  $return_id = $_SESSION['return_flight']; // Return Flight ID

$_SESSION['Returnflight'] = $_GET['id'];

echo $_SESSION['firstflight'];

echo $_SESSION['Returnflight'];

$stmt = mysqli_prepare($db_connection, "SELECT * FROM flight_listings WHERE id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $first_flight);
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

$stmt = mysqli_prepare($db_connection, "SELECT * FROM flight_listings WHERE id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $return_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$ticket = mysqli_fetch_assoc($result);

$return_airline = $ticket['airline'];
$return_flight_number = $ticket['flight_number'];
$return_departure = $ticket['departure'];
$return_arrival = $ticket['arrival'];
$return_date = $ticket['departure_date'];
$return_time = $ticket['departure_time'];
$return_duration = $ticket['duration'];
$return_price = $ticket['price'];
$return_seats = $ticket['seats'];
$return_class = $ticket['class'];






mysqli_close($db_connection);

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
    <link rel="stylesheet" href="search.css">
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="display.css">
    <link rel="stylesheet" href="addbook.css">
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

    <div class="container2">
    <div class="model">
    <div class="room">

    <div class="text-cover">
      <h1 style="text-align:center;">First Flight</h1>
      <hr>
      <h1><?php echo $departure ?> To <?php echo $arrival ?> </h1>
      <h2 class="price"> <?php echo $price?> <span>USD</span> / person</h2>
      <hr>
      <h3>Flight: <?php echo $flight_number?></h3>
      <h3> <?php echo $date?>  <?php echo $time?></h3>
    </div>

    <div class="text-cover">
        <h1 style="text-align:center;">Return Flight</h1>
        <hr>
        <h1><?php echo $return_departure ?> To <?php echo $return_arrival ?> </h1>
        <h2 class="price"> <?php echo $return_price?> <span>USD</span> / person</h2>
        <hr>
        <h3>Flight: <?php echo $return_flight_number?></h3>
        <h3> <?php echo $return_date?>  <?php echo $return_time?></h3>
    </div>

    </div><div class="payment">
      <div class="receipt-box">
        <h2 style="padding-bottom:20px;">Reciept Summary</h2>
        <table class="table">
          <tr>
            <td>Ticket-1</td>
            <td><?php echo $price?> USD</td>
          </tr>
          <tr>
            <td>Ticket-2</td>
            <td><?php echo $return_price?> USD</td>
          </tr>
          <tr>
            <td>Tax</td>
            <td><?php echo (($return_price + $price)*(10/100)); ?> USD</td>
          </tr>
          <tfoot>
            <tr>
              <td>Total</td>
              <td>$<?php echo (($return_price + $price)*(10/100)) + $return_price + $price?> USD</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="payment-info">
  <h2 style="padding-bottom:20px;">Payment Info</h2>
  <form method="post" action='process_return_booking.php?'>
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    <label>Name on Credit Card</label>
    <input type="text" name="card_name" values="<?php echo $_SESSION['username']; ?>" required>
    <label>Credit Card Number</label>
    <input type="text" name="card_number" value="XXXX_XXXX_XXXX_XXXX" required>
    <br><br>
    <?php 
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
    ?>
    <button class="btn btn-1" type="submit" name="book_securely">Book Securely</button>
    
  </form>
</div>



    </div>

    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>  
   
</body>
      
</html>



<?php
}else{
  
    $ticket_id = $_GET['id']; // Return Flight ID
    include_once 'f12.php';
  
}

?>