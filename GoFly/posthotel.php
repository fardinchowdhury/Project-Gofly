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

           // Handle room images upload
        $room_images = array();
        $total_files = count($_FILES['roomimage']['name']);
        $max_files = 4; // set maximum number of files to 4
        for($i=0; $i<$total_files && $i<$max_files; $i++){ // iterate through files up to maximum number
            $room_target_dir = "uploads/";
            $room_target_file = $room_target_dir . basename($_FILES['roomimage']['name'][$i]);
            $room_uploadOk = 1;
            $room_imageFileType = strtolower(pathinfo($room_target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $room_check = getimagesize($_FILES['roomimage']['tmp_name'][$i]);
            if($room_check !== false) {
                $room_uploadOk = 1;
            } else {
                $room_uploadOk = 0;
            }

            // Read image file contents
            $room_image = file_get_contents($_FILES['roomimage']['tmp_name'][$i]);
            $room_images[] = base64_encode($room_image);
        }

        // Check if maximum number of files exceeded
        if($total_files > $max_files){
            $_SESSION['image_error'] = "Error: Maximum number of files exceeded. Only ".$max_files." files allowed.";
            exit();
        }

        // Convert room images to JSON-encoded array
        $room_images_json = json_encode($room_images);
       
           // Insert record into database
           $stmt = $db_connection->prepare("INSERT INTO hotel_listings (hotel_name, hotel_description, hotel_address, hotel_city, hotel_zipcode, hotel_room, hotel_price, hotel_image, room_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
           $stmt->bind_param("ssssssiss", $name, $description, $address, $city, $zipcode, $room, $price, $image, $room_images_json);
       
           if ($stmt->execute()) {
               // Redirect to success page
               header("Location: admin_hotelDisplay.php");
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
    <link rel="stylesheet" href="post.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Edit Profile</title>
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
        <form method="post" enctype="multipart/form-data">
            <label for="name">Hotel name:</label>
            <input type="text" id="name" name="name" placeholder="Enter hotel name" required>

            <label for="address">Hotel address:</label>
            <input type="text" id="address" name="address" placeholder="Enter hotel address" required>

            <label for="city">City:</label>
            <select id="city" name="city" required>
                <option value="">Select a city</option>
                <?php
      $us_cities = array("New York City", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville", "Fort Worth", "Columbus", "San Francisco");
      foreach ($us_cities as $city) {
        echo "<option value='$city'>$city</option>";
      }
    ?>
            </select>

            <label for="zipcode">Zip code:</label>
            <input type="text" id="zipcode" name="zipcode" placeholder="Enter zip code" required>

            <label for="room_type">Room type:</label>
            <select id="room_type" name="room_type" required>
                <option value="">Select a room type</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="King">King</option>
                <option value="Queen">Queen</option>
                <option value="Suite">Suite</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter hotel description" required></textarea>

            <label for="image">Hotel image:</label>
            <input type="file" id="image" name="image" required>

            <label for="roomimage">Room Images:</label>
            <input type="file" id="roomimage" name="roomimage[]" multiple required>

            <label for="price">Price per night:</label>
            <input type="text" id="price" name="price" placeholder="Enter price per night" required>

            <input type="submit" value="Submit">
        </form>

    </div>







    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>

</body>

</html>

<style>

</style>