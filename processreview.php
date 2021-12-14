<?php

	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	include("review.php");
	
	$bookingID = $_COOKIE['booking'];
	
	$reviewHeading = $_POST['heading'];
	$reviewBody = $_POST['body'];
	$reviewStar = $_POST['stars'];
	
	$_db_connection;
	
	$review = new Review($reviewHeading, $reviewBody, $reviewStar);
	$db_connector = new forchettaWeb_dbconnect();
	
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
	
	$review->insert_review($_db_connection, $bookingID);
	
?>