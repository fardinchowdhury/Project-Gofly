<?php
require_once("config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $db_connection->prepare("INSERT INTO reviews (full_name, rating, comment, username) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $full_name, $rating, $comment, $_SESSION['username']);

    if ($stmt->execute()) {
        header("Location: reviews.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db_connection->close();
}
?>
