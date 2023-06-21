<?php
//start session
session_start();

//connect to the database
include('connection.php');
//check user inputs
    //define error messages
    $missingEmail = '<p>Please enter your email address!</p>';
    $invalidEmail = '<p>Please enter a valid email address!</p>';
    
    //store errors in error variable
    $errors = '';

    //get email
    $email = '';
    if (empty($_POST['forgotPasswordEmail'])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST['forgotPasswordEmail'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST['forgotPasswordEmail'], FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        }
    }

    if($errors !== ''){
        $resultMessage = '<div class="alert alert-danger"><strong>'. $errors .'</strong></div>';
        echo $resultMessage;

    }else{//no errors
        //prepare variables for the queries
        $email = mysqli_real_escape_string($link , $email);

        //run the query to check if the eamil exists in the users table
        $sql = "SELECT * FROM ousers WHERE `email` = '$email'";
        $result = mysqli_query($link , $sql);

        if($result === false){  
            
            echo '<div class="alert alert-danger">ERROR running the query!</div>';
            exit();
            
        }
        
        $count = mysqli_num_rows($result);
    
        if($count != 1){ //if the email does not exist
            //print error message
            echo '<div class="alert alert-danger">Email does not exist!</div>';
        }else{   // get the user id
           
            $row = mysqli_fetch_array($result , MYSQLI_ASSOC);
            $user_id = $row['user_id'];

            //create a uniqe activation code
            $key = bin2hex(openssl_random_pseudo_bytes(16));
            $time = time();
            $status = 'pending';

            //insert user details and activation code in the forgotpassword table
            $sql = "INSERT INTO `forgotpassword`( `user_id`, `key`, `time`, `status`) VALUES ('$user_id','$key','$time','status')";
            $result = mysqli_query($link , $sql);

            if(!$result){
                echo '<div class="alert alert-danger">ERROR inserting user details to the database!</div>';
                exit();
            }
           
            //send email with link to resetpassword.php with user id and activation code
    
            $to = $email;
            $subject = 'Reset Password';
            $headers = 'From: frareal@thisisnot46468835real.freehost.io' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

            $message = "Please click on this link to reset your password:<br><br>";
            $message .= "http://thisisnot46468835real.freehost.io/online%20note/resetpassword.php?user_id=$user_id &key=$key";

            if (mail($to, $subject, $message, $headers)) {
                //print success message
                echo "<div class='alert alert-success'>Please click on the link we just sent to $email to reset your password.</div>";
                exit();
            } else {
                echo "<div class='alert alert-danger'>Sending activation email failed!</div>";
            } 
        }
    }    
?>