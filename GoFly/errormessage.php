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
        include_once 'navbar.php';
    } else {
        session_start();
        // Session is not active
        include_once 'navbar.php';

    }
        
    ?>


    <div class="container">
        <form autocomplete="off" method="post" class="form" action='updateListing.php'>
            <h2>Error Message</h2>
            <p class="failed">
                <?php
                if(isset($_SESSION['status'])){
                    echo $_SESSION['status'];
                    unset($_SESSION['status']);
                }
            ?>
            </p> 

<!-- 
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
                <input class="box" type="time" id="time" name="time"  value="<?php echo $time; ?>"><br>

                <p><label for="duration">Duration In Hours:</label></p>
                <input class="box" type="text" id="duration" name="duration" value="<?php echo $duration; ?>" required><br>
            </section> -->





            <!-- <input type="submit" value="Save Listing" id="submit"> -->
            <a class="btn-4" href="#" onclick="window.history.back(); return false;">Cancel</a>

        </form>
        
        
    </div> 



    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>

</body>

</html>