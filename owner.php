<?php
	
	class Owner
	{
		private $_ownerEmail;
		private $_ownerPassword;
		private $_ownerSubscriptionDate;
		
		//owner object constructor
		public function __construct($ownerEmail, $ownerPassword)
		{
			$this->_ownerEmail = $ownerEmail;
			$this->_ownerPassword = $ownerPassword;
			$this->_ownerSubscriptionDate = date("Y-m-d");
		}
		
		//shows Owner information on webpage
		public function display_details()
		{
			echo "<br>User Details<br>".
			"<br>User Email: ".
			$this->_ownerEmail.
			"<br>Subscription Date: ".
			$this->_ownerSubscriptionDate;
		}
		
		//inserts owner object data into database
		public function insert_owner($_db_connection) 
		{
			$ownerQuery1 = "SELECT * FROM owner WHERE ownerEmail = \"".$this->_ownerEmail."\"";
			$result = mysqli_query($_db_connection, $ownerQuery1);
			
			$row_count = mysqli_num_rows($result);
			
			$ownerID = -1;
			
			//checks if the email is already used to register an account
			if($row_count == 1)
			{
				echo "<br>This email address is already registered<br>";
			}
			else
			{ 
				//insert data from the form into the mysql database
				$ownerQuery2 = "INSERT INTO owner(ownerEmail, ownerPassword, ownerSubscriptionDate) 
				VALUES('$this->_ownerEmail','$this->_ownerPassword','$this->_ownerSubscriptionDate')";
				
				$result = mysqli_query($_db_connection, $ownerQuery2);
				
				//sets ownerID to be used as a foreign key in restaurant and card tables
				$ownerID = $_db_connection->insert_id;
			}
			
			//returns ownerID to processnewaccount.php
			return $ownerID;
		}
		
		//accessor methods
		public function set_ownerEmail($ownerEmail)
		{
			$this->_ownerEmail = $ownerEmail;
		}
		
		public function get_ownerEmail()
		{
			return $this->_ownerEmail;
		}
		
		public function set_ownerPassword($ownerPassword)
		{
			$this->_ownerPassword = $ownerPassword;
		}
		
		public function get_ownerPassword()
		{
			return $this->_ownerPassword;
		}
		
		public function set_ownerSubscriptionDate($ownerSubscriptionDate)
		{
			$this->_ownerSubscriptionDate = $ownerSubscriptionDate;
		}
		
		public function get_ownerSubscriptionDate()
		{
			return $this->_ownerSubscriptionDate;
		}
	}
?>
		