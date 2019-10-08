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

$msg = "";

if($_SESSION['success']==0)
{
  $msg = "operation failed";
  $_SESSION['success']=-1;
}

else if($_SESSION['success']==1)
{
  $msg = "operation successful";
  $_SESSION['success']=-1;
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

  <section id="login">
    <div class="container">
      <div id="wrong">
        <?php echo '<p1>'.$msg.'</p1>'; ?>
      </div>
    </div>
  </section>

  <section id="login">
    <div class="container">



      <form action="../controller/updatestock.php" method="POST">

        <div class="form-group">
          <label>Product : </label>
          <select name="product">

            <?php
            $sql = 'SELECT * FROM drug_info order by product_name asc';
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
          <label>change type: </label>
          <select name="change">
            <option value="Add"> Add </option>
            <option value="Sell"> Sell </option>
            <option value="Remove"> Remove </option>

          </select>
        </div>

        <br>

        <div class="form-group">
          <label>Amount: </label>
          <input type="number" name="amnt">
        </div>
        <br>



        <input class="button" type="submit" value="Submit" name="Add">


      </form>
    </div>

  </section>

  

</body>

</html>