<?php
	$host = 'localhost';
	$user = 'root';
	$password = '123456';
	$dbname = 'medicare';


	// set DSN = Data source name

	$dsn = 'mysql:host='. $host . '; dbname='.$dbname;

	$pdo = new PDO($dsn,$user,$password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	$stmt = $pdo->query('SELECT * FROM store_info');

	$storename = $_POST['storename'];
	$ownername = $_POST['ownername'];


	$sql = 'INSERT INTO `store_info` (`store_no`, `store_name`, `owner_name`) VALUES (?,?,?)';

	$stmt = $pdo->prepare($sql);

	if($stmt->execute(['NULL',$storename,$ownername])){
		
		//header("/success.html")
		header("Location:http://localhost/medicare/view/success.html");
		echo 'added';
		exit();
	}

