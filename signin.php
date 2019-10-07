<?php


session_start();

$con = mysqli_connect('bmsyhziszmhf61g1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306','ze8g19ard2iom13t');
mysqli_select_db($con, 'userregistration');


// $con = mysqli_connect('localhost','root');

// $con = mysqli_connect('fdb22.awardspace.net','3177438_userregistration');

// mysqli_select_db($con, 'userregistration');

$username = $password = "";
$username_err = $password_err = "";
 
// Define variables and initialize with empty values

 
// Processing form data when form is submitted
if(isset($_POST['submit'])){
 
    // Check if username is empty
    if(empty(trim($_POST["username1"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username1"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password1"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password1"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE user_username = ? AND user_password = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $password);
                    if(mysqli_stmt_fetch($stmt)){
                        // if(password_verify($password, $password)){
                    		
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            // $_SESSION["user_id"] = $id;
                            $_SESSION["user_username"] = $username; 

                            
                            // Redirect user to welcome page
                            header("location: calculator.php");
                        // }
                        
                    }
                } 

                else{
                    // Display an error message if username doesn't exist
                    $password_err = "Incorrect Login Details.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}




// }

?>

