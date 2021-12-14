<?php
	include("user.php");
	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	include("owner.php");
	
	$name = $_POST['name'];
	$number = $_POST['number'];
	$email = $_POST['email'];
	$password = $_POST['password1'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	/*$cardType = $_POST['payment'];
	$cardNumber = $_POST['cardnumber'];
	$expiry = $_POST['expiry'];
	$cvv = $_POST['cvv'];
	
	$cardID;*/
	$countryID;
	$cityID;
	$streetID;
	$restaurantID; 
	$ownerID = $_COOKIE['ID'];
	
	$_db_connection;
	$db_connector = new forchettaWeb_dbconnect();
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($_db_connection);
	}

	//Update Owner
	$update1 = "UPDATE owner 
				SET ownerEmail ='$email', ownerPassword ='$password'
				WHERE ownerID = '$ownerID'";
	
	echo $update1;
	$update = mysqli_query($_db_connection, $update1);
	
	/*Update Card
	$update2 = "UPDATE card 
				SET cardNumber = '$cardNumber', cardExpiry = '$expiry', cardCVV = '$cvv' 
				WHERE ownerID IN 
					(SELECT ownerID
					FROM owner
					WHERE ownerID = '$ownerID')" ; 
	
	echo "<br>".$update2;					
	
	
	$update = mysqli_query($_db_connection, $update2);	*/
	
	
		//		COUNTRY
			$addressQuery1 = "SELECT countryID FROM COUNTRY WHERE countryName = \"".$country."\"";

			$result = mysqli_query($_db_connection, $addressQuery1);
			
			$row_count = mysqli_num_rows($result);

			$countryID = -1;

			//checks if the email is already used to register an account
			if($row_count != 1)
			{
				$countryInsert = "INSERT INTO country(countryName) VALUES('$country')";
				$result = mysqli_query($_db_connection, $countryInsert);
				$countryID = $_db_connection->insert_id;
			}
			else
			{
				$countryID = implode(",", mysqli_fetch_assoc($result));
			}

			
			//		CITY
			$addressQuery2 = "SELECT cityID FROM city WHERE cityName = '$city' AND countryID = '$countryID'";
			
			$result = mysqli_query($_db_connection, $addressQuery2);
			
			$row_count = mysqli_num_rows($result);
			
			$cityID = -1;
			
			//checks if the email is already used to register an account
			if($row_count != 1)
			{
				$cityInsert = "INSERT INTO city(cityName, countryID) VALUES('$city', '$countryID')";
				$result = mysqli_query($_db_connection, $cityInsert);
				$cityID = $_db_connection->insert_id;
			}
			else
			{
				$cityID = implode(",", mysqli_fetch_assoc($result));
			}
			
			//		STREET
			$addressQuery3 = "SELECT streetID FROM street s WHERE streetName = '$street' AND s.cityID = '$cityID'";
			
			$result = mysqli_query($_db_connection, $addressQuery3);
			
			$row_count = mysqli_num_rows($result);
			
			$streetID = -1;
			
			if($row_count != 1)
			{
				$streetInsert = "INSERT INTO street(cityID, streetName) VALUES('$cityID', '$street')";
				$result = mysqli_query($_db_connection, $streetInsert);
				$streetID = $_db_connection->insert_id;
			}
			else
			{
				$streetID = implode(",", mysqli_fetch_assoc($result));
			}
			
		//Restaurant
			$update3 = "UPDATE restaurant 
						SET restaurantPhoneNumber ='$number', restaurantName ='$name'
						WHERE restaurant.ownerID = '$ownerID'";
	
			echo $update3;
			$update = mysqli_query($_db_connection, $update3);
			
?>