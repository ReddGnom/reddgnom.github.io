<?php
//include abstract class of ENUMS
	include ("cardType.php");
	
	class Card
	{
		private $_cardNumber;
		private $_cardCVV;
		private $_cardExpiry;
		private $_cardType;
		
		//constructor for card object
		public function __construct ($cardNumber, $cardCVV, $cardExpiry, $cardType)
		{
			$this->_cardNumber = $cardNumber;
			$this->_cardCVV = $cardCVV;
			$this->_cardExpiry = $cardExpiry;
			$this->_cardType = $cardType;
		}
		
		//shows details of card object on webpage
		public function display_details()
		{
			echo "<br>Card Details<br>".
			"<br>Card Number: ".
			$this->_cardNumber.
			"<br>CVV: ".
			$this->_cardCVV.
			"<br>Expiry: ".
			$this->_cardExpiry.
			"<br> Card Type: ".
			$this->_cardType;
		}
		
		//insert card details into form if user chooses to save card
		public function insert_card($_db_connection, $_ownerID)
		{
			//checks if the card number was previously entered
			$cardQuery1 = "SELECT * FROM card WHERE cardNumber = \"".$this->_cardNumber."\"";
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
				$cardQuery2 = "INSERT INTO card(cardNumber, cardExpiry, cardCVV, cardType, ownerID)
					VALUES('$this->_cardNumber','$this->_cardExpiry','$this->_cardCVV','$this->_cardType','$_ownerID')";
					
				$result = mysqli_query($_db_connection, $cardQuery2);
			}
		}
		
		//accessor methods for card object
		public function set_cardNumber($cardNumber)
		{
			$this->_cardNumber = $cardNumber;
		}
		
		public function get_cardNumber()
		{
			return $this->_cardNumber;
		}
		
		public function set_cardCVV($cardCVV)
		{
			$this->_cardCVV = $cardCVV;
		}
		
		public function get_cardCVV()
		{
			return $this->_cardCVV;
		}
		
		public function set_cardExpiry($cardExpiry)
		{
			$this->_expiry = $expiry;
		}
		
		public function get_cardExpiry()
		{
			return $this->cardExpiry;
		}
		
		public function set_cardType($cardType)
		{
			$this->_cardType = $_cardType;
		}
		
		public function get_cardType()
		{
			return $this->_cardType;
		}
	}
?>