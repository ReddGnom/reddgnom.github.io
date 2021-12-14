<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	//$ownerID = $_COOKIE["ID"]; Don't think we need//
	
	$Entry = $_POST['entry'];
	$locationType = $_POST['locType'];
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();

	if($locationType == "country")
	{
		//query to search for country//
		$countryQuery = "SELECT countryName FROM country WHERE countryName = \"".$Entry."\"";
		
		
		
		if($result = mysqli_query($_db_connection, $countryQuery))
		{
			echo $locationType." Found";
			$cookie_name = "favoriteCountry";
			$cookie_value = $Entry;
			setcookie($cookie_name, $cookie_value);
		}
		if(!isset($_COOKIE[$cookie_name])) 
		{
			echo "Cookie named '" . $cookie_name . "' is not set!";
		} 
		else 
		{
			echo "Cookie '" . $cookie_name . "' is set!<br>";
			echo "Value is: " . $cookie_value;
		}
		
	}
	elseif($locationType == "city")
	{
		//query to check if email address is used for an account
		$cityQuery = "SELECT cityName FROM city WHERE cityName = \"".$Entry."\"";
		
		
		
		//if the email address is used for an account
		if($result = mysqli_query($_db_connection, $cityQuery))
		{
			echo "City worked. ";
			$cookie_name = "favoriteCity";
			$cookie_value = $Entry;
			setcookie($cookie_name, $cookie_value);
			
			if(!isset($_COOKIE[$cookie_name])) {
			echo "Cookie named '" . $cookie_name . "' is not set!";
			} 
			else {
				echo "Cookie '" . $cookie_name . "' is set!<br>";
				echo "Value is: " . $cookie_value;

			}
		}
		else
		{
			echo "<br>Incorrect city address";
		}
	}

?>
