<?php
include('connection.php');

//if the user is not logged in & remember cookie exists
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    //f1 : COOKIE : $a . "," . bin2hex($b);
    //f2 : hash('sha256' , $a);

    //extract $authentificators 1&2 from the cookie
    list($authentificator1,$authentificator2) = explode(',', $_COOKIE['rememberme']);
    $authentificator2 = hex2bin($authentificator2);
    $f2authentificator2 = hash('sha256' , $authentificator2);

    //look for the authentificator1 in the remember table
    $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo '<div class="alert alert-danger">THere was an error running query! </div>';
        exit;
    
    }

    $count = mysqli_num_rows($result);
    if($count !== 1 ){
        echo '<div class="alert alert-danger">Remember me proccess failed! </div>';
        exit;
    }
    
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    //if authentificator2 does not match
    if(!hash_equals($row['f2authentificator2'], $f2authentificator2)){
        //print error
        echo '<div class="alert alert-danger">hash_equals returned false! </div>';
            
    }else{//else
     
        // generate new authentificators
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
        }
        //log the user in and redirect to notes page
           
        $_SESSION['user_id'] = $row['user_id']; 
        header("location:mainpagelogedin.php");
    }   
}
    


?>
