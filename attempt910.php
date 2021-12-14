<?php


	$dom=new DOMDocument('1.0');
	$dom->load("attempt21.xml");

	$postusername = $_POST['username'];
	$postpassword = $_POST['password'];

	$root=$dom->documentElement; 

	$nodesToDelete=array();

	$systemadmin=$root->getElementsByTagName('account');

	// Loop trough childNodes
	foreach ($systemadmin as $account) {
		$username=$account->getElementsByTagName('username')->item(0)->textContent;
		$password=$account->getElementsByTagName('password')->item(0)->textContent;

		// Your filters here

		// To remove the marker you just add it to a list of nodes to delete
		$nodesToDelete[]=$account;
		//$dom->saveXML(); // This will return the XML as a string
		//
	}

	// You delete the nodes
	foreach ($nodesToDelete as $node) $node->parentNode->removeChild($node);

	 $root = $dom->getElementsByTagName('systemadmin')->item(0);
	// create the <account> tag
	$account = $dom->createElement('account');
	$root->insertBefore($account, $root->firstChild );
	 
	//create other elements
	$usernameElement = $dom->createElement('username');
	$account->appendChild($usernameElement);
	$usernameText = $dom->createTextNode($postusername);
	$usernameElement->appendChild($usernameText);

	$passwordElement = $dom->createElement('password');
	$account->appendChild($passwordElement);
	$passwordText = $dom->createTextNode($postpassword);
	$passwordElement->appendChild($passwordText);

	//echo $dom->saveXML();
	$dom->save('attempt21.xml');
	header("Location: attempt21.xml");
?>

