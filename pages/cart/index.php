<?php
  // testing zone
  $testUserID = 0; // Sam's test user ID
  setcookie("userID", $testUserID, time() + 86400  ); // 86400 = 1 day
  //$_COOKIE["userID"] = $testUserID; // necessary?
?>

<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!-- cart/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link rel = "stylesheet"
   type = "text/css"
   href = "../css/style.css" /> 
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Modular</a> <!-- TODO logo -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#">Cart</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <?php
      $db_file = '../../db/modular.db';
      $user_id = $_COOKIE["userID"];

      if (isset($user_id)) {
        try {
          $db = new PDO('sqlite:'.$db_file);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare('SELECT * FROM InCart NATURAL JOIN Model WHERE user_id = ?;');
          $stmt->bindParam(1, $user_id);
          // TODO populate the database with some toy data, and test on it
          $success = $stmt->execute();
          $result_set = $stmt->fetchAll(); // an array of results

          if ($success) {
            if (sizeof($result_set) == 0) {
              echo 'Your cart is empty.';
            } else {
              foreach ($result_set as $tuple) {
                echo '<p> '.$tuple["model_id"].' </p> <br>';
              } 
              echo '<a href="../checkout/index.php?user_id=' . $user_id . '"><button type="button">Checkout</button></a>';
            }
            
          } else {
            // TODO this really shouldn't happen?
          }

          $db = null;


        } catch (PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
      } else {
        echo '<br><br><p>You must be signed in to view your cart.</p>';
      }
      
    ?>
    <div class="col-sm-2 sidenav">

    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>

</body>
</html>

