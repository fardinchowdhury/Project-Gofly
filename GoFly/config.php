<?php
global $db_connection;

// if ($_SERVER['HTTPS'] !== 'on') {
//     header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//     exit();
// }

//Connect to the databse using mysqli
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "go_fly";

define('SENDGRID_API_KEY', "SG.Go3WsEFDQt-YiWo81L9mcQ.LQRRZ9SztycbtHrQXz2m1SLlaEU1-Gaoz4IU1SW3ozQ");



$db_connection = new mysqli($servername, $username, $password, $dbname);

//Check conncection
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}

?>