


<?php
// Include config file
// require_once "config.php";

$con = mysqli_connect('bmsyhziszmhf61g1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306','ze8g19ard2iom13t');

mysqli_select_db($con, 'userregistration');

 
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
                header("location: registered.php");
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






<!DOCTYPE html>
<html>

<head lang="en">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/signup.css">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<title>Login & Signup Page</title>


</head>

<body>

	<nav class="navbar navbar-expand-md text-white navbar-light">
		<div class="container">
			<a class="navbar-brand" href="index.html"><img src="css/img/nav.png" id='nav-logo' alt="Brand"></a>
			<button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse text-white" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">HOME</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="signup.php">SIGN UP</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="calculator.php">CALCULATOR</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="about.php">ABOUT</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>



	<div id="container">


		<div id="form-container">


			<!-- <div class="header-links">
				<a href="#">What?</a>
			</div> -->

			<div class="img-form">
			   <img class="img" src="css/img/dollar-resized3.jpg"/>
			   
				<form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return Validate1()" name="vform">
				<div id="firstname_div">
					<input type="text" name="firstname" placeholder="Firstname" value="<?php echo $fname; ?>"  required="">
					<div id="fname_error"><?php echo $fname_err; ?></div>
				</div>

				<div id="lastname_div">
					<input type="text" name="lastname" placeholder=" Lastname" value="<?php echo $lname; ?>" required="">
					 <div id="lname_error"><?php echo $lname_err; ?></div>
				</div>

				<div id="username_div">
					<input type="text" name="username" placeholder=" Username" value="<?php echo $username; ?>" required="">
					 <div id="username_error" style="color:red;"><?php echo $username_err; ?></div>
				</div>

				<div id="email_div">
					<input type="email" name="email" placeholder=" Email address" value="<?php echo $email; ?>" required="">
					 <div id="email_error"> <?php echo $email_err; ?></div>
				</div>

				<div id="password_div">
					<input type="password" name="password" placeholder=" Password" required="">
					<div id="pass_error" style="color:red;"><?php echo $password_err; ?></div>
				</div>


				<div id="pass_confirm_div">
					<input type="password" name="password_confirm" placeholder="Confirm Password" required="">
					<div id="password_error" style="color:red;"><?php echo $confirm_password_err; ?></div>
				</div>
				
				

				<input id="reg" type="Submit"  value="Sign up">

				<div id="register-alert">
					<p>Have an account?</p>
					<button type="button" onclick="window.location.href='signin.php'" value="signin">Sign in</button>
				</div>
			</form>
			</div>

			

		</div>

	</div>



	


	<footer>
        <div class="container footer-height">
            <div class="row">
                <div class="col-md-5">
                    <h3>About Us</h3>
                    <p>Charites Finance is a start up that aims to create a stable financial life for its users. We are
                        interested in helping you have a knowledge of your current financial status and assist you in
                        maximizing your money for a secure future.</p>
                </div>
                <div class="col-md-4">
                    <h3>About the App</h3>
                    <p>This free calculator helps you get a view of your financial positon by adding the values of your
                        assets and substracting your liabilites.</p>
                </div>
                <div class="col-md-3">
                    <h3>Contact Us</h3>
                    <address style="margin-bottom:30px;">
                        Team Charites <br>
                        3, Remote House,<br>
                        HNG Avenue, Nigeria <br>
                        +234-1111-0000 <br>
                        info@charitesfinance.com
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <p style='text-align: center' class='animated rollIn'>
                    CharitesFinance.com &copy;  2019
                </p>
            </div>
            </div>
        </div>
        </footer>

 

    <!-- <script type="text/javascript" src="js/script.js"></script> -->
	<script type="text/javascript" src="js/signup.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>

