<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$ownerID = $_COOKIE["ID"];
	$fail= "";
	$table = false;
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	$reviewQuery = "SELECT u.userName, b.bookingDate, b.bookingTime, b.bookingGuestNumber, b.bookingStatus, v.reviewStar, v.reviewHeading, b.bookingID FROM restaurant r, booking b, users u, review v WHERE r.ownerID = '$ownerID' AND b.restaurantID = r.restaurantID AND b.userID = u.userID AND b.bookingID = v.bookingID";

	if($result = mysqli_query($_db_connection, $reviewQuery))
	{	
		if(mysqli_num_rows($result) > 0)
		{
			$table = true;
		}
	}
	else
	{
		$fail= "Could not retrieve booking data";
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
					<th>User Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Seats</th>
					<th>Status</th>
					<th>Stars</th>
					<th>Review Text</th>
					<th>Challenge Review</th>
				</tr>
				<form method="post" action="challengeReview.php">
				<?php if($table == true){ while ($row = mysqli_fetch_assoc($result)): ?>
					<tr>
					  <td><?php echo $row['userName']; ?></td>
					  <td><?php echo $row['bookingDate']; ?></td>
					  <td><?php echo $row['bookingTime']; ?></td>
					  <td><?php echo $row['bookingGuestNumber']; ?></td>
					  <td><?php echo $row['bookingStatus']; ?></td>
					  <td><?php echo $row['reviewStar']; ?></td>
					  <td><?php echo $row['reviewHeading']; ?></td>
					  <td><button type="submit" value="<?php echo $row['bookingID']; ?>" name="submit" id="submit">Challenge</button></td>
					</tr>
				<?php endwhile; } echo "<h2>".$fail."</h2>"; ?>
				</form>
			</table>
		</body>
	</center>
</html>