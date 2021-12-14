<?php
	
	class Review
	{
		private $_reviewHeading;
		private $_reviewBody;
		private $_reviewStar;
		
		//constructor for card object
		public function __construct ($reviewHeading, $reviewBody, $reviewStar)
		{
			$this->_reviewHeading = $reviewHeading;
			$this->_reviewBody = $reviewBody;
			$this->_reviewStar = $reviewStar;
		}
		
		//shows details of new review on webpage
		public function display_details()
		{
			echo "<br>Review Details<br>".
			"<br>Rating: ".
			$this->_reviewStar." Stars".
			"<br>Heading: ".
			$this->_reviewHeading.
			"<br><br>: ".
			$this->_reviewBody;
		}
		
		//insert card details into form if user chooses to save card
		public function insert_review($_db_connection, $_bookingID)
		{
			//checks if a review was previously entered for the booking and if the booking wasn't a no show AND the review is within 1 month
			$reviewQuery1 = "SELECT * FROM review r, booking b WHERE r.bookingID = '$_bookingID' AND bookingStatus != 'No_Show' AND bookingDate >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
			$result = mysqli_query($_db_connection, $reviewQuery1);
			
			$row_count = mysqli_num_rows($result);
			
			//if review was previouly entered, refuses to enter a second review for the booking
			if($row_count == 1)
			{
				echo "<br>Review has already been submitted for this Visit<br>";
			}
			else
			{
				//inserts review into database
				$reviewQuery2 = "INSERT INTO review(reviewHeading, reviewBody, reviewStar, bookingID)
					VALUES('$this->_reviewHeading','$this->_reviewBody','$this->_reviewStar','$_bookingID')";
					
				if($result = mysqli_query($_db_connection, $reviewQuery2))
				{
					header("Location: userhome.html");
				}
				else
				{
					echo "<br>Failed to submit review. Please don't use apostrophes";
				}
			}
		}
		
		//accessor methods for review object
		public function set_reviewHeading($reviewHeading)
		{
			$this->_reviewHeading = $reviewHeading;
		}
		
		public function get_reviewHeading()
		{
			return $this->_reviewHeading;
		}
		
		public function set_reviewBody($reviewBody)
		{
			$this->_reviewBody = $reviewBody;
		}
		
		public function get_reviewBody()
		{
			return $this->_reviewBody;
		}
		
		public function set_reviewStar($reviewStar)
		{
			$this->_reviewStar = $reviewStar;
		}
		
		public function get_reviewStar()
		{
			return $this->reviewStar;
		}
	}
?>