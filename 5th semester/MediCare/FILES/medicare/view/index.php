<?php
	
	session_start();

	if(!isset($_SESSION['login']) )
	{
		$_SESSION['login']=0;	
	}

	logincheck();

	function logincheck(){


  		if($_SESSION['login']!='0')
		{
			//echo 555555;
			header("Location: ../view/indexUser.php");
			exit();
		}
  	}
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

			
				<li><a href="index.php"><u>Home</u></a></li>
				<li><a href="search.php">Search</a></li>
				<li><a href="storelist.php">Store List</a></li>
				<li><a href="druglist.php">drug List</a></li>
				
				<li><a href="storelogin.html">Log In</a></li>

			</ul>
		</div>
	</nav>
	<section id="welcome">
		<div class="container">
			<h1> WELCOME to medicare</h1>
			<h1><small><small> A complete solution for buying and selling medicine </small></small></h1>
		</div>

	</section>
</body>
</html>