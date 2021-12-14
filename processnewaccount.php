<?php
	//includes object classes(restaurant, card, and owner)
	include("restaurant.php");
	include("card.php");
	include("owner.php");
	//includes connection to database
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	//store information submitted from webpage
	$name = $_POST['name'];
	$number = $_POST['number'];
	$email = $_POST['email'];
	$password = $_POST['password1'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$cardType = $_POST['payment'];
	$cardNumber = $_POST['cardnumber'];
	$expiry = $_POST['expiry'];
	$cvv = $_POST['cvv'];
	$saveCard = isset($_POST['saveCard']);
	$_db_connection;
	
	//create data objects
	$owner = new Owner($email, $password);//owner has a date variable that is not passed in from form
	$restaurant = new Restaurant($name, $number, $street, $city, $country);
	$card = new Card($cardNumber, $cvv, $expiry, $cardType);
	//create connection to database
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	//closes connection to database
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
	
	//inserts data from owner object
	$_ownerID = $owner->insert_owner($_db_connection);
	
	//if owner information was successfully added to database, inserts restaurant and card data
	if ($_ownerID !== -1)
	{
		//inserts restaurant object data into database
		$restaurant->insert_restaurant($_ownerID, $_db_connection);
		//checks if the user wants to save card details
		if ($saveCard == 'save')
		{
			//inserts card object data into database
			$card->insert_card($_db_connection, $_ownerID);
		}	
	header("Location: login.html");
	/*displays details entered into the form on a new page
	echo "Restaurant Account Added<br>";
	$restaurant->display_details();
	echo "<br>";
	$owner->display_details();
	echo "<br>";
	$card->display_details();
	echo "<br>";*/
	}
	//If owner wasn't added returns an error message
	else
	{
		echo 'Could not create account. Please return to <link="forchetta.html">Forchetta Sign Up</link>';
	}
?>
	