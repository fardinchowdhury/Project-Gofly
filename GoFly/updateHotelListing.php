<?php
require_once('config.php');
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

       // Handle form submission
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $name = mysqli_real_escape_string($db_connection,$_POST["hotel_name"]);
        $description = mysqli_real_escape_string($db_connection,$_POST["hotel_description"]);
        $address = mysqli_real_escape_string($db_connection,$_POST['hotel_address']);
        $city = mysqli_real_escape_string($db_connection,$_POST['city']);
        $zipcode = mysqli_real_escape_string($db_connection,$_POST['hotel_zipcode']);
        $room = mysqli_real_escape_string($db_connection,$_POST['hotel_room']);
        $price = mysqli_real_escape_string($db_connection,$_POST['hotel_price']);

        // if(empty($_POST['hotel_name']) || empty($_POST['hotel_address']) || empty($_POST['hotel_zipcode']) || empty($_POST['hotel_description']) || empty($_POST['hotel_price'])){
        //     $_SESSION['status'] = "All fields are required";
        //     $_SESSION['form_data'] = $_POST;
        //     header("Location: errormessage.php");
        //     exit();
        // }
    





    $query = "UPDATE hotel_listings SET

    hotel_address = '$address',
    hotel_zipcode = ' $zipcode',
    hotel_room = '$room',
    hotel_description = '$description',
    hotel_price = '$price' WHERE hotel_name = '$name'";
    
    
    if($db_connection->query($query) === TRUE){
        //Redirect to the display listing page
        header("Location: admin_hotelDisplay.php");
        exit();
    }
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db_connection);
    }
    $db_connection->close();
    
    
}


?>
