<?php
require_once("config.php");

// Get the sorting option from the form
$sort_option = $_POST["sort"];

// Build the SQL query based on the sorting option
switch ($sort_option) {
    case "price_high_low":
        $sql = "SELECT * FROM hotel_listings ORDER BY hotel_price DESC";
        break;
    case "price_low_high":
        $sql = "SELECT * FROM hotel_listings ORDER BY hotel_price ASC";
        break;
    case "hotel_name":
        $sql = "SELECT * FROM hotel_listings ORDER BY hotel_name";
        break;
    case "hotel_city":
        $sql = "SELECT * FROM hotel_listings ORDER BY hotel_city";
        break;
    default:
        $sql = "SELECT * FROM hotel_listings";
}

// Execute the query and fetch the results
$result = mysqli_query($db_connection, $sql);

// Redirect back to displayhotel1.php with the sorted results
if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION["sorted_listings"] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['selected_sort'] = $sort_option; // Store the selected sort option in the session
    if ($_SESSION['user-type'] == 'user'){
    header("Location: displayhotel1.php");
    }
    else{
        header("Location: admin_hotelDisplay.php");
    }
    
} else {
    echo "<p>No results found.</p>";
}

mysqli_close($db_connection);
?>
