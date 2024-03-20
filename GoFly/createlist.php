<?php 
require_once("config.php");
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //
    
    // Get the user input and sanitize it:
    $departure_location = mysqli_real_escape_string($db_connection, $_POST['departure_location']);
    $arrival_location = mysqli_real_escape_string($db_connection, $_POST['arrival_location']);
    $departure_date = mysqli_real_escape_string($db_connection, $_POST['departure_date']);
    $arrival_date = mysqli_real_escape_string($db_connection, $_POST['arrival_date']);
    $price = mysqli_real_escape_string($db_connection, $_POST['price']);

    // Use prepared statements
    $sql = "INSERT INTO ticket_listing (departure_location, arrival_location, departure_date, arrival_date, price)
    VALUES ('$departure_location', '$arrival_location', '$departure_date', '$price')";

    if ($db_connection->query($sql) === TRUE) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit;
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db_connection);
    }

    $db_connection->close();
}


?>