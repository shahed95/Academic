<?php
	
	session_start();
	//$storeName=$_SESSION['storeName'];
	//$storeID = $_SESSION['storeID'];
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
				<li><a href="druglist.php">Drug List</a></li>
				



			</ul>
		</div>
	</nav>

	<section id="login">
		<div class="container">

			<form action="result.php" method="POST">
			

			<div class="form-group">
				<label>Drug Name: </label>
				<select name="dname">

			    <?php
        
				        $sql = 'SELECT distinct product_name FROM drug_info order by product_name asc';
				        
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
				<label>Area: </label>
				<select name="area">

			    <?php
        
				        $sql = 'SELECT distinct area FROM store_info order by area asc';
				        
				        $stmt = $pdo->prepare($sql);
				        $stmt->execute();
				        $posts = $stmt->fetchAll();
				        foreach($posts as $post){
				          echo '<option value="'. $post->area.'">'.$post->area."</option>";
				        }
				       
       			?>

			  </select>
			</div>
			<br>

			<div class="form-group">
				<label>division: </label>
				<select name="division">

			    <?php
        
				        $sql = 'SELECT distinct division FROM store_info order by division asc';
				        
				        $stmt = $pdo->prepare($sql);
				        $stmt->execute();
				        $posts = $stmt->fetchAll();
				        foreach($posts as $post){
				          echo '<option value="'. $post->division.'">'.$post->division."</option>";
				        }
				       
       			?>

			  </select>
			</div>
			<br>


			
			<input class="button" type="submit" value="search" name="search">
			

			</form>
		</div>

	</section>




</body>
</html>






