<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $listing_id = $_GET['id'];
} else {
    header('Location: displaylist.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="stylesheet" href="weather.css">
    <title>Weather</title>
</head>
<body>
    <?php
        include_once 'navbar.php';
    ?>

    <div class="container">
        <form action="" method="get" class="form color-g">
            <input type="hidden" name="id" value="<?= $listing_id; ?>">
            <h2 class="weather-title">Weather Information</h2>
            <input class="weather-box" type="text" name="city" placeholder="Search city...">
            <input type="submit" value="Search" id="weather-submit">
            <div id="weather-container"></div>

            <script>
                const apiKey = "5436f3bc399e7ad36a83b1bbb7f08afa";
                const url = "https://api.openweathermap.org/data/2.5/weather";
                const iconUrl = "https://openweathermap.org/img/wn";
                const city = new URLSearchParams(window.location.search).get("city") || "New York";

                fetch(`${url}?q=${city}&appid=${apiKey}&units=metric`)
                    .then(response => response.json())
                    .then(data => {
                        const weatherContainer = document.getElementById("weather-container");
                        const weatherIcon = data.weather[0].icon;

                        weatherContainer.innerHTML = `
                            <h2>${data.name}, ${data.sys.country}</h2>
                            <img src="${iconUrl}/${weatherIcon}@2x.png" alt="${data.weather[0].description}" />
                            <p>Temperature: ${data.main.temp}°C</p>
                            <p>Feels like: ${data.main.feels_like}°C</p>
                            <p>Weather: ${data.weather[0].description}</p>
                        `;
                    })
                    .catch(error => {
                        console.error("Error fetching weather data:", error);
                    });
            </script>
        </form>
        <div class="side">
            <img src="photos/bgpic1.png" alt="">
        </div>
    </div>
</body>
</html>
