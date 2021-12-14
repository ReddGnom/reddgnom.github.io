<?php

	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	include("booking.php");
	$userID = $_COOKIE['ID'];
	
	$bookingDate = $_POST['date'];
	$bookingTime = $_POST['time'];
	$bookingGuests = $_POST['guests'];
	$resID = $_POST['resID'];
	
	$_db_connection;
	
	$booking = new Booking($bookingDate, $bookingTime, $bookingGuests);
	$db_connector = new forchettaWeb_dbconnect();
	
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
	
	$booking->insert_booking($resID, $userID, $_db_connection);
	
	header("Location: userhome.html");
?>