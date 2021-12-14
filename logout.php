<?php
	
	header("Location: landingpage.html");
	foreach($_COOKIE as $eaten)
	{
		setcookie($eaten, "");
	}
?>