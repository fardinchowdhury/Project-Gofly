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
$id = isset($_GET['id']) ? $_GET['id'] : '';

$hotel_id = '';
$ticket_id = '';

if (strpos($id, 'hotel') === 0) {
  // Extract the number from the id parameter
  $hotel_id = substr($id, 5);

  // Use the $hotel_id variable as needed
}else{
    $ticket_id = $_GET['ticket_id'];

}

if ($ticket_id !== ''){
// Get the current ticket information from the database
$stmt = mysqli_prepare($db_connection, "SELECT * FROM user_booking WHERE ticket_id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $ticket_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$ticket = mysqli_fetch_assoc($result);

$id = $ticket['id'];
$user = $ticket['user'];
$ticketID = $ticket['ticket_id'];


        
$sql = mysqli_prepare($db_connection, "DELETE FROM user_booking WHERE ticket_id = ?");
mysqli_stmt_bind_param($sql, "i", $ticketID);
mysqli_stmt_execute($sql);

//Check if the ticket was deleted
if(mysqli_stmt_affected_rows($sql) > 0){
    header("Location: mybooking.php");
    exit();
} 

}

if ($hotel_id !== ' '){
    // Get the current ticket information from the database
$stmt = mysqli_prepare($db_connection, "SELECT * FROM user_booking WHERE hotel_id=?");

//binding the type of parameter
mysqli_stmt_bind_param($stmt, "i", $hotel_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$hotel = mysqli_fetch_assoc($result);

$id = $hotel['id'];
$user = $hotel['user'];
$ticketID = $hotel['hotel_id'];


        
$sql = mysqli_prepare($db_connection, "DELETE FROM user_booking WHERE hotel_id = ?");
mysqli_stmt_bind_param($sql, "i", $ticketID);
mysqli_stmt_execute($sql);

//Check if the ticket was deleted
if(mysqli_stmt_affected_rows($sql) > 0){
    header("Location: mybooking.php");
    exit();
} 

}


mysqli_stmt_close($stmt);
mysqli_stmt_close($sql);
$db_connection->close();

?>