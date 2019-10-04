<?php

require_once('db_connection.php');

if(isset($_POST['signup_submit'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$date = date('Y-m-d')

        $sql = "INSERT INTO users (firstname, lastname, username, email, password, date) VALUES('$firstname', '$lastname', '$username',
	'$email', '$password', 'date')";
		$result = $con->query($sql);
		
		if($result){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}
