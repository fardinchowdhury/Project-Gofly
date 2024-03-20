<?php
session_start();
require_once ("config.php");


// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
$hotel = mysqli_fetch_assoc($result);


$hotelname = $hotel['hotel_name'];
$city = $hotel['hotel_city'];
$price = $hotel['hotel_price'];
$image = $hotel['hotel_image'];
$room_type = $hotel['hotel_room'];



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
    <div class="room1">
      <div class="text-cover">

        <h1><?php echo $hotelname ?></h1>
        <h2 class="price"> <?php echo $price?> <span>USD</span> / person</h2>
        <hr>
        <h3>City: <?php echo $city?></h3>
        <h3> <?php echo $room_type?>
        <!-- <h3> <?php echo $room?>  <?php echo $time?></h3> -->

        <?php
                    
                        $encoded_image = base64_encode($image);
                        $image_src = "data:image/jpeg;base64," . $encoded_image;
        ?>
          

           <style>
    .room1 {
        width: 50%;
        height: 100%;
        background: url(<?php echo $image_src; ?>) no-repeat center center;
        
        display: inline-block;
        vertical-align: top;
        position: relative;
    }
</style>


      </div>
    </div><div class="payment">
      <div class="receipt-box">
        <h2 style="padding-bottom:20px;">Reciept Summary</h2>
        <table class="table">
          <tr>
            <td>Room</td>
            <td><?php echo $price?> USD</td>
          </tr>
          <tr>
            <td>Tax</td>
            <td>0 USD</td>
          </tr>
          <tfoot>
            <tr>
              <td>Total</td>
              <td>$<?php echo $price?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="payment-info">
  <h2 style="padding-bottom:20px;">Payment Info</h2>
  <form method="post" action="processhotelbooking.php?id=<?php echo $hotel_id; ?>">
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