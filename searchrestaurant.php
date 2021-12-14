<?php

	include("forchettaWeb_dbconnect.php");
	include("idbtableaccess.php");
	
	$table = false;
	$fail = "";
	$favoriteCity = $_COOKIE['favoriteCity'];
	$favoriteCountry = $_COOKIE['favoriteCountry'];
	
	$_db_connection;
	$db_connector = new forchettaWeb_dbconnect();
	
	$_db_connection = $db_connector->connect_db();
	
	function __destruct()
	{
		mysqli_close($this->_db_connection);
	}
	
	if(isset($_POST['search']))
	{	
		$searchType = $_POST['searchType'];
		$search = $_POST['search'];
		if($searchType == "resName")
		{
			$resSearch = "SELECT restaurantName, restaurantID FROM restaurant r WHERE restaurantName LIKE '%$search%'";
			if($result = mysqli_query($_db_connection, $resSearch))
			{
				if(mysqli_num_rows($result) > 0)
				{
					$table = true;
				}
				else
				{
					$fail = "No restaurant with that name found";
				}
			}
			else
			{
				$fail = "Could not find restaurant with that name";
			}
		}
		elseif($searchType == "city")
		{
			$citySearch = "SELECT restaurantName, r.restaurantID FROM restaurant r, street s, city c WHERE cityName LIKE '$search' AND c.cityID = s.cityID AND r.streetID = s.streetID";
			if($result = mysqli_query($_db_connection, $citySearch))
			{
				if(mysqli_num_rows($result) > 0)
				{
					$table = true;
				}
				else
				{
					$fail = "No restaurant in that city found";
				}
			}
			else
			{
				$fail = "Could not find city with that name";
			}
		}
		elseif($searchType == "country")
		{
			$countrySearch = "SELECT restaurantName, restaurantID FROM restaurant r, street s, city c, country u WHERE countryName LIKE '$search' AND u.countryID = c.countryID AND c.cityID = s.cityID AND r.streetID = s.streetID";
			if($result = mysqli_query($_db_connection, $countrySearch))
			{
				if(mysqli_num_rows($result) > 0)
				{
					$table = true;
				}
				else
				{
					$fail = "No restaurant in that country found";
				}
			}
			else
			{
				$fail = "Could not find country with that name";
			}
		}
		
	}
	elseif(isset($_COOKIE['favoriteCity']))
	{
		$citySearch = "SELECT restaurantName, r.restaurantID FROM restaurant r, street s, city c WHERE cityName LIKE '$favoriteCity' AND c.cityID = s.cityID AND r.streetID = s.streetID";
		if($result = mysqli_query($_db_connection, $citySearch))
		{
			if(mysqli_num_rows($result) > 0)
			{
				$table = true;
			}
			else
			{
				$fail = "No restaurant in that city found";
			}
		}
		else
		{
			$fail = "Could not find city with that name";
		}
	}
	elseif(isset($_COOKIE['favoriteCountry']))
	{
		$countrySearch = "SELECT restaurantName, restaurantID FROM restaurant r, street s, city c, country u WHERE countryName LIKE '$favoriteCountry' AND u.countryID = c.countryID AND c.cityID = s.cityID AND r.streetID = s.streetID";
			if($result = mysqli_query($_db_connection, $countrySearch))
			{
				if(mysqli_num_rows($result) > 0)
				{
					$table = true;
				}
				else
				{
					$fail = "No restaurant in that country found";
				}
			}
			else
			{
				$fail = "Could not find country with that name";
			}
	}
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
		<h1>Search for a restaurant</h1>
		<center>
			<form action="searchrestaurant.php" method="post">
				<a style="color: #e6ecff">Select by: </a><select name="searchType">
					<option value="resName">Restaurant Name</option>
					<option value="city">City</option>
					<option value="country">Country</option>
				</select>
			  <input type="text" placeholder="Search.." name="search">
			  <button type="submit">Search</button>
			</form>
			<?php
				if($table == true)
				{
					echo "<table style=\"border: 1px solid black; border-collapse: collapse; background-color: #ffffff;\"><form action='makebooking.php' method='post'><tr style=\"background-color: #696969\"><th>Restaurant</th><th>Stars</th><th>Make booking</th></tr>";
				
					while ($row = mysqli_fetch_assoc($result))
					{
						echo "<tr><td>".$row['restaurantName']."</td>";	
						$starSearch = "SELECT IFNULL(ROUND(AVG(reviewStar), 0), 'Unknown') FROM review v, booking b WHERE b.restaurantID = \"".$row['restaurantID']."\" AND b.bookingID = v.bookingID";
						$starFetch = mysqli_query($_db_connection, $starSearch);
						//$stars = implode(",", mysqli_fetch_assoc($starFetch));
						echo "<td>".implode(",", mysqli_fetch_assoc($starFetch))."</td>";
						echo '<td><button type="submit" value="'.$row['restaurantID'].'" name="resID" id="resID">Book</button></td></tr>';
					}
					echo "</form></table>";
				}
				else 
				{
					echo "<h2>".$fail."</h2>";
				}
			?>
		</center>
	</body>
</html>
<!-- 
setcookie('res', $row['restaurantName']);
-->