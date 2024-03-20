<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hotel Details</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <header>
      <h1>Hotel Name</h1>
      <nav>
        <a href="#">Home</a>
        <a href="#">Rooms</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
      </nav>
    </header>
    <main>
      <section class="room-details">
        <h2>Room Type</h2>
        <div class="room-images">
          <img src="https://via.placeholder.com/500x300.png?text=Room+Image+1" alt="Room Image 1">
          <img src="https://via.placeholder.com/500x300.png?text=Room+Image+2" alt="Room Image 2">
          <img src="https://via.placeholder.com/500x300.png?text=Room+Image+3" alt="Room Image 3">
        </div>
        <p class="hotel-description">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vitae nulla id justo feugiat rhoncus. Aenean pharetra tincidunt mi in posuere. Nam mollis, lacus quis gravida bibendum, elit odio ultrices elit, at faucibus velit nisi non lectus.
        </p>
        <div class="address">
          <h3>Address</h3>
          <p>123 Main Street</p>
          <p>City, State Zip</p>
          <p>Country</p>
        </div>
        <div class="amenities">
          <h3>Amenities</h3>
          <div class="amenity">
            <img class="amenity-icon" src="https://via.placeholder.com/50x50.png" alt="Amenity Icon">
            <div class="amenity-label">Free Wifi</div>
          </div>
          <div class="amenity">
            <img class="amenity-icon" src="https://via.placeholder.com/50x50.png" alt="Amenity Icon">
            <div class="amenity-label">Swimming Pool</div>
          </div>
          <div class="amenity">
            <img class="amenity-icon" src="https://via.placeholder.com/50x50.png" alt="Amenity Icon">
            <div class="amenity-label">Fitness Center</div>
          </div>
          <div class="amenity">
            <img class="amenity-icon" src="https://via.placeholder.com/50x50.png" alt="Amenity Icon">
            <div class="amenity-label">24-Hour Front Desk</div>
          </div>
        </div>
        <div class="price">
          <h3>Price</h3>
          <div class="price-label">Price per night:</div>
          <div class="price-amount">$150</div>
          <button>Book Now</button>
        </div>
      </section>
    </main>
  </body>
</html>

<style>
    /* Global styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
}

/* Header styles */
header {
  background-color: #333;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
}

h1 {
  font-size: 28px;
}

nav a {
  color: #fff;
  text-decoration: none;
  margin-left: 10px;
}

/* Main content styles */
main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.room-details {
  display: flex;
  flex-wrap: wrap;
}

.room-details h2 {
  font-size: 24px;
  margin-bottom: 20px;
  width: 100%;
}

.room-images {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.room-images img {
  max-width: 32%;
}

.hotel-description {
  margin-bottom: 20px;
}

.address {
  width: 50%;
}

.address h3 {
  font-size: 20px;
  margin-bottom: 10px;
}

.address p {
  margin-bottom: 5px;
}

.amenities {
  width: 50%;
}

.amenities h3 {
  font-size: 20px;
  margin-bottom: 10px;
}

.amenity {
  display: flex;
  margin-bottom: 5px;
}

.amenity-icon {
  width: 50px;
  height: 50px;
  margin-right: 10px;
}

.price {
  margin-top: 20px;
}

.price h3 {
  font-size: 20px;
  margin-bottom: 10px;
}

.price-label {
  font-size: 18px;
  margin-right: 10px;
}

.price-amount {
  font-size: 28px;
  font-weight: bold;
  margin-right: 10px;
}

button {
  background-color: #333;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
}

button:hover {
  background-color: #555;
}



    </style>
