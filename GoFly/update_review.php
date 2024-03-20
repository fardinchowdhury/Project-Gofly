<?php
require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_id = $_POST['review_id'];
    $full_name = $_POST['full_name'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $db_connection->prepare("UPDATE reviews SET full_name = ?, rating = ?, comment = ? WHERE id = ?");
    $stmt->bind_param("sisi", $full_name, $rating, $comment, $review_id);

    if ($stmt->execute()) {
        header("Location: reviews_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db_connection->close();
}
?>
