<?php

$search_type = $_GET['id'];

if ($search_type == 1){
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = '';
  
  // Check if required fields are filled in
 if ($_POST['flight-type']=='Single'){
    if (empty($_POST['flight-type']) || empty($_POST['Origin']) || empty($_POST['Destination']) || empty($_POST['Departure']) || empty($_POST['class-type']))  {
        $errors = 'Please fill in all the fields';
      }
      else{
      session_start(); // start the session
      $_SESSION['Origin'] = $_POST['Origin']; // store Origin in session
      $_SESSION['Destination'] = $_POST['Destination']; // store Destination in session
      $_SESSION['Departure'] = $_POST['Departure']; // store Departure in session
      $_SESSION['class-type'] = $_POST['class-type']; // store Departure in session
      $_SESSION['flight-type'] = $_POST['flight-type'];
    
      header('Location: display2.php');
      exit;
    }
 }
 else{
    if (empty($_POST['Arrival']) ||empty($_POST['Origin']) || empty($_POST['Destination']) || empty($_POST['Departure']) || empty($_POST['class-type']))  {
        $errors = 'Please fill in all the fields';
      }
      else{
      session_start(); // start the session
      $_SESSION['Origin'] = $_POST['Origin']; // store Origin in session
      $_SESSION['Destination'] = $_POST['Destination']; // store Destination in session
      $_SESSION['Departure'] = $_POST['Departure']; // store Departure in session
      $_SESSION['Arrival'] = $_POST['Arrival']; // store the arrival in session
      $_SESSION['class-type'] = $_POST['class-type']; // store Departure in session
      $_SESSION['flight-type'] = $_POST['flight-type'];
    
      header('Location: display2.php');
      exit;
    }
 }
}
}

if ($search_type == '2'){
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = '';
    
    // Check if required fields are filled in
    if (empty($_POST['search_city']) || empty($_POST['check_in']) || empty($_POST['check_out']) || empty($_POST['hotel_adults']))  {
        $errors = 'Please fill in all the fields';
    }
    else{
    session_start(); // start the session
    $_SESSION['search_city'] = $_POST['search_city']; // store Origin in session
    $_SESSION['check_in'] = $_POST['check_in']; // store Destination in session
    $_SESSION['check_out'] = $_POST['check_out']; // store Departure in session
    $_SESSION['hotel_adults'] = $_POST['hotel_adults']; // store Departure in session

    header('Location: hotel_search.php');
    exit;
    }
    }

    

}


?>