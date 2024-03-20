<?php
       session_start();
       require_once ("config.php");
       
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
       
       // Handle form submission
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
           // Get form data
           $name = $_POST["name"];
           $description = $_POST["description"];
           $address = $_POST['address'];
           $city = $_POST['city'];
           $zipcode = $_POST['zipcode'];
           $room = $_POST['room_type'];
           $price = $_POST['price'];
       
           // Handle file upload
           $target_dir = "uploads/";
           $target_file = $target_dir . basename($_FILES["image"]["name"]);
           $uploadOk = 1;
           $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       
           // Check if image file is a actual image or fake image
           $check = getimagesize($_FILES["image"]["tmp_name"]);
           if($check !== false) {
               $uploadOk = 1;
           } else {
               $uploadOk = 0;
           }
       
           // Read image file contents
           $image = file_get_contents($_FILES["image"]["tmp_name"]);
       
           // Insert record into database
           $stmt = $db_connection->prepare("INSERT INTO hotel_listings (hotel_name, hotel_description, hotel_address, hotel_city, hotel_zipcode, hotel_room, hotel_price, hotel_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
           $stmt->bind_param("ssssssis", $name, $description, $address, $city, $zipcode, $room, $price, $image);
       
           if ($stmt->execute()) {
               // Redirect to success page
               header("Location: admin_hotel.php");
               exit();
           } else {
               // Handle error
               echo "Error inserting record: " . $stmt->error;
           }
       
           // Close statement
           $stmt->close();
       }
       
       // Close database connection
       $db_connection->close();
       
    
       ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='postHotel.css'>
    <!-- <link rel="stylesheet" href="post.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">

    <title>Post Hotel</title>
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
    <div class="custom-shape-divider-top-1682544526">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                opacity=".25" class="shape-fill"></path>
            <path
                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                opacity=".5" class="shape-fill"></path>
            <path
                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                class="shape-fill"></path>
        </svg>
    </div>

    <div class="container">
        <div class="title">Hotel Listing</div>
        <form method="post" enctype="multipart/form-data">
            <div class="user__details">
                <div class="input__box">
                    <label for = 'name' class="details">Hotel Name</label>
                    <input type="text" id="name" name="name" placeholder="E.g: Hilton" required>
                </div>

                <div class="input__box">
                    <label for="address" class="details">Hotel Address</label>
                    <input type="text" id="address" name="address" placeholder="E.g: 123 Blvd St." required>
                </div>

                <div class="input__box">
                    <label for="city" class="details">City</label>
                    <select id="city"  name="city" required>
                        <option value="">Select a city</option>
                        <?php
      $us_cities = array("New York City", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville", "Fort Worth", "Columbus", "San Francisco");
      foreach ($us_cities as $city) {
        echo "<option value='$city'>$city</option>";
      }
    ?>
                    </select>
                </div>

                <div class="input__box">
                    <label for="zipcode" class="details">ZipCode</label>
                    <input type="number" id="zipcode" name="zipcode" placeholder="E.g: 14123" required min="0"
                        max="99999" required>

                </div>
                <div class="input__box">
                    <label for="room_type" class="details">Room Type</label>
                    <select id="room_type" name="room_type" required>
                        <option value="">Select a room type</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="King">King</option>
                        <option value="Queen">Queen</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="input__box">
                    <span for="price" class="details">Price Per Night</span>
                    <input type="number" id="price" name="price" placeholder="E.g: 235" required>

                </div>

                <div class="input__box">
                    <label for="image" class="details">Hotel image</label>
                    <input type="file" id="image" name="image" required>
                </div>


                <div class="input__box">
                    <label class="details">Room Images</label>
                    <input type="file" id="roomimage" name="roomimage[]" multiple required>

                </div>

                <div class="input__box">
                    <span for="roomimage" for="description" class="details">Description</span>
                    <textarea  rows="4" cols="40" style="resize: none;" id="description"
                        name="description" placeholder="Enter hotel description" required></textarea>
                </div>







            </div>

            <div class="button">
                <input type="submit" value="Submit">
                <a class="btn-4" onclick="history.back()">Cancel</a>
            </div>
        </form>
    </div>

</body>

</html>