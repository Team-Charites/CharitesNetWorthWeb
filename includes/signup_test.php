<?php
require_once('config.php');
?>
<?php
if(isset($_POST)){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = sha1($_POST['password']);

        $sql = "INSERT INTO users (firstname, lastname, username, email, password ) VALUES(?,?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$firstname, $lastname, $username, $email, $password]);
		if($result){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}
