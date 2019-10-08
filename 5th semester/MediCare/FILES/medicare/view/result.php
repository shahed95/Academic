<?php

session_start();

$_SESSION['dname']=$_POST['dname'];
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

        <li><a href="index.php"><u>Home</u></a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="storelist.php">Store List</a></li>
        <li><a href="druglist.php">drug List</a></li>
        
        

      </ul>
    </div>
  </nav>

  <nav id="navbar">
    <div class="container">

      <div class="form-group">

        <?php echo '<p1> result for ' .$_POST['dname']. ' at '. $_POST['area'].', '.$_POST['division'].'</p1>';
        ?>
        <br>
        <p1> </p1>

    </div>

  </div>
</nav>

  
    <div class="container">
      <form action="..\controller\addorder.php" method="POST"> 


      <div class="form-group">

        <label>Available stores: </label>
        <select name="storeID2">

        
        <?php
        $sql = 'SELECT * FROM store_info join instore where store_info.store_id = instore.store_id and product_name = ? and area = ? and division = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['dname'],$_POST['area'],$_POST['division']]);
        $posts = $stmt->fetchAll();
        foreach($posts as $post){
        echo $post->store_name.', '.$post->street_address.'--- available amount :'.$post->amount;
        
        echo '<option value="'. $post->store_id.'">'.$post->store_name.', '.$post->street_address.'---- available amount :'.$post->amount."</option>";

      
      }

      ?>



      </select>
          <label>Order Amount: </label>
          <input type="number" name="amnt">
        
        <br>
          
        <label>Your Name: </label>
        <input type="text" name="cname">

        <br>
          
        <label>Your Phone number: </label>
        <input type="text" name="cphone">
        
        <br>
          
        <label>Your address: </label>
        <input type="text" name="caddress">

        <br>
        <br>

        <input class="button" type="submit" value="Submit" name="Submit">
    </div>

  </form>
  </div>




</body>

</html>