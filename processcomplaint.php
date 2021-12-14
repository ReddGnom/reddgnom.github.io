<?php

	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	include("complaint.php");
	
	$bookingID = $_COOKIE['booking'];
	
	$complaintDescription = $_POST['comment'];
	$complaintDate = $_COOKIE['bookingDate'];
	
	$_db_connection;
	
	$complaint = new Complaint($complaintDescription, $complaintDate);
	$db_connector = new forchettaWeb_dbconnect();
	
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
	
	$complaint->insert_complaint($_db_connection, $bookingID);
	header("Location: userhome.html");
	//$complaint->display_details();
?>