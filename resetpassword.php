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
    <title>Password Reset</title>
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
    <div class="container-fluid row">
        <div class="card col-md-4 offset-md-4 col-sm-6 offset-sm-2"  style="margin-top:100px ;background-color:blueviolet;">
            <div class="card-body">

<?php

// if user id or  key is missing show an error
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">there was an error! Please click on the link sent to your email address.</div>';
    exit;
}
//else
    // store them in two variables
$user_id = htmlspecialchars($_GET['user_id'] );
$key = $_GET['key'];
$time = time() - 86400; //24 hours before corrent time, because the key is only valid for 24 hours 

    //prepare variables for the query
$user_id = mysqli_real_escape_string($link , $user_id);
$key = mysqli_real_escape_string($link , $key);

    //run query : look for the combination of user id and the key and check if the key is still valid
$sql = "SELECT `user_id` FROM forgotpassword WHERE `key` = '$key' AND `user_id`='$user_id' AND `time` > '$time'";

// $sql = "UPDATE forgotpassword SET status='activated' WHERE (user_id=? AND key=?) LIMIT 1"; //limit 1 is there to be safe
$result= mysqli_query($link, $sql);  
$count = mysqli_num_rows($result);

if(!$result){
    die("Prepare failed: ". mysqli_error($link));
}
//if combination does not exist


if($count == 1){
    //let the user reset the password
?>
                <h5 class="card-title">Reset your password</h5>

                <!-- result message(success or error) will be shown in this div -->
                <div id="resetpasswordmessage"></div> 

                <form method="post" id="resetPasswordForm">
                    <!-- print user id and the key in the hidden inputs so u can make sure that the right user's password will be changed -->
                    <input type="hidden" name="key" value="<?php echo $key ?>" >
                    <input type="hidden" name="userid" value="<?php echo $user_id ?>" >
                    <div class="form-floating input-group mb-2">
                        <input type="password" name="password" class="form-control" id="Password" placeholder="Password" required maxlength="30">
                        <button style="border: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px; width:40px" type="button" id="togglePassword">
                            <ion-icon id="icon" name="eye-outline" style="height: 40px;"></ion-icon>
                        </button>
                        <label for="confirmPassword">Confirm Password</label>
                    </div>
                    <div class="form-floating input-group mb-2">
                        <input type="password" name="password2" class="form-control" id="confirmPassword" placeholder="Confirm Password" required maxlength="30">
                        <button style="border: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px; width:40px" type="button" id="togglePassword2">
                            <ion-icon id="icon2" name="eye-outline" style="height: 40px;"></ion-icon>
                        </button>
                        <label for="confirmPassword">Confirm Password</label>
                    </div>
                    <button type="submit" class="btn pink">Reset Password</button>
                </form>

<?php

}else{
    //show error message
?>
                <h5 class="card-title">Sorry!</h5>
                <p class="card-text">There was an error resetting your password. Please try again!</p>
                <a href="#" class="btn btn-primary">Contact us</a>
<?php
}
?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src=" index.js "></script>  
     
    <!-- script for Ajax call to storeresetpassword.php which processes form data -->
    <script>
        $("#resetPasswordForm").submit(function(event){

        //prevent default php processing
        event.preventDefault();

        //collect user inputs
        var datatopost = $(this).serializeArray();

        //send them to forgotpassword.php using AJAX 
        $.ajax({
            url: "storeresetpassword.php",
            type: "POST",
            data: datatopost,
            success: function(data){//AJAX call successful
                $("#resetpasswordmessage").html(data);
            },
            error:function(){//AJAX call fails: show AJAX call error
                $("#resetpasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later!</div>");
            },

        });
        });
    </script>

   

    <script>
    $(document).ready(function() {

        function showPassword(btnid , inputid , iconid){
            $(btnid).click(function() {
                var passwordInput = $(inputid);
                var passwordFieldType = passwordInput.attr('type');

                if (passwordFieldType === 'password') {
                passwordInput.attr('type', 'text');
                $(iconid).attr('name','eye-off-outline');
                } else {
                passwordInput.attr('type', 'password');
                $(iconid).attr('name', 'eye-outline');
                }
            });
        };

        showPassword('#togglePassword' , '#Password' , '#icon');
        showPassword('#togglePassword2' , '#confirmPassword', '#icon2');
    });
    </script>
</body>
</html>
