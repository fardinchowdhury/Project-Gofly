<?php
session_start();
require_once ("config.php");

// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Retrieve the records from the user_booking table based on the current user's username
$sql = "SELECT * FROM user_booking WHERE user=?";

$stmt = $db_connection ->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Create an empty array to store ticket IDs
$ticket_ids = array();
$roundtrip_ids = array();
$hotel_ids = array();



// Loop through the records and add the ticket IDs and hotel IDs to the arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["ticket_id"] !== null && $row["hotel_id"] == null ) {
            $ticket_ids[] = $row["ticket_id"];
        }
        if ($row["hotel_id"] !== null && $row["ticket_id"] == null ) {
            $hotel_ids[] = $row["hotel_id"];
        }
        if ($row["ticket_id"] !== null && $row["return_ticket_id"] !== null && $row["hotel_id"] == null ) {
            
            $roundtrip_ids[] = array($row["ticket_id"], $row["return_ticket_id"]);

        }
    }
} else {
    // echo "<p>No tickets found for $username</p>";
}
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
    <link rel="stylesheet" href="book.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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

    <h1 class="header">
        <?php
        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            echo "$username's Booking";
        }
    ?>
    </h1>

    <br> </br>

    <div class="buttons-container">
    
    <div style="text-align: center;">
  <button onclick="showPage1()" class="btn-flight active">Flights</button>
  <button onclick="showPage2()" class="btn-hotel">Hotels</button>
</div>









    </div>


    <section id="flight-section">


    <?php

    
    // Loop through the ticket IDs and retrieve the corresponding flight data
    foreach ($ticket_ids as $ticket_id) {
    // Retrieve the flight data based on the ticket ID
    $sql = "SELECT * FROM flight_listings WHERE id='$ticket_id'";
    $result = $db_connection->query($sql);
    // Display the flight data
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // echo $row["airline"];
        ?>
    <div class="container2">
        <div class="ticket">
            <div class="left">
                <div class="image">
                    <p class="admit-one">
                        <span>TICKET</span>
                        <span>TICKET</span>
                        <span>TICKET</span>
                    </p>
                    <div class="ticket-number">
                        <p>
                            <?php  echo $row["flight_number"];?>
                        </p>
                    </div>
                </div>
                <div class="ticket-info">

                    <p class="date">
                        <span>TUESDAY</span>
                        <span class="june-29">JUNE 29TH</span>
                        <span>2021</span>
                    </p>

                    <div class="show-name">
                        <?php  echo  $row["airline"];?>

                        <h2>
                            <?php  echo $row["departure"];?>
                            <span>
                                <svg clip-rule="evenodd" fill-rule="evenodd" height="60" width="60"
                                    image-rendering="optimizeQuality" shape-rendering="geometricPrecision"
                                    text-rendering="geometricPrecision" viewbox="0 0 500 500"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g stroke="#222">
                                        <line fill="none" stroke-linecap="round" stroke-width="30" x1="300" x2="55"
                                            y1="390" y2="390" />
                                        <path
                                            d="M98 325c-9 10 10 16 25 6l311-156c24-17 35-25 42-50 2-15-46-11-78-7-15 1-34 10-42 16l-56 35 1-1-169-31c-14-3-24-5-37-1-10 5-18 10-27 18l122 72c4 3 5 7 1 9l-44 27-75-15c-10-2-18-4-28 0-8 4-14 9-20 15l74 63z"
                                            fill="#222" stroke-linejoin="round" stroke-width="10" />
                                    </g>
                                </svg>
                                <?php  echo $row["arrival"];?>
                        </h2>


                        </span>
                    </div>

                    <div class="time">
                        <p><?php  echo $row["departure_date"];?></< /p>
                        <p><?php  echo $row["departure_time"];?></p>
                    </div>
                    

                </div>
            </div>

            <div class="right">


                <div class="barcode">

                    <img src="https://external-preview.redd.it/cg8k976AV52mDvDb5jDVJABPrSZ3tpi1aXhPjgcDTbw.png?auto=webp&s=1c205ba303c1fa0370b813ea83b9e1bddb7215eb"
                        alt="QR code">
                </div>
                <?php echo '<a class="btn-3" href="cancel_ticket.php?ticket_id=' . $row["id"] . '">Delete Ticket</a>' ?>

            </div>

        </div>
    </div>


    <?php
        } else {
            echo "<p>No flight data found for ticket ID $ticket_id</p>";
        }
        }

        foreach ($roundtrip_ids as $roundtrip_id) {
            // Retrieve the flight data based on the ticket ID
            $sql = "SELECT * FROM flight_listings WHERE id='$roundtrip_id[0]'";
            $result = $db_connection->query($sql);

            
            
            $sql2 = "SELECT * FROM flight_listings WHERE id='$roundtrip_id[1]'";
            $result2 = $db_connection->query($sql2);
            // Display the flight data
            if ($result->num_rows > 0 && $result2->num_rows > 0) {
                $row = $result->fetch_assoc();
                $row2 = $result2->fetch_assoc();
        
                // echo $row["airline"];
                ?>

<div class="container2">
        <div class="ticket">
            <div class="left">
                <div class="image">
                    <p class="admit-one">
                        <span>TICKET</span>
                        <span>TICKET</span>
                        <span>TICKET</span>
                    </p>
                    <div class="ticket-number">
                        <p>
                            <?php  echo "Flight 1: " . $row["flight_number"];?>
                            <br>
                            <?php  echo "Flight 2: " . $row2["flight_number"];?>
                        </p>
                    </div>
                </div>
                <div class="ticket-info">

                    <p class="date">
                        <span></span>
                        <span class="june-29"></span>
                        <span></span>
                    </p>

                    <div class="show-name">
                        <?php  echo  $row["airline"];?>

                        <h4>
                            <?php  echo $row["departure"];?>
                            <span>
                                <svg clip-rule="evenodd" fill-rule="evenodd" height="60" width="60"
                                    image-rendering="optimizeQuality" shape-rendering="geometricPrecision"
                                    text-rendering="geometricPrecision" viewbox="0 0 500 500"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g stroke="#222">
                                        <line fill="none" stroke-linecap="round" stroke-width="30" x1="300" x2="55"
                                            y1="390" y2="390" />
                                        <path
                                            d="M98 325c-9 10 10 16 25 6l311-156c24-17 35-25 42-50 2-15-46-11-78-7-15 1-34 10-42 16l-56 35 1-1-169-31c-14-3-24-5-37-1-10 5-18 10-27 18l122 72c4 3 5 7 1 9l-44 27-75-15c-10-2-18-4-28 0-8 4-14 9-20 15l74 63z"
                                            fill="#222" stroke-linejoin="round" stroke-width="10" />
                                    </g>
                                </svg>
                                <?php  echo $row["arrival"];?>
                                <br>
                                <?php  echo $row2["departure"];?>
                            <span>
                                <svg clip-rule="evenodd" fill-rule="evenodd" height="60" width="60"
                                    image-rendering="optimizeQuality" shape-rendering="geometricPrecision"
                                    text-rendering="geometricPrecision" viewbox="0 0 500 500"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g stroke="#222">
                                        <line fill="none" stroke-linecap="round" stroke-width="30" x1="300" x2="55"
                                            y1="390" y2="390" />
                                        <path
                                            d="M98 325c-9 10 10 16 25 6l311-156c24-17 35-25 42-50 2-15-46-11-78-7-15 1-34 10-42 16l-56 35 1-1-169-31c-14-3-24-5-37-1-10 5-18 10-27 18l122 72c4 3 5 7 1 9l-44 27-75-15c-10-2-18-4-28 0-8 4-14 9-20 15l74 63z"
                                            fill="#222" stroke-linejoin="round" stroke-width="10" />
                                    </g>
                                </svg>
                                <?php  echo $row2["arrival"];?>
                        </h4>


                        </span>
                    </div>

                    <div class="time">
                        <p><?php  echo $row["departure_date"] . ' to ' . $row2['departure_date']?></< /p>
                        
                    </div>
                    

                </div>
            </div>

            <div class="right">


                <div class="barcode">

                    <img src="https://external-preview.redd.it/cg8k976AV52mDvDb5jDVJABPrSZ3tpi1aXhPjgcDTbw.png?auto=webp&s=1c205ba303c1fa0370b813ea83b9e1bddb7215eb"
                        alt="QR code">
                </div>
                <?php echo '<a class="btn-3" href="cancel_return_ticket.php?ticket_id=' . $row["id"] . '-' . $row2['id'] . '">Delete Ticket</a>' ?>

            </div>

        </div>
    </div>
            

            
        
        
            <?php
                } else {
                    echo "<p>No flight data found for ticket ID $ticket_id</p>";
                }
                }
        
    ?>

    </section>

    <section id="hotel-section">

    <?php

    

        foreach ($hotel_ids as $hotel_id) {
            // Retrieve the flight data based on the ticket ID
            $sql = "SELECT * FROM hotel_listings WHERE id='$hotel_id'";
            $result = $db_connection->query($sql);
            // Display the flight data
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                // echo $row["airline"];
                ?>
            <div class="hotel-listing">
		<div class="hotel-image">
        
        <?php
                        $image_data = $row["hotel_image"];
                        $encoded_image = base64_encode($image_data);
                        $image_src = "data:image/jpeg;base64," . $encoded_image;
                    ?>
                    <img src="<?php echo $image_src; ?>" alt="Hotel Image">
		</div>
		<div class="hotel-info">
			<h2><?php echo $row["hotel_name"]; ?></h2>
			<p><strong>Room Type: </strong><?php echo $row["hotel_room"]; ?></p>
			<p><strong>City: </strong><?php echo $row["hotel_city"]; ?></p>
			<p><strong>Price per night: </strong><?php echo '$'. $row["hotel_price"]; ?></p>
			
            <a href="cancel_ticket.php?id=hotel<?php echo $row['id']; ?>" style="width:60%;" class="btn-2">Cancel Booking</a>


		</div>
	</div>
        
        
            <?php
                } 
                }

        $db_connection->close();
    ?>
     </section>

    </div>



    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>

</body>

<style>
   .hotel-listing {
	background-color: #fff;
    width: 800px;
    margin: 10% auto 0;
    padding: 20px;
    box-shadow: 0px 0px 10px #ccc;
    display: flex;
    justify-content: left;
    align-items: center;
  }

.hotel-image {
	width: 200px;
	height: 200px;
	margin-right: 20px;
}

.hotel-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.hotel-info h2 {
	margin-top: 0;
	font-weight: bold;
	font-size: 24px;
	margin-bottom: 10px;
}

.hotel-info p {
	margin-bottom: 10px;
	font-size: 16px;
}

.hotel-info strong {
	font-weight: bold;
}

.hotel-info button {
	background-color: #008CBA;
	color: #fff;
	padding: 10px 20px;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	font-size: 16px;
	margin-top: 10px;
}

.hotel-info button:hover {
	background-color: #004265;
}

.btn-flight.active {
  background-color: grey;
  color: white;
}

.btn-hotel.active {
  background-color: grey;
  color: white;
}

.btn-flight {
  background-color: white;
  color: grey;
  font-size: 20px;
  padding: 10px 40px;
  margin-right: 10px;
  display: inline-block;
  width: 200px;
  font-weight: bold;
  border: none;
}

.btn-hotel {
  background-color: white;
  color: grey;
  font-size: 20px;
  padding: 10px 40px;
  margin-left: 10px;
  display: inline-block;
  width: 200px;
  font-weight: bold;
  border: none;
}

</style>

<script>
    window.onload = function() {
  showPage1();
}
    
    

    function showPage1() {
  document.getElementById("flight-section").style.display = "block";
  document.getElementById("hotel-section").style.display = "none";
}

function showPage2() {
  document.getElementById("flight-section").style.display = "none";
  document.getElementById("hotel-section").style.display = "block";
}

const btnFlight = document.querySelector('.btn-flight');
  const btnHotel = document.querySelector('.btn-hotel');

  btnFlight.addEventListener('click', function() {
    btnFlight.classList.add('active');
    btnHotel.classList.remove('active');
  });

  btnHotel.addEventListener('click', function() {
    btnHotel.classList.add('active');
    btnFlight.classList.remove('active');
  });
    </script>

</html>