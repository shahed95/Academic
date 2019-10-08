<?php
  
  session_start();
  logincheck();
  $storeName=$_SESSION['storeName'];
  $storeID = $_SESSION['storeID'];
  $ownerName =$_SESSION['ownerName'];
  $email = $_SESSION['userEmail'];

  $host =  'localhost';
  $user = 'root';
  $password = '123456';
  $dbname = 'medicare';


  $dsn = 'mysql:host='. $host .';dbname='. $dbname;

  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



  function logincheck(){

      if($_SESSION['login']=='0')
    {
      //echo 555555;
      header("Location: ../view/index.php");
      exit();
    }
    }
    echo $storeID;
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
        <li><a href="stock.php">Stock</a></li>
        <li><a href="orders.php">orders</a></li>
        <li><a href="recent.php">Recent Activities</a></li>

        

        <li><a href="mystore.php">My Store</a></li>
        <li><a href="index.php">Log Out</a></li>
        
      </ul>
    </div>
  </nav>

  <nav id="navbar">
    <div class="container">
      
      <div class="form-group">
      <?php
  
        $sql = 'SELECT * FROM instore where store_id=? and amount!=0 order by product_name asc' ;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$storeID]);
        $posts = $stmt->fetchAll();

        foreach($posts as $post){
          echo '<p>'. $post->product_name." - - - - - - total : ".$post->amount.' piece </p><br>';
        }
       
       ?>

     </div>
      


     </div>
   </nav>

</body>

</html>