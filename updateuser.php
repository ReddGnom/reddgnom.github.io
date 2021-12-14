<?php
	include("user.php");
	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$name = $_POST['name'];
	$number = $_POST['number'];
	$email = $_POST['email'];
	$password = $_POST['password1'];
	
	$userID = $_COOKIE['ID'];
	
	$_db_connection;
	$db_connector = new forchettaWeb_dbconnect();
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($_db_connection);
	}

	//Update Owner
	$update1 = "UPDATE users 
				SET userEmail ='$email', userPassword ='$password', userPhoneNumber ='$number'
				WHERE userID = '$userID'";
	
	echo $update1;
	$update = mysqli_query($_db_connection, $update1);
		
?>