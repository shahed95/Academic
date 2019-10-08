<?php
	
	session_start();
	logincheck();
	$storeName=$_SESSION['storeName'];
	$storeID = $_SESSION['storeID'];
	$ownerName =$_SESSION['ownerName'];
	$email = $_SESSION['userEmail'];

	function logincheck(){

  		if($_SESSION['login']=='0')
		{
			//echo 555555;
			header("Location: ../view/index.php");
			exit();
		}
		if(!isset($_SESSION['login']))
		{
			header("Location: ../view/index.php");
			exit();
		}
  	}
 // 	echo $storeID;
?>





<!DOCTYPE html>
<html>
<head>
	<title>Medicare</title>
	<link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body>
	<header id="main-header">
		<div class="container">
			<h1>Medicare</h1>
		</div>
	</header>

	<nav id="navbar">
		<div class="container">
			<ul>

				<li><a href="indexUser.php"><u>Home</u></a></li>
				<li><a href="search.php">Search</a></li>
				<li><a href="storelist.php">Store List</a></li>
				<li><a href="druglist.php">drug List</a></li>
				<li><a href="mystore.php">My Store</a></li>
				<li><a href="../controller/logout.php">Log Out</a></li>
				
			</ul>
		</div>
	</nav>

	<section id="welcome">
		<div class="container">
			<h1> <?php echo "Store Name : ".$storeName; ?></h1>
			<h1><small><small> <?php echo "Owner's Name : ".$ownerName; ?> </small></small> </p1>
			<h1><small><small> <?php echo "Email : ".$email; ?> </small></small> </p1>
			<h1><small><small> <?php echo "store ID : ".$storeID; ?> </small></small> </p1>
		</div>

	</section>
</body>
</html>


