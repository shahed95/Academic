<?php 
	session_start();
	callFunc();

	$host =  'localhost';
  	$user = 'root';
  	$password = '123456';
  	$dbname = 'medicare';


  	$dsn = 'mysql:host='. $host .';dbname='. $dbname;

  	$pdo = new PDO($dsn, $user, $password);
  	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


  	//INSERT DATA

	
	$product_name=$_SESSION['dname'];
	$store_id=$_POST['storeID2'];
	$amount=$_POST['amnt'];
	$customer_name=$_POST['cname'];
	$customer_mobile=$_POST['cphone'];
	$customer_address=$_POST['caddress'];

	$_SESSION['Costt'] =$amount;
	
	$sql = 'SELECT * FROM drug_info where product_name = ?';

	$stmt = $pdo->prepare($sql);
	$stmt->execute([$product_name]);
	$posts = $stmt->fetchAll();

	foreach($posts as $post){
  	  $_SESSION['Costt']=$amount*$post->Price;
	}

	$cost2= $_SESSION['Costt'];

	$_SESSION['dname'] = $product_name;

	//echo $firstName;
	$sql = 'INSERT INTO orderdetails(product_name,store_id,amount,customer_name,customer_mobile,customer_address,tot_cost) VALUES (?,?,?,?,?,?,?)';
	$stmt = $pdo->prepare($sql);



	if($stmt->execute([$product_name,$store_id,$amount,$customer_name,$customer_mobile,$customer_address,$cost2])){



		header("Location:../view/success.php");
		exit();
	}
	else{
		echo 'Error inserting value in database'.'<br>'.'<br>';
		echo "<a href='../view/orderfail.html' > Go back </a>";
		exit();
	}
	


	function callFunc(){
		if(!isset($_POST['cphone']) || empty($_POST['cphone']))
		{
			header("Location: ../view/orderfail.html");
			exit();
		}

		if(!isset($_POST['cname']) || empty($_POST['cname']))
		{
			header("Location: ../view/orderfail.html");
			exit();
		}

		if(!isset($_POST['caddress']) || empty($_POST['caddress']))
		{
			header("Location: ../view/orderfail.html");
			exit();
		}

		if(!isset($_POST['amnt']) || empty($_POST['amnt']))
		{
			header("Location: ../view/orderfail.html");
			exit();
		}

		if(!isset($_POST['storeID2']) || empty($_POST['storeID2']))
		{
			header("Location: ../view/orderfail.html");
			exit();
		}

	}
	
	/*echo $_POST['firstName'].'<br>';
	echo $_POST['lastName'].'<br>'.$_POST['userName'].'<br>';
	echo $_POST['psw'].'<br>'.$_POST['email'].'<br>';
	echo $_POST['gender'].'<br>'.$_POST['birthday'].'<br>';
	echo "<a href='../view/signup.html' > Go back </a>"; */

?>
