<?php
class Complaint
{
	private $_complaintDescription;
	private $_complaintDate;
	
	//constructor for 
	public function __construct($complaintDescription, $complaintDate)
	{
		$this->_complaintDescription = $complaintDescription;
		$this->_complaintDate = $complaintDate;
		
	}
	
	//show details of complaint 
	public function display_details()
	{
		echo "<br>Complaint Details<br>".
		"<br>Complaint: ".
		$this->_complaintDescription.
		"<br>Date: ".
		$this->_complaintDate.
		"<br><br>: ";
		
	}
	//insert details into form
	public function insert_complaint($_db_connection, $_bookingID)
	{	
		//remove complaints that are over a year old
		$complaintQuery1 = "DELETE FROM COMPLAINT WHERE complaintDate < DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)";
		
		//checks for number of complaints against a booking for a restaurant
		$complaintQuery2 = "SELECT * FROM complaint WHERE bookingID = '$_bookingID'";
		$result = mysqli_query($_db_connection, $complaintQuery2);
		$row_count = mysqli_num_rows($result);
		
		if($row_count < 1)
		{
			//insert complaint into database
			$complaintQuery3 = "INSERT INTO complaint(complaintDescription, complaintDate, bookingID)
			VALUES('$this->_complaintDescription','$this->_complaintDate', '$_bookingID')";
			$result = mysqli_query($_db_connection, $complaintQuery3);
			 echo "MY ".$this->_complaintDate."<br><br>";
		}
		//if number of complaints is 5 then remove the restaurant from the database
		$delete = "DELETE FROM RESTAURANT WHERE row_count == 5" ;
		
		
	}
	//accessor methods for complaint object
	public function set_complaintDescription($complaintDescription)
	{
		$this->complaintDescription = $complaintDescription;
	}	
	public function get_complaintDescription()
	{
		return $this->_complaintDescription;
	} 	
	public function set_complaintDate($complaintDate)
	{
		$this->complaintDate = $complaintDate;
	}
	public function get_complaintDate()
	{
		return $this->_complaintDate;
	}
}
	

?>