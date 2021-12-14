<?php
	//includes object classes(user)
	include("user.php");
	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	//store information submitted from webpage
	$name = $_POST['name'];
	$number = $_POST['number'];
	$email = $_POST['email'];
	$password = $_POST['password1'];
	
	$_db_connection;
	
	//create data objects
	$user = new User($name, $email, $number, $password);
	//create connection to database
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	//closes connection to database
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
		
	//inserts data from user object
	$_userID = $user->insert_user($_db_connection);

	if($_userID != -1)
	{
		header("Location: login.html");
		/*displays details entered into the form on a new page
		echo "New User Account Added<br>";
		$user->display_details();*/
	}
?>
	