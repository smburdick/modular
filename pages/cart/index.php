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
  <title>Cart</title>
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
      <div class="navbar-brand">Modular</div> <!-- TODO logo -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
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
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left"> 
    <?php
      $db_file = '../../db/modular.db';
      $user_id = $_COOKIE["userID"];

      if (isset($user_id)) {
        try {
          $db = new PDO('sqlite:'.$db_file);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare('SELECT * FROM InCart NATURAL JOIN Model NATURAL JOIN Material WHERE user_id = ?;');
          $stmt->bindParam(1, $user_id);
          // TODO populate the database with some toy data, and test on it
          $success = $stmt->execute();
          $result_set = $stmt->fetchAll();

          $cart_subtotal = 0;

          if ($success) {
            if (sizeof($result_set) == 0) {
              echo 'Your cart is empty.';
            } else {
              // TODO decide if we only need to have static content. I think it'd be good to also have an option to delete from
              // the cart in this view, as well as being able to update qty
              echo '<center><table ><tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
              foreach ($result_set as $tuple) {
                $cost = $tuple["mass_in_grams"] * ( floatval($tuple["cost_per_gram"]) / 100); // model unit cost
                $item_qty_total = $cost * $tuple["quantity"];
                $cart_subtotal += $item_qty_total;
                echo '<tr><th>'.$tuple["model_name"].'</th><th>'. $tuple["quantity"] .'</th><th>$'. $cost .' </tr>';
              }
              echo '</table>';
              echo '<a href="../checkout/index.php?user_id=' . $user_id . '"><button type="button">Checkout</button></a></center>';
            }
            
          } else {
            echo 'Sorry, there was an error connecting to the database';
          }

          $db = null;


        } catch (PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
      } else {
        echo '<br><br><p>You must be signed in to view your cart.</p>';
      }
      
    ?>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>

</body>
</html>

