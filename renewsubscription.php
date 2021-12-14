<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
		
	
	
	$cardType = $_POST['payment'];
	$cardNumber = $_POST['cardnumber'];
	$expiry = $_POST['expiry'];
	$cvv = $_POST['cvv'];
	$ownerID = $_COOKIE['ID'];
	$card = $_POST['card'];
	$saveCard = isset($_POST['saveCard']);
	$renewalDate = date("Y-m-d");
	$_db_connection;
	
	//create connection to database
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	

	if($card == "newCard")
	{
			//checks if the card number was previously entered
			$cardQuery1 = "SELECT * 
							FROM card 
							WHERE cardNumber = $cardNumber";
			$result = mysqli_query($_db_connection, $cardQuery1);
			
			$row_count = mysqli_num_rows($result);
			
			//if card was previouly entered, refuses to enter card details again
			if($row_count == 1)
			{
				echo "<br>Error processing card details<br>";
			}
			else
			{
				//inserts card information into database
				$cardQuery2 = "UPDATE card
								SET cardNumber = '$cardNumber', cardExpiry = '$expiry', cardCVV = '$cvv' 
								WHERE ownerID IN 
									(SELECT ownerID
									FROM owner
									WHERE ownerID = '$ownerID')" ; 
					
				$result = mysqli_query($_db_connection, $cardQuery2);
				echo "<br>Card details updated<br>";
			}
		
	}
	elseif ($card == "oldCard")
	{
		$updateQuery= "UPDATE owner		
						SET ownerSubscriptionDate = '$renewalDate'
						WHERE ownerID = $'ownerID'" ;
		
	}
	?>	