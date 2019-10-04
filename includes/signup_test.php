<?php
require_once('config.php');
require_once('db_connection.php');
?>
<?php
if(isset($_POST['signup_submit'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

        $sql = "INSERT INTO users (firstname, lastname, username, email, password, date) VALUES(?,?,?,?,?)";
		$stmtinsert = $con->prepare($sql);
		$result = $stmtinsert->execute([$firstname, $lastname, $username, $email, $password]);
		if($result){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}
