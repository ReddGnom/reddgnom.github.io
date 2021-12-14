<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	if(isset($_POST['delete']))
	{
		$account = $_POST['delete'];
		
		$deleteQuery[0] = "DELETE FROM complaint WHERE bookingID IN (SELECT bookingID FROM booking b WHERE userID = '$account'";
		$deleteQuery[1] = "DELETE FROM review WHERE bookingID IN (SELECT bookingID FROM booking b WHERE userID = '$account'";
		$deleteQuery[2] = "DELETE FROM booking WHERE userID = '$account'";
		$deleteQuery[3] ="DELETE FROM users WHERE userID = '$account'";
		
		foreach($deleteQuery as $delete)
		{
			if($deletethis = mysqli_query($_db_connection, $delete))
			{
				//echo "success";
			}
			else
			{
				//echo "file not deleted";
			}
		}
	}
	
	header("Location usersnoshow.php");
?>