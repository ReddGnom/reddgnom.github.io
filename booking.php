<?php
	
	class Booking
	{	
		private $_bookingDate;
		private $_bookingTime;
		private $_bookingGuestNumber;
		
		//constructor of Booking object
		public function __construct($bookingDate, $bookingTime, $bookingGuestNumber) 
		{
			$this->_bookingDate = $bookingDate;
			$this->_bookingTime = $bookingTime;
			$this->_bookingGuestNumber = $bookingGuestNumber;
		}
		
		//Methods
		//shows Booking object details on website
		public function display_details()
		{
			echo "<br>Booking Details<br>".
			"<br>Booking Date & Time: ".
			$this->_bookingDate." @ ".$this->_bookingTime.
			"<br>Number of Guests: ".
			$this->_bookingGuestNumber;
		}
		
		//inserts booking information into database
		public function insert_booking($_restaurantID, $_userID, $_db_connection)
		{
			//decided against checking for existing bookings as it is a restaurants decision to approve bookings
			
			//query to insert booking object data into mysql database
			$bookingInsert = "INSERT INTO booking(bookingDate, bookingTime, bookingGuestNumber, restaurantID, userID) 
				VALUES('$this->_bookingDate','$this->_bookingTime','$this->_bookingGuestNumber','$_restaurantID','$_userID')";
		
			$result = mysqli_query($_db_connection, $bookingInsert);
		}
		
		//Accessor methods for booking object

			
		public function set_bookingGuestNumber($bookingGuestNumber)
		{
			$this->_bookingGuestNumber = $bookingGuestNumber;
		}
			
		public function get_bookingGuestNumber()
		{
			return $this->_bookingGuestNumber;
		}
		
		public function set_bookingDate($bookingDate)
		{
			$this->_bookingDate = $bookingDate;
		}
			
		public function get_bookingDate()
		{
			return $this->_bookingDate;
		}
		
		public function set_bookingTime($bookingTime)
		{
			$this->_bookingTime = $bookingTime;
		}
			
		public function get_bookingTime()
		{
			return $this->_bookingTime;
		}
	}
?>