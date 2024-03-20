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


        
$sql = mysqli_prepare($db_connection, "DELETE FROM flight_listings WHERE flight_number = ?");
mysqli_stmt_bind_param($sql, "s", $flight_number);
mysqli_stmt_execute($sql);

//Check if the ticket was deleted
if(mysqli_stmt_affected_rows($sql) > 0){
    header("Location: admin_displaylist.php");
    exit();
}



mysqli_stmt_close($stmt);
mysqli_stmt_close($sql);
$db_connection->close();

?>