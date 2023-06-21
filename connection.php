<?php
$link = mysqli_connect("localhost", "root", "", "online-notes");
if(!$link){
    die("ERROR: Unable to connect: " . mysqli_connect_error());
}
?>