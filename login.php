<?php
session_start();
$con = mysqli_connect('bmsyhziszmhf61g1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306','ze8g19ard2iom13t');
mysqli_select_db($con, 'userregistration');
$username = $_POST['username1'];
$pass = $_POST['password1'];
$s = " select * from users where user_username = '$username' && user_password = '$pass' ";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);
if($num == 1){
    $_SESSION['username'] = $name;
    header('location:dashboard.php');
}else{
    header('location:signup.html');
}
?>
