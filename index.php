<?php
session_start();

//logout
if(isset($_GET['logout'])){
    include('logout.php');
}


//remember me
include('remember.php');

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="styling.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&display=swap" rel="stylesheet">
</head>
  <body>


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

<!-- jumbotron -->
    <div class="container jumbotron">
        <h1 class="fw-b"><b>Online Notes App!</b></h1>
        <p class="mt-4">Your Notes with you wherever you go.</p>
        <p>Easy to use, protects all your notes!</p>
        <button type="button" class="btn yellow mt-4 btn-lg" data-bs-toggle="modal" data-bs-target="#signupmodal">Sign up for free!</button>
    </div>


    <!-- modal for sign up -->
    <div class="modal" tabindex="-1" id="signupmodal">
      
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="signupForm">
                    <div class="modal-body">
                        <div id="signupmessage">

                        </div>
                    
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username" id="username" autocomplete="TRUE" placeholder="Username" required maxlength="30">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="email"  name="email" class="form-control" id="signupemail" autocomplete="TRUE" placeholder="name@example.com" reuired maxlength="50">
                            <label for="signupemail">Email address</label>
                        </div>
                        <div class="form-floating input-group mb-2">
                            <input type="password" name="password" class="form-control" id="signupPassword" placeholder="Password" required maxlength="30">
                            <button style="border: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px; width:40px" type="button" id="togglePassword1">
                                <ion-icon name="eye-outline" id="icon1" style="height: 40px;"></ion-icon>
                            </button>
                            <label for="signupPassword">Password</label>
                        </div>
                        <div class="form-floating input-group mb-2">
                            <input type="password" name="password2" class="form-control" id="confirmPassword" placeholder="Confirm Password" required maxlength="30">
                            <button style="border: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px; width:40px" type="button" id="togglePassword2">
                                <ion-icon id="icon2" name="eye-outline" style="height: 40px;"></ion-icon>
                            </button>
                            <label for="confirmPassword">Confirm Password</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn yellow">Sign up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- modal for log in -->
    <div class="modal" tabindex="-1" id="loginmodal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign in</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="loginForm">
                <div class="modal-body">
                    <div id="loginmessage">

                    </div>
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="email" name="loginEmail" autocomplete="TRUE" placeholder="name@example.com" required maxlength="50">
                        <label for="email">Email address</label>
                    </div>
                    <div class="input-group form-floating mb-2">
                        <input type="password" class="form-control" id="Password" name="loginPassword" placeholder="Password" required maxlength="30" aria-describedby="togglePassword">
                        <button style="border: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px; width:40px" type="button" id="togglePassword">
                        <ion-icon name="eye-outline" id="icon" style="height: 40px;"></ion-icon>
                        </button>
                        <label for="Password">Password</label>
                    </div>
                    <div class="row">
                        <div class="checkbox col ">
                            <label>
                                <input type="checkbox" name="rememberme" id="rememberme">
                                Remember me
                            </label>
                        </div>
                        <div class="col text-end">
                            <a href="#"  data-bs-target="#forgotpasswordModal" data-bs-toggle="modal">Forgot Password?</a>
                        </div>
                </div>
                    </div>
                <div class="modal-footer position-relative">
                    <button type="button" class="btn btn-outline-secondary position-absolute top-40 start-0" data-bs-toggle="modal" data-bs-target="#signupmodal">Register</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn yellow">Sign in</button>
                </div>
            </form>
            
            </div>
        </div>
    </div>


    <!-- modal for forgot password -->
    <div class="modal" tabindex="-1" id="forgotpasswordModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="forgotPasswordForm">
                    <div class="modal-body">
                        <div id="forgotpasswordmessage">

                        </div>
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" name="forgotPasswordEmail" id="forgotPasswordEmail" autocomplete="TRUE" placeholder="name@example.com" required maxlength="50">
                            <label for="forgotPasswordEmail">Email address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn yellow">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- footer -->
    <footer>
        <div class="container-fluid">
        <div class="row">
            <div class="col col-3">
            <p class="">Developed by Atefe &copy; <?php echo date("Y"); ?></p>
            </div>
            <div class="col col-7">
            <a href="#" style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-linkedin"></ion-icon></a>
            <a href="#"style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#" style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-whatsapp"></ion-icon></a>
            </div>
        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src=" index.js "></script>    

   

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
        showPassword('#togglePassword1' , '#signupPassword', '#icon1');
        showPassword('#togglePassword2' , '#confirmPassword', '#icon2');
    });
    </script>
</body>
</html>






