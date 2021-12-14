<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$userID = $_COOKIE['ID'];
	$_db_connection;
	$restaurantID = $_POST['resID'];
	
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	$restaurantNameQuery = "SELECT restaurantName FROM restaurant WHERE restaurantID = '$restaurantID'";
	$result = mysqli_query($_db_connection, $restaurantNameQuery);
	$restaurantName = implode(",", mysqli_fetch_assoc($result));
	
	$loyaltyQuery = "SELECT IFNULL(SUM(bookingGuestNumber), 0) * 5 FROM booking  WHERE userID = '$userID' AND bookingStatus != 'No_Show' AND bookingDate >= DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR)";
	
	$result = mysqli_query($_db_connection, $loyaltyQuery);
	$points = implode(",", mysqli_fetch_assoc($result));
?>
<html>
	<head>
		<title>Forchetta</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="dropdown.css" type="text/css">
	</head>
	
		
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
		<h1>Book a visit</h1>
		<center>
			<?php
				echo "<h2>You have ".$points." loyalty points!</h2>";
				if($points >= 1000)
				{
					echo "<br><h2>And you have a discount of 10%</h2>";
				}
				elseif($points >= 100)
				{
					echo "<br><h2>And you have a discount of 5%</h2>";
				}
			?>
			<form  action="processbooking.php" method="post" class="form" id="form" >
				<fieldset>
					<label for ="retaurant">Make a booking at: <?php echo $restaurantName; ?></label>
					<br>
					<label for ="date">Choose a date</label>
						<input type="date" name="date" id="date"><br>
					<br>
					<label for ="time">Time</label>
						<input type="time" name="time" id="time" step="1"><br>
					<br>
					<label for ="guests">Number of Seats you wish to book:</label>
						<input type="text" name="guests" id="guests" size="100" maxlength="100"><br>
					<br>
					<input type ="hidden" name="resID" id="resID" value="<?php echo $restaurantID; ?>">
					<input type="submit" value="Submit">
				</fieldset>
			</form>
		</center>
	</body>
</html>