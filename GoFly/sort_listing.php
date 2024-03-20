<?php
require_once("config.php");

// Get the sorting option from the form
$sort_option = $_POST["sort"];

// Build the SQL query based on the sorting option
switch ($sort_option) {
    case "price_high_low":
        $sql = "SELECT * FROM flight_listings ORDER BY price DESC";
        break;
    case "price_low_high":
        $sql = "SELECT * FROM flight_listings ORDER BY price ASC";
        break;
    case "duration":
        $sql = "SELECT *, TIME_TO_SEC(duration) AS duration_seconds FROM flight_listings ORDER BY duration_seconds";
        break;
    case "airline":
        $sql = "SELECT * FROM flight_listings ORDER BY airline";
        break;
    case "destination":
        $sql = "SELECT * FROM flight_listings ORDER BY arrival";
        break;
    default:
        $sql = "SELECT * FROM flight_listings";
}

// Execute the query and fetch the results
$result = mysqli_query($db_connection, $sql);

// Redirect back to displaylist.php with the sorted results
if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION["sorted_listings"] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['selected_sort'] = $sort_option; // Store the selected sort option in the session
    header("Location: displaylist.php");
} else {
    echo "<p>No results found.</p>";
}

mysqli_close($db_connection);
?>
