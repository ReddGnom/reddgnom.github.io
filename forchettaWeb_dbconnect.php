<?php
	include ("idatabaseconnect.php");
	
	final class ForchettaWeb_DBConnect implements iDatabaseConnect
	{
		public function connect_db() 
		{
			$connection = mysqli_connect('localhost', 'root', '', 'forchettaWebDB');
			
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MYSQL: " . mysqli_connect_errno();
			}
			
			return $connection;
		}
	}
?>