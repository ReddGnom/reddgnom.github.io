<?php
	
	class Restaurant
	{	
		private $_restaurantName;
		private $_restaurantPhoneNumber;
		private $_restaurantStreet;
		private $_restaurantCity;
		private $_restaurantCountry;
		
		//constructor of restaurant object
		public function __construct($restaurantName, $restaurantPhoneNumber, $restaurantStreet, $restaurantCity, $restaurantCountry) 
		{
			$this->_restaurantName = $restaurantName;
			$this->_restaurantPhoneNumber = $restaurantPhoneNumber;
			$this->_restaurantStreet = $restaurantStreet;
			$this->_restaurantCity = $restaurantCity;
			$this->_restaurantCountry = $restaurantCountry;
		}
		
		//Methods
		//shows restaurant object details on website
		public function display_details()
		{
			echo "<br>Restaurant Details<br>".
			"<br>Restaurant Name: ".
			$this->_restaurantName.
			"<br>Phone Number: ".
			$this->_restaurantPhoneNumber.
			"<br>Address: ".
			$this->_restaurantStreet.", ".$this->_restaurantCity.", ".$this->_restaurantCountry;
		}
		
		//inserts restaurant information into database
		public function insert_restaurant($_ownerID, $_db_connection)
		{
			//		COUNTRY
			$addressQuery1 = "SELECT countryID FROM COUNTRY WHERE countryName = \"".$this->_restaurantCountry."\"";

			$result = mysqli_query($_db_connection, $addressQuery1);
			
			$row_count = mysqli_num_rows($result);

			$countryID = -1;

			//checks if the email is already used to register an account
			if($row_count != 1)
			{
				$countryInsert = "INSERT INTO country(countryName) VALUES('$this->_restaurantCountry')";
				$result = mysqli_query($_db_connection, $countryInsert);
				$countryID = $_db_connection->insert_id;
			}
			else
			{
				$countryID = implode(",", mysqli_fetch_assoc($result));
			}

			
			//		CITY
			$addressQuery2 = "SELECT cityID FROM city WHERE cityName = '$this->_restaurantCity' AND countryID = '$countryID'";
			
			$result = mysqli_query($_db_connection, $addressQuery2);
			
			$row_count = mysqli_num_rows($result);
			
			$cityID = -1;
			
			//checks if the email is already used to register an account
			if($row_count != 1)
			{
				$cityInsert = "INSERT INTO city(cityName, countryID) VALUES('$this->_restaurantCity', '$countryID')";
				$result = mysqli_query($_db_connection, $cityInsert);
				$cityID = $_db_connection->insert_id;
			}
			else
			{
				$cityID = implode(",", mysqli_fetch_assoc($result));
			}
			
			//		STREET
			$addressQuery3 = "SELECT streetID FROM street s WHERE streetName = '$this->_restaurantStreet' AND s.cityID = '$cityID'";
			
			$result = mysqli_query($_db_connection, $addressQuery3);
			
			$row_count = mysqli_num_rows($result);
			
			$streetID = -1;
			
			//checks if the email is already used to register an account
			if($row_count != 1)
			{
				$streetInsert = "INSERT INTO street(cityID, streetName) VALUES('$cityID', '$this->_restaurantStreet')";
				$result = mysqli_query($_db_connection, $streetInsert);
				$streetID = $_db_connection->insert_id;
			}
			else
			{
				$streetID = implode(",", mysqli_fetch_assoc($result));
			}
			
			//query to insert restaurant object data into mysql database
			$restaurantQuery2 = "INSERT INTO restaurant(restaurantName, restaurantPhoneNumber, streetID, ownerID) 
				VALUES('$this->_restaurantName','$this->_restaurantPhoneNumber','$streetID','$_ownerID')";
		
			$result = mysqli_query($_db_connection, $restaurantQuery2);
		}
		
		//Accessor methods for restaurant object
		public function set_restaurantName($restaurantName)
		{
			$this->_restaurantName = $restaurantName;
		}
			
		public function get_restaurantName()
		{
			return $this->_restaurantName;
		}
			
		public function set_restaurantPhoneNumber($restaurantPhoneNumber)
		{
			$this->_restaurantPhoneNumber = $restaurantPhoneNumber;
		}
			
		public function get_restaurantPhoneNumber()
		{
			return $this->_restaurantPhoneNumber;
		}
		
		public function set_restaurantStreet($restaurantStreet)
		{
			$this->_restaurantStreet = $restaurantStreet;
		}
			
		public function get_restaurantStreet()
		{
			return $this->_restaurantStreet;
		}
		
		public function set_restaurantCity($restaurantCity)
		{
			$this->_restaurantCity = $restaurantCity;
		}
			
		public function get_restaurantCity()
		{
			return $this->_restaurantCity;
		}
			
		public function set_restaurantCountry($restaurantCountry)
		{
			$this->_restaurantCountry = $restaurantCountry;
		}
			
		public function get_restaurantCountry()
		{
			return $this->_restaurantCountry;
		}
	}
?>