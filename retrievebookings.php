<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$userID = $_COOKIE["ID"];
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	$bookingQuery = "SELECT r.restaurantName, b.bookingDate, b.bookingTime, b.bookingGuestNumber, b.bookingStatus, b.bookingID FROM restaurant r, booking b WHERE b.userID = '$userID' AND b.restaurantID = r.restaurantID";

	if($result = mysqli_query($_db_connection, $bookingQuery))
	{
		
	}
	else
	{
		echo "Could not retrieve booking data";
	}
?>
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
							<a href="userhome.html">Home</a>
						</li>               
						<li>
							<a href="#">My Accounts</a>
							<ul>
								<li>
									<a href="updateuserdetails.html">Update Account</a>
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
					<th>Restaurant</th>
					<th>Date</th>
					<th>Time</th>
					<th>Seats</th>
					<th>Status</th>
					<th>Leave a Review</th>
					<th>Make a Complaint</th>
				</tr>
				<form method="post" action="review.html">
				<?php while ($row = mysqli_fetch_assoc($result)): ?>
					<tr>
					  <td><?php echo $row['restaurantName']; ?></td>
					  <td><?php echo $row['bookingDate']; ?></td>
					  <td><?php echo $row['bookingTime']; ?></td>
					  <td><?php echo $row['bookingGuestNumber']; ?></td>
					  <td><?php echo $row['bookingStatus']; ?></td>
					  <td><button type="submit" onclick="<?php setcookie('booking', $row['bookingID']); ?>">Review</button></td>
					  <td><button type="button" onclick="<?php setcookie('booking', $row['bookingID']); setcookie('bookingDate', $row['bookingDate']); ?> window.location.href= 'complaint.html'">Complaint</button></td>
					</tr>
				<?php endwhile; ?>
				</form>
			</table>
		</body>
	</center>
</html>