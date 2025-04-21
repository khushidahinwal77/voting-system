<?php
$connect = mysqli_connect("localhost:3308","root","","voting") or die("connection failed");
if($connect){
    echo "connected!";
}
else{
    echo "not connected";
}

?>