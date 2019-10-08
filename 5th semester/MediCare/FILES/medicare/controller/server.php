<?php 
	
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

	$storeName = $_POST['storeName'];
	$email = $_POST['email'];
	$psw = $_POST['psw'];
	$ownerName = $_POST['ownerName'];
	$streetAddress = $_POST['streetAddress'];
	$Area = $_POST['Area'];
	$Division = $_POST['Division'];
	$mobile = $_POST['mobile'];
	$storeDetail = $_POST['storeDetail'];


	//echo $firstName;
	$sql = 'INSERT INTO store_info(store_name,owner_name,password,email,contact_no,street_address,area,division,store_detail) VALUES(?,?,?,?,?,?,?,?,?)';
	
	$stmt = $pdo->prepare($sql);
	
	if($stmt->execute([$storeName, $ownerName, $psw,$email,$mobile,$streetAddress,$Area,$Division,$storeDetail])){

		header("Location:../view/storelogin.html");
		exit();
	}
	else{
		echo 'Error inserting value in database'.'<br>'.'<br>';
		echo "<a href='../view/signup.html' > Go back </a>";
		exit();
	}
	


	function callFunc(){
		if(!isset($_POST['storeName']) || empty($_POST['storeName']))
		{
			header("Location: ../view/signupFail.html");
			exit();
		}

		else if(!isset($_POST['ownerName']) || empty($_POST['ownerName']))
		{
			header("Location: ../view/signupFail.html");
			exit();
		}
		else if(!isset($_POST['psw']) || empty($_POST['psw']))
		{
			header("Location: ../view/signupFail.html");
			exit();
		}

		else if(!isset($_POST['email']) || empty($_POST['email']))
		{
			header("Location: ../view/signupFail.html");
			exit();
		}

		else if(!isset($_POST['mobile']) || empty($_POST['mobile']))
		{
			header("Location: ../view/signupFail.html");
			exit();
		}
	}
	
	/*echo $_POST['firstName'].'<br>';
	echo $_POST['lastName'].'<br>'.$_POST['userName'].'<br>';
	echo $_POST['psw'].'<br>'.$_POST['email'].'<br>';
	echo $_POST['gender'].'<br>'.$_POST['birthday'].'<br>';
	echo "<a href='../view/signup.html' > Go back </a>"; */

?>
