<?php 

session_start();
logincheck();
callFunc();


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

$productName = $_POST['product'];
$changetype = $_POST['change'];
$amount = $_POST['amnt'];



if($changetype=='Add')
{
	$sql = 'CALL update_amount(?, ?, ?)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$storeID,$productName,$amount]);
	
	$_SESSION['success']=1;
	header("Location: ../view/mystore.php");
	
	exit();
}

if($changetype=='Sell' || $changetype=='Remove')
{
	$sql = 'SELECT amount FROM instore where store_id = ? and product_name  = ?';
  		//echo $sql;

	  	$stmt = $pdo->prepare($sql);
	  	$stmt->execute([$storeID,$productName]);
	  	$posts = $stmt->fetchAll();

	  	//var_dump($posts);
	  	foreach($posts as $post){
	    	$count=$post->amount;
	  	}

	if($count<$amount){
		$_SESSION['success']=0;
		header("Location: ../view/mystore.php");

		exit();	
	}

	$amount = $amount *-1;


	$sql = 'CALL update_amount(?, ?, ?)';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$storeID,$productName,$amount]);
	
	$_SESSION['success']=1;
	header("Location: ../view/mystore.php");
	
	exit();
}


	//echo $firstName;





function callFunc(){

}

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

	/*echo $_POST['firstName'].'<br>';
	echo $_POST['lastName'].'<br>'.$_POST['userName'].'<br>';
	echo $_POST['psw'].'<br>'.$_POST['email'].'<br>';
	echo $_POST['gender'].'<br>'.$_POST['birthday'].'<br>';
	echo "<a href='../view/signup.html' > Go back </a>"; */

	?>
