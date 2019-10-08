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
      <?php
  
      session_start();


      $host =  'localhost';
      $user = 'root';
      $password = '123456';
      $dbname = 'medicare';


      $dsn = 'mysql:host='. $host .';dbname='. $dbname;

      $pdo = new PDO($dsn, $user, $password);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Session


        $sql = 'SELECT * FROM store_info order by store_name asc';
        //echo $sql;

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        foreach($posts as $post){
          echo '<h1>'. $post->store_name.'</h1>'.$post->street_address.','.$post->area.','.$post->division.' - '.$post->contact_no.'<br> <p><small><small>'.$post->store_detail.'</small></small></p><br>';

        }
       
       ?>

     </div>
      


     </div>
   </nav>

</body>

</html>