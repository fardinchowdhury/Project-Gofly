<?php
session_start();
require_once ("config.php");


// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}



$ticket_id = $_GET['ticket_id'];
$ticket_ids = explode('-', $ticket_id);
$first_id= $ticket_ids[0];
$second_id = $ticket_ids[1];

$username = $_SESSION['username'];

$sql = mysqli_prepare($db_connection, "DELETE FROM user_booking WHERE user = ? AND ticket_id = ? AND return_ticket_id = ?");
mysqli_stmt_bind_param($sql, "sii", $username, $first_id, $second_id);
mysqli_stmt_execute($sql);

//Check if the ticket was deleted
if(mysqli_stmt_affected_rows($sql) > 0){
    header("Location: mybooking.php");
    exit();
} 



mysqli_stmt_close($sql);
$db_connection->close();
    


?>