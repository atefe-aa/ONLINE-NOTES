<?php
//start session
session_start();
//connect to the database
include("connection.php");


//check user inputs
    //define error messages
$missingEmail = '<p>Please enter your email address!</p>';
$missingPassword = '<p>Please enter your password</p>';

    //store errors in error variable
    $errors = '';

    // Get email
if (empty($_POST['loginEmail'])) {
    $errors .= $missingEmail;
} else {
    $email = $_POST['loginEmail'];

    $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
}

//get the password
if(empty($_POST['loginPassword'])){
    $errors .= $missingPassword;
}else{
    $password = $_POST['loginPassword'];  

}

    //if there are any errors 
if($errors !== ''){
    //print error
    $resultMessage = '<div class="alert alert-danger"><strong>'. $errors .'</strong></div>';
    echo $resultMessage;

}else{//else: no errors

    //prepare variables for the query
    $email = mysqli_real_escape_string($link , $email);
    $password = mysqli_real_escape_string($link , $password);
    $activation = 'activated';
   //run query : check combination of email and password exist
   $sql = "SELECT * FROM ousers WHERE email = ? AND `activation` = ?";
   $stmt = mysqli_prepare($link , $sql);
   mysqli_stmt_bind_param($stmt, "ss", $email , $activation);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   $rowCount = mysqli_num_rows($result);
   
   if ($result) {

        if($rowCount == 1 ){
            $row = mysqli_fetch_assoc($result);

                $hashPassword = $row['password'];
                if(password_verify($password , $hashPassword)){
                    
                    //log the user in and set the session variables
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];

                    if(empty($_POST['rememberme'])){   //if remmember me is not checked
                    // print "success"
                        echo 'success';
                    }else{
                        
                        //create two variables : $authentificator1 and $authentificator2 
                        $authentificator1 =  bin2hex(openssl_random_pseudo_bytes(10));
                        $authentificator2 =  openssl_random_pseudo_bytes(20);
                        
                        //store them in a cookie
                        function f1($a , $b){ //should not be too easy to guess
                            $c = $a . "," . bin2hex($b);
                            return $c;
                        };
                        setcookie(
                            "rememberme",
                            $cookievalue = f1($authentificator1 , $authentificator2),
                            time() + (15*24*60*60), //expires in 15 days
                        );

                    //run query to store them in remember table
                        function f2 ($a){
                            $b = hash('sha256' , $a);
                            return $b;
                        };

                        $f2authentificator2 = f2($authentificator2);
                        $user_id = $_SESSION['user_id'];
                        $expires = date("Y-m-d H:i:s", time() + (15*24*60*60));

                        $sql2 = "INSERT INTO rememberme ( authentificator1, f2authentificator2, user_id , expires) VALUES ('$authentificator1' , '$f2authentificator2' , '$user_id' , '$expires')";
                        $result2 = mysqli_query($link , $sql2);

                        if(!$result2){//print error
                            $resultMessage = '<div class="alert alert-danger"><strong>Remember me query failed!</strong></div>';
                            echo $resultMessage;
                        }else{//if query successful
                    
                        //print success
                            echo "success";
                        }
                        
                    }



                }else{        //if email and password don't match print error
                        $resultMessage = '<div class="alert alert-danger"><strong>The password is not correct!</strong></div>';
                        echo $resultMessage; 
                }
        }else{
            $resultMessage = '<div class="alert alert-danger"><strong>This email address is not registered!</strong></div>';
            echo $resultMessage; 
        }
      
       
    //    mysqli_free_result($result); // Free the result set
   }else{
        $resultMessage = '<div class="alert alert-danger"><strong>Error: running the query!</strong></div>';
        echo $resultMessage;   
   }
    
//    mysqli_stmt_close($stmt); // Close the statement
//    mysqli_close($link); // Close the database connection

}


?>
