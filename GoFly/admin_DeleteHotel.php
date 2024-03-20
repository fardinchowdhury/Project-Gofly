<?php
session_start();
require_once ("config.php");


// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is logged in and has the user type "admin"
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    // The user is not an admin, so redirect to regular users' landing page.
    header('Location: displaylist.php');
    exit();
}

//Get the ticket ID from the query parameter.
$hotel_id = $_GET['id'];


// Get the current ticket information from the database
$stmt = mysqli_prepare($db_connection, "DELETE FROM hotel_listings WHERE id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $hotel_id);
mysqli_stmt_execute($stmt);

//Check if the ticket was deleted
if(mysqli_stmt_affected_rows($stmt) > 0){
    header("Location: admin_hotelDisplay.php");
    exit();
}


mysqli_stmt_close($stmt);
$db_connection->close();

?>