<?php
// Connect to SQL database
// Connect to the database (replace with your own database credentials)
$servername = "oceanus.cse.buffalo.edu:3306";
$username = "mamuin";
$password = "50424784";
$dbname = "cse442_2023_spring_team_y_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['token'])) {
    // Get the password and token from the form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    

    // Check if the passwords match
    if ($password != $confirm_password) {
        echo "The passwords do not match.";
        exit;
    }

    // Check if the token is valid
    $sql = "SELECT * FROM users WHERE reset_token='$token'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "Invalid reset token.";
        exit;
    }

    $row = mysqli_fetch_assoc($result);



    // Update the user's password in the database
    $username = $row['username'];
    $sql = "UPDATE users SET password='$password', reset_token=NULL WHERE username='$username'";
;
    mysqli_query($conn, $sql);

    echo "Your password has been reset.";
}
?>
