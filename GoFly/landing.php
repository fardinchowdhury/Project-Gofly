<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plaster&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="landingstyle.css">
    <title>Gofly</title>
</head>
<body>






    <div id="slide-form2" class="crossfade">
        <figure></figure>
        <figure></figure>
        <figure></figure>
        <figure></figure>
        <figure></figure>
        <?php 
    // Check the session status
    $status = session_status();

    if ($status === PHP_SESSION_ACTIVE) {
        // Session is active
        include_once 'navbar.php';
    } else {
        session_start();
        // Session is not active
        include_once 'navbar.php';

    }
        
    ?>

        <div class="wel"> 
        <?php

        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            echo "<h1>Welcome, $username!</h1>";
        }
        
        ?>
    </div>


        <!-- .................Search Bar................................. -->
        <div id="search-form">
        <h1 class ='header'>
        <button class="c-button c-button--gooey" onclick="showFlightSearchBar()"> Flights
            <div class="c-button__blobs">
            <div></div>
            <div></div>
            <div></div>
            </div>
            </button>
        <button class="c-button c-button--gooey" onclick="showHotelSearchBar()"> Hotels
            <div class="c-button__blobs">
            <div></div>
            <div></div>
            <div></div>
            </div>
            </button>
            
        </h1>
            <section id = 'flight-search-bar'>
                <div class="flight" id="flightbox">
                <?php if (!empty($errors)): ?>
                <p class="error" style="color: red;"><?php echo $errors; ?></p>
                <?php endif; ?>

                    <form id="flight-form" method="post" action="search_type.php?id=1">
                        <!-- TRIP TYPE -->
                        <div class="container-10">
                            <div class="tabs">
                            <input type="radio" name="flight-type" value="Return" id="return" checked="checked" onchange="showArrival()"/>
                                <label class="tab" for="return"> RETURN</label>
                                <input type="radio" name="flight-type" value="Single" id="one-way" onchange="hideArrival()"/>
                                <label class="tab" for="one-way">ONE WAY</label>
                                
                                <span class="glider"></span>
                            </div>
                        </div>

                        <!-- FROM/TO -->
                        <div id="flight-depart">
                            <div class="info-box">
                                <label for="Origin">Origin</label>
                                <select name="Origin" Placeholder="Select" >
                                    <option value="JFK">JFK</option>
                                    <option value="DAC">DAC</option>
                                    <option value="SAF">SAF</option>
                                    <option value="BOS">BOS</option>
                                </select>
                            </div>
                            <div class="info-box">
                                <label for="Destination">Destination</label>
                                <select name="Destination" Placeholder="Select" >
                                    <option value="JFK">JFK</option>
                                    <option value="DAC">DAC</option>
                                    <option value="SAF">SAF</option>
                                    <option value="BOS">BOS</option>
                                    <option value="BUF">BUF</option>
                                </select>
                            </div>
                        </div>
                        

                        <!-- FROM/TO -->
                        <div id="flight-dates">
                            <div class="info-box">
                                <label for="">Departure</label>
                                <input class="date-box" type="date" name="Departure" class="form-control" min="<?php echo date('Y-m-d'); ?>" aria-describedby="return-date-label"/>
                            </div>
                            <div class="info-box" id="return-box" style="display: block;">
                                <label for="">Arrival</label>
                                <input class="date-box" type="date" name="Arrival" min="<?php echo date('Y-m-d'); ?>" aria-describedby="return-date-label"/>
                            </div>
                        </div>

                        <!-- PASSENGER INFO -->
                        <div id="flight-info">
                            <div class="info-box">
                                <label for="adults">Adults</label>
                                <select name="adults">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="info-box">
                                <label for="class-type">Class</label>
                                <select name="class-type">
                                    <option value="Economy">Economy</option>
                                    <option value="Business">Business</option>
                                    <option value="First">First Class</option>
                                </select>
                            </div>
                        </div>

                        <!-- SEARCH BUTTON -->
                        <div id="flight-search">
                            <div class="info-box">
                                <input type="submit" id="search-flight" name="search-flight" value="Search"/>
                                <p class="failed"> 
                                    <?php 
                                        if(isset($_SESSION['status'])){ 
                                            echo $_SESSION['status']; 
                                            unset($_SESSION['status']); 
                                        } 
                                    ?> </p>
                    
                            </div>
                        </div>
                    </form>

                </div>
            </section>

            <section id = "hotel-search-bar">
       
        <div class="flight" id="flightbox">
        <?php if (!empty($errors)): ?>
          <p class="error" style="color: red;"><?php echo $errors; ?></p>
        <?php endif; ?>

            <form id="hotel-form" method="post" action="search_type.php?id=2">
    
                <div id="hotel-depart">
                    <div class="info-box">
                        <label for="location">Location</label>
                        <select id="city" name="search_city" required>
                        <option value="">Select a city</option>
                        <?php
                        $us_cities = array("New York City", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville", "Fort Worth", "Columbus", "San Francisco");
                        foreach ($us_cities as $city) {
                            echo "<option value='$city'>$city</option>";
                        }
                        ?>
                        </select>
                    </div>

                </div>

                <!-- FROM/TO -->
                <div id="flight-dates">
                    <div class="info-box">
                        <label for="">Check-In</label>
                        <input
                            class="date-box"
                            type="date"
                            name="check_in"
                            class="form-control"
                            min="<?php echo date('Y-m-d'); ?>"
                            aria-describedby="return-date-label"/>
                    </div>
                    <div class="info-box">
                        <label for="">Check-Out</label>
                        <input
                            class="date-box"
                            type="date"
                            name="check_out"
                            class="form-control"
                            min="<?php echo date('Y-m-d'); ?>"
                            aria-describedby="return-date-label"/>
                    </div>
                </div>

                <!-- PASSENGER INFO -->
                <div id="flight-info">
                    <div class="info-box">
                        <label for="adults">Adults</label>
                        <select name="hotel_adults">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                  
                </div>

                <!-- SEARCH BUTTON -->
                <div id="flight-search">
                    <div class="info-box">
                        <input type="submit" id="search-hotel" name="search-hotel" value="Search"/>
                        <p class="failed"> 
                            <?php 
                                if(isset($_SESSION['status'])){ 
                                    echo $_SESSION['status']; 
                                    unset($_SESSION['status']); 
                                } 
                            ?> </p>
            
                    </div>
                </div>
            </form>

        </div>
    </section>
        </div>
    </div>

    <script>
     window.onload = function() {
        showFlightSearchBar();
}
    function showFlightSearchBar() {
        var flightSearchBar = document.getElementById("flight-search-bar");
        var hotelSearchBar = document.getElementById("hotel-search-bar");
        flightSearchBar.style.display = "block";
        hotelSearchBar.style.display = "none";
    }
    
    function showHotelSearchBar() {
        var flightSearchBar = document.getElementById("flight-search-bar");
        var hotelSearchBar = document.getElementById("hotel-search-bar");
        flightSearchBar.style.display = "none";
        hotelSearchBar.style.display = "block";
    }
</script>





<!-- ticket display -->
<div class="second-part">
<h1>
  Discover the World 
</h1>

<section class="cards">
<article class="card card--1">


  <div class="card__img"></div>
  <a href="#" class="card_link">
     <div class="card__img--hover"></div>
   </a>
  <div class="card__info">
    <span class="card__category"> Travel</span>
    <h3 class="card__title">Discover the sea</h3>
    <span class="card__by">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, beatae sint maiores dolore, cumque quidem nihil nostrum est impedit iste architecto, laborum aperiam. Odit eum praesentium aliquid quibusdam facilis maxime.</span>
  </div>
</article>
  
  
<article class="card card--2">

    

  <div class="card__img"></div>
  <a href="#" class="card_link">
     <div class="card__img--hover"></div>
   </a>
  <div class="card__info">
    <span class="card__category"> Travel</span>
    <h3 class="card__title">Discover the sea</h3>
    <span class="card__by">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, iste tenetur? Nam, corporis exercitationem nemo nesciunt earum tenetur fugit dolorem debitis dolor inventore consequatur dolore id esse suscipit temporibus minus.</span>
  </div>
</article>  
<article class="card card--3">
  <div class="card__img"></div>
  <a href="#" class="card_link">
     <div class="card__img--hover"></div>
   </a>
  <div class="card__info">
    <span class="card__category"> Travel</span>
    <h3 class="card__title">Discover the sea</h3>
    <span class="card__by">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, iste tenetur? Nam, corporis exercitationem nemo nesciunt earum tenetur fugit dolorem debitis dolor inventore consequatur dolore id esse suscipit temporibus minus.</span>
  </div>
</article>  
</section>

</div>


<!-- Contact us form -->
<div class="ctct">
    <div id="contact" class="contact">
        <div class="side">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d95613.31811545139!2d-90.58590019925656!3d41.50609095432337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87e231fb045e40b1%3A0x9fae16c1ba99fdc9!2sGofly%20Biz!5e0!3m2!1sen!2sus!4v1682902817928!5m2!1sen!2sus"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
           </div>
           <form action="https://formspree.io/f/mlekpwqw" method="post" class="form color-g">
               <h2>Contact Us</h2>
               
               <input class="box" type="text" name="name" pattern="[a-zA-Z]+" title="Please enter only alphabetical letters." placeholder="Enter Your Name" required>
               <input class="box" type="email" name="email" placeholder="Enter Your Email Address" required>
               <textarea class="box" name="message" rows="4" cols="50" placeholder="Enter text here..."></textarea>
               <input type="submit" value="Submit" id="submit">
           </form>

       </div>
   
    </div>














<!-- foooter -->


  <footer class="site-footer">
      <div class="container">
          <div class="row">
          <div class="logo">
            <h6 style="text-align:center; margin-bottom:20px;"><a href="landing.php">Gofly</a></h6>
          </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    
                      <ul class="social-icons">

                          <li>
                              <a class="facebook" href="#">
                                  <i class="fa fa-facebook"></i>
                              </a>
                          </li>
                          <li>
                              <a class="twitter" href="#">
                                  <i class="fa fa-twitter"></i>
                              </a>
                          </li>
                          <li>
                              <a class="dribbble" href="#">
                                  <i class="fa fa-dribbble"></i>
                              </a>
                          </li>
                          <li>
                              <a class="linkedin" href="#">
                                  <i class="fa fa-linkedin"></i>
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </footer>

    <script src="https://kit.fontawesome.com/fe66f9ddbe.js" crossorigin="anonymous"></script>
    <script src="land.js"></script>
    <script>
    function showArrival() {
        document.getElementById("return-box").style.display = "block";
    }
    function hideArrival() {
        document.getElementById("return-box").style.display = "none";
    }
</script>
</body>
</html>