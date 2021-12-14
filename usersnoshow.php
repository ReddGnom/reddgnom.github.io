<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();
	
	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	$userNoShowQuery = "SELECT userName, userEmail, COUNT(bookingStatus), u.userID FROM users u, booking b WHERE u.userID = b.userID AND bookingStatus = 'No_Show' GROUP By userName";
	
	$result = mysqli_query($_db_connection, $userNoShowQuery);
	?>
<html>
	<head>
		<title>Forchetta</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" type="text/css" href="dropdown.css">
	</head>
	<nav>
		<div id="nav_wrapper">
			<ul>               
				<li>
					<a href="emailrenewalsdue.php">Account Renewals</a>
				</li>         
				<li>
					<a href="usersnoshow.php">Delete No Show Users</a>
				</li>
				<li>
					<a href="systemadmindetails.html">Change details</a>
				</li>
				<li>
					<a href="attempt21.xml">View your account</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<center>
		<body>

			<h1>Forchetta</h1> 
			<h2>Accounts with renewal due</h2>
			
			<table style="border: 1px solid black; border-collapse: collapse; background-color: #ffffff;">
				<tr style="background-color: #696969">
					<th>User Email</th>
					<th>User Name</th>
					<th>User ID</th>
					<th>No Shows</th>
					<th>Delete User</th>
				</tr>
				<form method="post" action="noshow.php">
					<?php while ($row = mysqli_fetch_assoc($result)): ?>
				<tr>
					<td><?php echo $row['userEmail']; ?></td>
					<td><?php echo $row['userName']; ?></td>
					<td><?php echo $row['userID']; ?></td>
					<td><?php echo $row['COUNT(bookingStatus)']; ?></td>
					<td><button type="submit" value="<?php echo $row['userID']; ?>" name="delete" id="delete" >Delete</button></td>
				</tr>
					<?php endwhile; ?>
			</form>
			</table>
		</body>
	</center>
</html>