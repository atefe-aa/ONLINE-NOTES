<?php
//the user is redirected to this file after clicking the activation link
//sign up link contains two GET parameters : email and activation key
session_start();
include("connection.php");

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account activation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="styling.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&display=swap" rel="stylesheet">
</head>
  <body style="background: none;">
<!-- navbar -->
    <nav class="navbar navbar-expand-lg fixed-top " style="background-color: blueviolet;">
    <div class="container-fluid">
        <a class="navbar-brand gray" style="font-size: 24px;" href="#">Online Notes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active gray" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link gray" href="#">Help</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link gray" href="#">Contact</a>
            </li>
        </ul>
        <button type="button" class="btn pink" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
        </div>
    </div>
    </nav>

    <!-- main content -->
    <div class="container-fluid row" >
        <div class="card col-md-4 offset-md-4 col-sm-6 offset-sm-2"  style="margin-top:100px ;background-color:blueviolet;">
            <div class="card-body">

<?php

// if email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">there was an error! Please click on the link sent to your email address.</div>';
    exit;
}
//else
    // store them in two variables
$email = filter_var($_GET['email'] , FILTER_SANITIZE_EMAIL);
$key = $_GET['key'];

    //prepare variables for the query
$email = mysqli_real_escape_string($link , $email);
$key = mysqli_real_escape_string($link , $key);

    //run query : set activation field to "activated" for the provided email
$sql = "UPDATE ousers SET activation='activated' WHERE (email=? AND activation=?) LIMIT 1"; //limit 1 is there to be safe
$stmt = mysqli_prepare($link, $sql);  
if(!$stmt){
    die("Prepare failed: ". mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, "ss", $email, $key); //Bind the variables to the prepared statement so the values will be automatically sanitized and scaped
mysqli_stmt_execute($stmt);

//check for execution errors
if (mysqli_stmt_errno($stmt)) {
    die("Execution failed: " . mysqli_stmt_error($stmt));
} 

$affected_rows = mysqli_stmt_affected_rows($stmt); //get the number of affected rows
mysqli_stmt_close($stmt); //close the statement


//if query is successful, show success message and invite user to login
if($affected_rows == 1){
?>
                <h5 class="card-title">Welcome!</h5>
                <p class="card-text">Your account has been activated successfully! Now you can login and start writing notes.</p>
                <a href="index.php" class="btn btn-primary">Login Now!</a>

<?php
    // echo '<div class="alert alert-success">Your account has been activated!</div>';
    // echo '<a href="index.php" type="button" class="btn btn-success btn-lg">Log in</a>';
}else{
    //show error message
    // echo '<div class="alert alert-danger">your account could not be activated. Please try again later!</div>';
?>

                <h5 class="card-title">Sorry!</h5>
                <p class="card-text">your account could not be activated. Please try again later!</p>
                <a href="#" class="btn btn-primary">Contact us</a>


<?php
}

?>

            </div>
        </div>
    </div>
    
</body>
</html>






