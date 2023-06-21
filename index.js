//ajax call for  the sign up form
//once the form is submited
$("#signupForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
     //send them to signup.php using AJAX 
     $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){//AJAX call successful: show error or success message
            if(data){
                $("#signupmessage").html(data);
            }
        },
        error:function(){//AJAX call fails: show AJAX call error
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later!</div>");
        },

     });
});
    

        
//ajax call for  the login form
//once the form is submited
$("#loginForm").submit(function(event){

    //prevent default php processing
    event.preventDefault();

    //collect user inputs
    var datatopost = $(this).serializeArray();

    //send them to login.php using AJAX 
     $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        success: function(data){//AJAX call successful

            if(data == "success"){  //if php files return "success": redirect the user to the note page
            
                window.location.href = "mainpagelogedin.php";

            }else{  //otherwise show error message
                $("#loginmessage").html(data);
            }
        },
        error:function(){//AJAX call fails: show AJAX call error
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later!</div>");
        },

     });
});



        

//ajax call for  the forgot password form
//once the form is submited
$("#forgotPasswordForm").submit(function(event){

    //prevent default php processing
    event.preventDefault();

    //collect user inputs
    var datatopost = $(this).serializeArray();

    //send them to forgotpassword.php using AJAX 
     $.ajax({
        url: "forgotpassword.php",
        type: "POST",
        data: datatopost,
        success: function(data){//AJAX call successful
             $("#forgotpasswordmessage").html(data);
        },
        error:function(){//AJAX call fails: show AJAX call error
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later!</div>");
        },

     });
});
