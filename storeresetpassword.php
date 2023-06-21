<?php 
session_start();
include("connection.php");


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

$result= mysqli_query($link, $sql);  
$count = mysqli_num_rows($result);

if(!$result){
    die("query failed: ". mysqli_error($link));
}

if($count !== 1){//if combination does not exist
    echo '<div class="alert alert-danger">Reset password failed! Please try again.</div>';
    exit;
}



?>