<?php
	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$_db_connection;
	
	$db_connector = new forchettaWeb_dbconnect();

	//store link to database
	$_db_connection = $db_connector->connect_db();
	
	if(isset($_POST['delete']))
	{
		$email = $_POST['delete'];
		$deleteQuery[1] ="DELETE FROM restaurant WHERE ownerID IN (SELECT ownerID FROM owner WHERE ownerEmail ='$email')";
		$deleteQuery[2] ="DELETE FROM card WHERE ownerID IN (SELECT ownerID FROM owner WHERE ownerEmail ='$email')";
		$deleteQuery[3] ="DELETE FROM owner WHERE ownerEmail ='$email'";
		
		
		foreach($deleteQuery as $delete)
		{
			if($deletethis = mysqli_query($_db_connection, $delete))
			{
				//echo $email;
			}
			else
			{
				echo "file not deleted";
			}
		}
	}
	
	
	$emailQuery = "SELECT r.restaurantName, ownerEmail, ownerSubscriptionDate FROM restaurant r, owner o WHERE ownerSubscriptionDate <= DATE_SUB(CURRENT_DATE, INTERVAL 11 MONTH) AND r.ownerID = o.ownerID";
	if($result = mysqli_query($_db_connection, $emailQuery))
	{
		
	}
	else
	{
		echo "Could not retrieve subscription data";
	}
?>
<html>
	<head>
		<title>Forchetta</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" type="text/css" href="dropdown.css">
	</head>
	
	<center>
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
		<body>

			<h1>Forchetta</h1> 
			<h2>Accounts with renewal due</h2>
			
			<table style="border: 1px solid black; border-collapse: collapse; background-color: #ffffff;">
				<tr style="background-color: #696969">
					<th>Restaurant</th>
					<th>Date</th>
					<th>Email</th>
					<th>Click to Email</th>
					<th>Delete this</th>
				</tr>
				<form method="post" action="emailrenewalsdue.php">
				<?php while ($row = mysqli_fetch_assoc($result)): ?>
					<tr>
						<td><?php echo $row['restaurantName']; ?></td>
						<td><?php echo $row['ownerSubscriptionDate']; ?></td>
						<td><?php echo $row['ownerEmail']; ?></td>
						<a href= "contact-form.html" class="email">
							<td><button type="button" onclick ="<?php setcookie('renewalDue', $row['ownerEmail']); ?>window.location.href='contact-form.html'">Email</td> 
						</a>
						<!--<a href="contact-form.html">
							<td><button type="button">Email</button></td>
						</a>-->
						<td><button type="submit" name="delete" id="delete" value="<?php echo $row['ownerEmail']; ?>" >Delete</button></td>
					</tr>
				<?php endwhile; ?>
				</form>
			</table>
		</body>
	</center>
</html>