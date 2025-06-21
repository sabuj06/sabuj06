<?php
$servername="localhost";
$username="root";
$password="";
$database="crud_student_list";

$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("Connection Lost:".mysqli_connect_error());
}
?>