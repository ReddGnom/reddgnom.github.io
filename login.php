<?php

	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$loginType = $_POST['logType'];
	$id;
	
	$_db_connection;
	
	//create connection to database
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	if($loginType == "owner")
	{
		//query to check if email address is used for an account
		$emailQuery1 = "SELECT ownerPassword FROM OWNER WHERE ownerEmail = \"".$email."\"";
		
		$result = mysqli_query($_db_connection, $emailQuery1);
		
		$row_count = mysqli_num_rows($result);
		
		//if the email address is used for an account
		if($row_count == 1)
		{
			//checks if the password entered matches the stored password
			if (implode(",", mysqli_fetch_assoc($result)) == $password)
			{
				header("Location: ownerhome.html");
				
				$idQuery1 = "SELECT ownerID FROM owner WHERE ownerEmail = \"".$email."\"";
				$result = mysqli_query($_db_connection, $idQuery1);
				$id = implode(",", mysqli_fetch_assoc($result));
				/*$nameQuery = "Select r.restaurantName FROM restaurant r, owner o WHERE r.ownerID = o.ownerID and ownerEmail = '$email'";
				$result = mysqli_query($_db_connection, $nameQuery);
				$resName = implode(",", mysqli_fetch_assoc($result));
				echo "<br>My name is ".$resName;*/
			}
			else
			{	
				echo "<br>Incorrect Password";
			}
		}
		else
		{
			echo "<br>Incorrect email address";
		}
	}
	elseif($loginType == "user")
	{
		//query to check if email address is used for an account
		$emailQuery2 = "SELECT userPassword FROM users WHERE userEmail = \"".$email."\"";
		
		$result = mysqli_query($_db_connection, $emailQuery2);
		
		$row_count = mysqli_num_rows($result);
		
		//if the email address is used for an account
		if($row_count == 1)
		{
			//checks if the password entered matches the stored password
			if (implode(",", mysqli_fetch_assoc($result)) == $password)
			{
				header("Location: userhome.html");
				$idQuery2 = "SELECT userID FROM users WHERE userEmail = \"".$email."\"";
				$result = mysqli_query($_db_connection, $idQuery2);
				$id = implode(",", mysqli_fetch_assoc($result));
			}
			else
			{	
				echo "<br>Incorrect Password";
			}
		}
		else
		{
			echo "<br>Incorrect email address";
		}
	}
	if(isset($id))
	{
		setcookie("ID", $id);
	}
?>