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


  	//$userName = $_POST['userName'];
	  $userEmail = $_POST['userEmail'];
    $psw = $_POST['psw'];


	//GET ROW COUNT

  	$stmt = $pdo->prepare('SELECT * FROM store_info WHERE email = ? && password = ?');
  	$stmt->execute([$userEmail, $psw]);
  	$postCount = $stmt->rowCount();
    
    //header("Location: ../view/indexUser.php");

  	if($postCount){

  		// Session
      $_SESSION['login'] = '1';

  		$sql = 'SELECT * FROM store_info WHERE email=?';
  		//echo $sql;

	  	$stmt = $pdo->prepare($sql);
	  	$stmt->execute([$userEmail]);
	  	$posts = $stmt->fetchAll();

	  	//var_dump($posts);
	  	foreach($posts as $post){
	    	$_POST['storeName']=$post->store_name;
        $_POST['userEmail']=$post->email;
        $_POST['storeID']=$post->store_id;
        $_POST['ownerName']=$post->owner_name;
	  	}

	  	//$_SESSION['sql']=htmlentities($sql);
  		$_SESSION['storeName']=htmlentities($_POST['storeName']);
  		$_SESSION['userEmail']=htmlentities($_POST['userEmail']);
      $_SESSION['storeID'] = htmlentities($_POST['storeID']);
      $_SESSION['ownerName'] = htmlentities($_POST['ownerName']);
      

  		header("Location: ../view/indexUser.php");

  		exit();
  	}
  	else{
  		header("Location: ../view/storeloginFail.html");
  		exit();
  	}



  	function callFunc(){
  		if(!isset($_POST['userEmail']) || empty($_POST['userEmail']))
		{
			//echo 555555;
			header("Location: ../view/storeloginFail.html");
			exit();
		}
		else if(!isset($_POST['psw']) || empty($_POST['psw']))
		{
			//echo 5555;
			header("Location: ../view/storeloginFail.html");
			exit();
		}
  	}
?>