






<?php
// Include config file
// require_once "config.php";

$con = mysqli_connect('bmsyhziszmhf61g1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306','ze8g19ard2iom13t');
mysqli_select_db($con, 'userregistration');

// $con = mysqli_connect('localhost','root');

// $con = mysqli_connect('fdb22.awardspace.net','3177438_userregistration');

// mysqli_select_db($con, 'userregistration');

// mysqli_select_db($con, 'userregistration');

 
// Define variables and initialize with empty values
$fname = $lname = $username = $email = $password = $confirm_password = "";
$fname_err = $lname_err = $username_err = $email_err = $password_err = $confirm_password_err = "";



 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    // if(empty(trim($_POST["username"]))){
    //     $username_err = "Please enter a username.";
    // } else{
        // Prepare a select statement
	
        $sql = "SELECT user_id FROM users WHERE user_username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result. The result is the username */
                mysqli_stmt_store_result($stmt);
                // Here we check if the username exists in the database. If any row contains that username then it displays the error.
                //If the username does not exist then it is inputed into the database.
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         // var_dump(mysqli_error($connection));
        // Close statement
        mysqli_stmt_close($stmt);
    // }

    // $fname = trim($_POST["firstname"]) ;
	// $lname = trim($_POST["lastname"]) ;
	// $email= trim($_POST["email"]) ;

	// Validate First name
	if(empty(trim($_POST["firstname"]))){
		$fname_err = "Please enter a your first name.";
	}else{
        $fname = trim($_POST["firstname"]);
    }

    // Validate First name
    if(empty(trim($_POST["lastname"]))){
		$lname_err = "Please enter a your last name.";
	}else{
        $lname = trim($_POST["lastname"]);
    }

    // Validate First name
    if(empty(trim($_POST["email"]))){
		$email_err = "Please enter a your email.";
	}else{
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
        //strlen() checks the length of the string or password     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["password_confirm"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["password_confirm"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_email, user_password) VALUES (?, ?, ?, ?, ? )";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_fname, $param_lname, $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;

           
            // $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash(It hides the password in the database)
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: registered.html");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}
?>






