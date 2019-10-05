<?php
session_start();
// header ('location:sign.php');
$con = mysqli_connect('localhost','root');
mysqli_select_db($con, 'userregistration');
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];
$s = "select * from users where user_username = '$username' ";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);
if($num == 1){
    echo"Username already taken";
}else{
    $reg= "insert into users(user_firstname, user_lastname, user_username, user_email, user_password) values( '$fname' , '$lname', '$username', '$email', '$pass')";
    mysqli_query($con, $reg);
    echo" Registration successful! <a href="signup.html">Sign in</a>";
}
?>
