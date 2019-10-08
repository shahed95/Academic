<?php

session_start();
$storeName=$_SESSION['storeName'];
$storeID = $_SESSION['storeID'];
$host =  'localhost';
$user = 'root';
$password = '123456';
$dbname = 'medicare';


$dsn = 'mysql:host='. $host .';dbname='. $dbname;

$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



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
				<li><a href="draglist.php">Drag List</a></li>
				<li><a href="mystore.php">My Store</a></li>



				<li><a href="index.php">Log Out</a></li>
				



			</ul>
		</div>
	</nav>

	<section id="login">
		<div class="container">

			<form action="../controller/adding.php" method="POST">

				<div class="form-group">
					<select name="cars">

						<?php
						$sql = 'SELECT * FROM drag_info order by product_name asc';
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						$posts = $stmt->fetchAll();
						foreach($posts as $post){
							echo '<option value="'. $post->product_name.'">'.$post->product_name."</option>";
						}
						?>

					</select>
				</div>

				<br>

				<div class="form-group">
					<label>Ammount: </label>
					<input type="number" name="amnt">
				</div>
				<br>

				<input class="button" type="submit" value="Submit" name="Add">


			</form>
		</div>

	</section>




</body>
</html>






