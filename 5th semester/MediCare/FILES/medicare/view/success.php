<?php

session_start();



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


			</ul>
		</div>
	</nav>

	<nav id="navbar">
		<div class="container">
			<?php echo "<p > total cost :".$_SESSION['Costt'].'taka(including delivery charge)</p>'; ?>
			<div class="form-group">
				<p1> thank you for your order . you will get a phone from the store for verification shortly. </p1>

			</div>



		</div>
	</nav>

</body>

</html>