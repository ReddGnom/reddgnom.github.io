<?php

	//includes connection to database
	$dom=new DOMDocument('1.0');
	$dom->load("attempt21.xml");

	$root=$dom->documentElement; 

	$systemadmin=$root->getElementsByTagName('account');
	
	$postusername = $_POST['username'];
	$postpassword = $_POST['password'];

	//header("Location: /Working/updateownerdetails.html");

	foreach ($systemadmin as $account) {
	$username=$account->getElementsByTagName('username')->item(0)->textContent;
	$password=$account->getElementsByTagName('password')->item(0)->textContent;
	}
	
	if($postusername == $username)
	{
		if($postpassword == $password)
		{
			header("Location: emailrenewalsdue.php");
		}
		else
		{
			echo "<br>Incorrect Password";
		}
	}
	else
	{
		echo "<br>Incorrect username"; 
	}
?>