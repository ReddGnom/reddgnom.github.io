<?php
	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$submit = $_POST['frmsubmit'];
	$bookingID = $_POST['bookingID'];
	
	$ownerID = $_COOKIE['ID'];
	
	$_db_connection;
	$db_connector = new forchettaWeb_dbconnect();
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($_db_connection);
	}

	//Update booking
	$updateBooking = "UPDATE booking 
				SET bookingStatus ='$submit'
				WHERE bookingID = '$bookingID'";

	$update = mysqli_query($_db_connection, $updateBooking);
	
	header("Location: restaurantbookings.php");
?>