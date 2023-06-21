<?php
//start session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//connect to the database
include("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

//check user inputs
    //define error messages
$missingUsername = '<p>Please enter a username!</p>';
$missingEmail = '<p>Please enter your email address!</p>';
$invalidEmail = '<p>Please enter a valid email address!</p>';
$invalidPassword = '<p>Please enter a valid password! A valid password contains at least 6 characters, numbers, letters and at least one capital letter!</p>';
$missingPassword = '<p>Please enter a password</p>';
$missingPassword2 = '<p>Please confirm your password!</p>';
$differentPassword = '<p>Two passwords are not the same!</p>';

//get username, email, password, password2
    // Get username
$username = '';
$email = '';
$password = '';

 //store errors in error variable    
$errors = '';
if (empty($_POST['username'])) {
    $errors .= $missingUsername;
} else {
    $username = htmlspecialchars($_POST['username']);
}

// Get email
if (empty($_POST['email'])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

//get the password
if(empty($_POST['password'])){
    $errors .= $missingPassword;
}elseif(!(strlen($_POST['password'])>6 && preg_match('/[A-Z]/', $_POST['password']) && preg_match('/[0-9]/', $_POST['password']))){
    $errors .= $invalidPassword;
}else{
    $password1 = $_POST['password'];
    if(empty($_POST['password2'])){
        $errors .= $missingPassword2;
    }else{
        $password2 = $_POST['password2'];
       if($password2 !== $password1){
            $errors .= $differentPassword;
        }else{
            $password = password_hash($password1, PASSWORD_DEFAULT);
        }
    }   
}
   
//if there are any errors print them
if($errors !== ''){
    $resultMessage = '<div class="alert alert-danger"><strong>'. $errors .'</strong></div>';
    echo $resultMessage;
}else{//no errors

    //prepare variables for the queries
    $username = mysqli_real_escape_string($link , $username);
    $email = mysqli_real_escape_string($link , $email);
    $password = mysqli_real_escape_string($link , $password);
    
    //if username exist in the users table print error
    $sql = "SELECT * FROM ousers WHERE username = '$username' ";
    $result = mysqli_query($link, $sql);
    if($result === false){// this condition does not work if there are any issues with the $sql
        //$errorMessage = mysqli_errno($link);
        echo '<div class="alert alert-danger">ERROR running the query!</div>';
        // echo '<div class="alert alert-danger">'. $errorMessage  .'!</div>';
        exit();
    }
    
    $results = mysqli_num_rows($result);
    if($results){
        echo '<div class="alert alert-danger">This username is already taken!</div>';
    }else{
            //if email exist in the users table print error
        $sql = "SELECT * FROM ousers WHERE email = '$email' ";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">ERROR running the query!</div>';
            exit();
        }
        
        $results = mysqli_num_rows($result);
        if($results>0){
            echo '<div class="alert alert-danger">This email is already registered!</div>';
        }else{
            // create a uniqe activation code
            $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
        
            //insert user details and activation code in users table
            $sql = "INSERT INTO ousers ( username , email , password , activation) VALUES (? , ? , ? , ?)";
            $stmt = mysqli_prepare($link , $sql);
            if(!$stmt){
                die("Prepare failed: " . mysqli_error($link));
            }
            mysqli_stmt_bind_param($stmt , 'ssss',$username, $email,  $password, $activationKey);
            mysqli_stmt_execute($stmt);
            if(!$result){
                echo '<div class="alert alert-danger">ERROR inserting user details to the database!</div>';
                exit();
            }

                
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                $message = "Please click on this link to activate your account:<br><br>";
                $message .= "http://thisisnot46468835real.freehost.io/online%20note/activate.php?email=" . urlencode($email) . "&key=$activationKey";

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'yaswizard2@gmail.com';                     //SMTP username
                    $mail->Password   = '368400200402';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('yaswizard2@gmail.com', 'Online Notes');
                    $mail->addAddress($email);     //Add a recipient   //Name is optional
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Account Activation';
                    $mail->Body    = $message;
                
                    $mail->send();
                    echo "<div class='alert alert-success'>Thank you for your registration! To activate your account, please click on the link we just sent to $email</div>";
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Sending activation email failed!<br> Mailer Error: {$mail->ErrorInfo}
                    <a href='#' class='btn btn-primary'>Contact us</a>
                    </div>";
                }



                // $to = $email;
                // $subject = 'Confirm your registration';
                // $headers = 'From: frareal@thisisnot46468835real.freehost.io' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                // $message = "Please click on this link to activate your account:<br><br>";
                // $message .= "http://thisisnot46468835real.freehost.io/online%20note/activate.php?email=" . urlencode($email) . "&key=$activationKey";

                // if (mail($to, $subject, $message, $headers)) {
                //     echo "<div class='alert alert-success'>Thank you for your registration! To activate your account, please click on the link we just sent to $email</div>";
                //     exit();
                // } else {
                //     echo "<div class='alert alert-danger'>Sending activation email failed!</div>";
                // }
                   
            
        }
    } 
}


?>




<?php
/*
//start session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//connect to the database
include("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

//check user inputs
    //define error messages
$missingUsername = '<p>Please enter a username!</p>';
$missingEmail = '<p>Please enter your email address!</p>';
$invalidEmail = '<p>Please enter a valid email address!</p>';
$invalidPassword = '<p>Please enter a valid password! A valid password contains at least 6 characters, numbers, letters and at least one capital letter!</p>';
$missingPassword = '<p>Please enter a password</p>';
$missingPassword2 = '<p>Please confirm your password!</p>';
$differentPassword = '<p>Two passwords are not the same!</p>';

//get username, email, password, password2
    // Get username
$username = '';
$email = '';
$password = '';

 //store errors in error variable    
$errors = '';
if (empty($_POST['username'])) {
    $errors .= $missingUsername;
} else {
    $username = htmlspecialchars($_POST['username']);
}

// Get email
if (empty($_POST['email'])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

//get the password
if(empty($_POST['password'])){
    $errors .= $missingPassword;
}elseif(!(strlen($_POST['password'])>6 && preg_match('/[A-Z]/', $_POST['password']) && preg_match('/[0-9]/', $_POST['password']))){
    $errors .= $invalidPassword;
}else{
    $password1 = $_POST['password'];
    if(empty($_POST['password2'])){
        $errors .= $missingPassword2;
    }else{
        $password2 = $_POST['password2'];
       if($password2 !== $password1){
            $errors .= $differentPassword;
        }else{
            $password = password_hash($password1, PASSWORD_DEFAULT);
        }
    }   
}
   
//if there are any errors print them
if($errors !== ''){
    $resultMessage = '<div class="alert alert-danger"><strong>'. $errors .'</strong></div>';
    echo $resultMessage;
}else{//no errors

    //prepare variables for the queries
    $username = mysqli_real_escape_string($link , $username);
    $email = mysqli_real_escape_string($link , $email);
    $password = mysqli_real_escape_string($link , $password);
    
    //if username exist in the users table print error
    $sql = "SELECT * FROM ousers WHERE username = '$username' ";
    $result = mysqli_query($link, $sql);
    if($result === false){// this condition does not work if there are any issues with the $sql
        //$errorMessage = mysqli_errno($link);
        echo '<div class="alert alert-danger">ERROR running the query!</div>';
        // echo '<div class="alert alert-danger">'. $errorMessage  .'!</div>';
        exit();
    }
    
    $results = mysqli_num_rows($result);
    if($results){
        echo '<div class="alert alert-danger">This username is already taken!</div>';
    }else{
            //if email exist in the users table print error
        $sql = "SELECT * FROM ousers WHERE email = '$email' ";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">ERROR running the query!</div>';
            exit();
        }
        
        $results = mysqli_num_rows($result);
        if($results>0){
            echo '<div class="alert alert-danger">This email is already registered!</div>';
        }else{
            // create a uniqe activation code
            $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
        
            //insert user details and activation code in users table
            $sql = "INSERT INTO ousers ( username , email , password , activation) VALUES (? , ? , ? , ?)";
            $stmt = mysqli_prepare($link , $sql);
            if(!$stmt){
                die("Prepare failed: " . mysqli_error($link));
            }
            mysqli_stmt_bind_param($stmt , 'ssss',$username, $email,  $password, $activationKey);
            mysqli_stmt_execute($stmt);
            if(!$result){
                echo '<div class="alert alert-danger">ERROR inserting user details to the database!</div>';
                exit();
            }

                
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                $message = "Please click on this link to activate your account:<br><br>";
                $message .= "http://thisisnot46468835real.freehost.io/online%20note/activate.php?email=" . urlencode($email) . "&key=$activationKey";

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'mail.myfoliowebsite.iapp.ir';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = '_mainaccount@myfoliowebsite.iapp.ir';                     //SMTP username
                    $mail->Password   = '368400200402@Aa';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('yaswizard2@gmail.com', 'Online Notes');
                    $mail->addAddress($email);     //Add a recipient   //Name is optional
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Account Activation';
                    $mail->Body    = $message;
                
                    $mail->send();
                    echo "<div class='alert alert-success'>Thank you for your registration! To activate your account, please click on the link we just sent to $email</div>";
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Sending activation email failed!<br> Mailer Error: {$mail->ErrorInfo}</div>";
                }



                // $to = $email;
                // $subject = 'Confirm your registration';
                // $headers = 'From: frareal@thisisnot46468835real.freehost.io' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                // $message = "Please click on this link to activate your account:<br><br>";
                // $message .= "http://thisisnot46468835real.freehost.io/online%20note/activate.php?email=" . urlencode($email) . "&key=$activationKey";

                // if (mail($to, $subject, $message, $headers)) {
                //     echo "<div class='alert alert-success'>Thank you for your registration! To activate your account, please click on the link we just sent to $email</div>";
                //     exit();
                // } else {
                //     echo "<div class='alert alert-danger'>Sending activation email failed!</div>";
                // }
                   
            
        }
    } 
}


<?php
$link = mysqli_connect("localhost", "myfoliow_php_project", "368400200402@Aa", "myfoliow_php_project");
if(!$link){
    die("ERROR: Unable to connect: " . mysqli_connect_error());
}
?>
*/

?>

