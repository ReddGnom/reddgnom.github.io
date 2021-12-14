<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$ownerID = $_COOKIE["ID"];
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	$bookingQuery = "SELECT u.userEmail, b.bookingDate, b.bookingTime, b.bookingGuestNumber, b.bookingStatus, b.bookingID FROM restaurant r, booking b, users u WHERE r.ownerID = '$ownerID' AND b.restaurantID = r.restaurantID AND b.userID = u.userID";

	if($result = mysqli_query($_db_connection, $bookingQuery))
	{
		
	}
	else
	{
		echo "Could not retrieve booking data";
	}
?>
<script>
	function getID(rowID, set)
	{
		document.getElementById('bookingID').value = rowID;
		document.FormBooking.frmsubmit.value = set; 
		document.FormBooking.submit();
	}
</script>
<html>
	<head>
		<title>Forchetta</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="dropdown.css" type="text/css">
	</head>
	
	<center>
		<body>
			<nav>
				<div id="nav_wrapper">
					<ul>
						<li>
							<a href="ownerhome.html">Home</a>
						</li>               
						<li>
							<a href="#">My Accounts</a>
							<ul>
								<li>
									<a href="updateownerdetails.html">Update Account</a>
								</li>
								<li>
									<a href="logout.php">Logout</a>
								</li>                      
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<h1>Forchetta</h1>  
			<h2>Bookings</h2>
			
			<table style="border: 1px solid black; border-collapse: collapse; background-color: #ffffff;">
				<tr style="background-color: #696969">
					<th>User Email</th>
					<th>Date</th>
					<th>Time</th>
					<th>Seats</th>
					<th>Status</th>
					<th>Confirm</th>
					<th>Cancel</th>
					<th>No Show</th>
				</tr>
				<form method="post" action="setBooking.php" name="FormBooking">
				<input type="hidden" value="" name="bookingID" id="bookingID">
				<input type="hidden" value="" name="frmsubmit" id="frmsubmit">
				<?php while ($row = mysqli_fetch_assoc($result)): ?>
					<tr>
					  <td><?php echo $row['userEmail']; ?></td>
					  <td><?php echo $row['bookingDate']; ?></td>
					  <td><?php echo $row['bookingTime']; ?></td>
					  <td><?php echo $row['bookingGuestNumber']; ?></td>
					  <td><?php echo $row['bookingStatus']; ?></td>
					  <td><button type="button" id="<?php echo $row['bookingID']; ?>" onclick="getID(this.id, 'Confirmed')">Confirm</button></td>
					  <td><button type="button" id="<?php echo $row['bookingID']; ?>" onclick="getID(this.id, 'Cancelled')">Cancel</button></td>
					  <td><button type="button" id="<?php echo $row['bookingID']; ?>" onclick="getID(this.id, 'No_Show')">No Show</button></td>
					</tr>
				<?php endwhile; ?>
				</form>
			</table>
		</body>
	</center>
</html>