<?php

session_start();
require_once ("config.php");


// Redirect to login page if user is not logged in
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Process form data if it has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize user input
    $firstName = mysqli_real_escape_string($db_connection, $_POST['firstname']);
    $lastName = mysqli_real_escape_string($db_connection, $_POST['lastname']);
    $phone = mysqli_real_escape_string($db_connection, $_POST['phone']);

        // Check for empty input
        if(empty($firstName) || empty($lastName) || empty($phone)){
            $_SESSION['status'] = "Please fill in all fields";
            header("Location: profile.php");
            exit();
        }

        $stmt = $db_connection->prepare("UPDATE users SET FirstName=?, LastName=?, PhoneNumber=? WHERE username=?");
        $stmt->bind_param("ssss", $firstName, $lastName, $phone, $username);

    // Execute query
    if ($stmt->execute()) {
         // Redirect the user to the login page
         header("Location: profile.php");
         $_SESSION['status'] = "Sucessfully Saved";
         exit;
    } else {
        echo "Error updating user data: ";
    }

    // Close database connection
    $db_connection->close();
}

?>