<?php
    require_once("config.php");
    // start the session
    session_start();

    // Get the user ID
    $uid = $_SESSION['username'];

    
    // get the password entered by the user
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if(empty($password)){
        header("Location: delete.php");
        $_SESSION['status'] = "Please Enter Your Password";
        exit();

    }
    
    // Query the database for the user's password
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // check if the query was successful
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
    
        // ! check if the password matches
        if (password_verify($password, $stored_password)) {
            // Delete the user's account and all associated data
            $sql = "DELETE FROM users WHERE username = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("s", $uid);


            if ($stmt->execute() === TRUE) {
                // Logout the user and redirect to the signup page
                session_destroy();
                header("Location: successDeleteProf.html");
                exit;
            }
        } else {
            // Deletion failed because the password was incorrect
            header("Location: delete.php");
            $_SESSION['status'] = "Password is not Correct";
            exit();
        }
    }

 
    // close the database connection
    $stmt->close();
    $db_connection->close();

    ?>