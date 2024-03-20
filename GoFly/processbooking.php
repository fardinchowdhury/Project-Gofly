<?php
session_start();
require_once ("config.php");

// Check if the user is logged in.
// If not, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the ticket ID and username from the form



$ticket_id = $_GET['ticket_id'];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check if the user has already booked this ticket
$select_query = "SELECT * FROM user_booking WHERE ticket_id = ? AND user = ?";
$stmt = mysqli_prepare($db_connection, $select_query);
mysqli_stmt_bind_param($stmt, "is", $ticket_id, $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // User has already booked this ticket
    $_SESSION['error'] = "You have already booked this ticket.";
    header("Location: addbooking.php?id=$ticket_id");
    exit();
} else {
    // Prepare the insert statement
    $insert_query = "INSERT INTO user_booking (ticket_id, user) VALUES (?, ?)";

    // Use prepared statements to prevent SQL injection attacks
    $stmt = mysqli_prepare($db_connection, $insert_query);
    mysqli_stmt_bind_param($stmt, "is", $ticket_id, $username);

    // Execute the insert statement
    if(mysqli_stmt_execute($stmt)){
      // Record added successfully
      header("Location: mybooking.php");
      exit();
    } else {
      echo "Error: " . mysqli_error($db_connection);
    }
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($db_connection);
?>