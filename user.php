<?php
	
	class User
	{
		private $_userName;
		private $_userEmail;
		private $_userPhoneNumber;
		private $_userPassword;
		
		//user object constructor
		public function __construct($userName, $userEmail, $userNumber, $userPassword)
		{
			$this->_userName = $userName;
			$this->_userEmail = $userEmail;
			$this->_userNumber = $userNumber;
			$this->_userPassword = $userPassword;
		}
		
		//shows user information on webpage
		public function display_details()
		{
			echo "<br>User Details<br>".
			"<br>User Name: ".
			$this->_userName.
			"<br>User Email: ".
			$this->_userEmail.
			"<br>Phone Number: ".
			$this->_userNumber;
		}
		
		//inserts user object data into database
		public function insert_user($_db_connection) 
		{
			//checks the database to see if the email address is already in use
			$userQuery1 = "SELECT * FROM users WHERE userEmail = \"".$this->_userEmail."\"";
			$result = mysqli_query($_db_connection, $userQuery1);
			
			$row_count = mysqli_num_rows($result);
			$userID = -1;
			
			//checks if the email is already used to register an account
			if($row_count == 1)
			{
				echo "<br>This email address is already registered<br>";
			}
			else
			{ 
				//insert data from the form into the mysql database
				$userQuery2 = "INSERT INTO users(userEmail, userPassword, userName, userPhoneNumber) 
				VALUES('$this->_userEmail','$this->_userPassword','$this->_userName','$this->_userNumber')";
				
				$result = mysqli_query($_db_connection, $userQuery2);
				
				$userID = $_db_connection->insert_id;
			}
			
			return $userID;
		}
		
		//accessor methods
		public function set_userName($userName)
		{
			$this->_userName = $userName;
		}
		
		public function get_userName()
		{
			return $this->_userName;
		}
		
		
		public function set_userEmail($userEmail)
		{
			$this->_userEmail = $userEmail;
		}
		
		public function get_userEmail()
		{
			return $this->_userEmail;
		}
		
		public function set_userPassword($userPassword)
		{
			$this->_userPassword = $userPassword;
		}
		
		public function get_userPassword()
		{
			return $this->_userPassword;
		}
		
		public function set_userNumber($userNumber)
		{
			$this->_userNumber = $userNumber;
		}
		
		public function get_userNumber()
		{
			return $this->_userNumber;
		}
	}
?>
		