<?php session_start();
//Proper Database configuration here
include 'includes/db_connection.php';
include 'includes/functions.php';
/* 
    Here we perform the logic for database 
*/
if (isset($_POST['login'])) {
    $email_unsafe = $_POST['email'];
    $pass_unsafe = $_POST['password'];
    $email = mysqli_real_escape_string($con, $email_unsafe);
    $password = mysqli_real_escape_string($con, $pass_unsafe);
    $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'") or die(mysqli_error($con));
    $counter = mysqli_num_rows($query);
    if ($counter == 0) {
        addAlert('error', 'Invalid Email or Password! Try again');
        echo "<script>document.location='signup.html'</script>";
    } else {
        //Get user details from db
        $row = mysqli_fetch_array($query);
        $name = $row['username'];
        $id = $row['id'];
        //Add to Session
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $name;
        // addAlert('success', 'You Successfully Logged in');
        //TODO: Repace with `success.php` with success page
        echo "<script type='text/javascript'>document.location='dashboard.php'</script>";
    }
} else {
    header('Location signup.html');
}
