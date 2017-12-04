<?php
  error_reporting(0);
  echo '<!DOCTYPE html>
  <html lang="en">';
  include '../boilerplate.php';
  generate_head('Cart', 'Cart');
?>

<body>

<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left"> <br><br>
    <?php
      $db_file = '../../db/modular.db';

      $user_id = $_COOKIE["user_id"];

      if (isset($user_id)) {
        try {
          $db = new PDO('sqlite:'.$db_file);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare('SELECT model_id, model_name, quantity, mass_in_grams, cost_per_gram FROM InCart NATURAL JOIN Model NATURAL JOIN Material WHERE user_id = ?;');
          $stmt->bindParam(1, $user_id);
          $success = $stmt->execute();
          $result_set = $stmt->fetchAll();

          $cart_subtotal = 0;

          if ($success) {
            if (sizeof($result_set) == 0) {
              echo 'Your cart is empty.';
            } else {
              // TODO item image, be able to modify quantity and delete tuples
              echo '<center><table ><tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
              foreach ($result_set as $tuple) {
                $cost = $tuple["mass_in_grams"] * ( floatval($tuple["cost_per_gram"]) / 100); // model unit cost
                $item_qty_total = $cost * $tuple["quantity"];
                $cart_subtotal += $item_qty_total;
                echo '<tr><th><a href="../product/product.php?id=' . $tuple["model_id"] . '">'.$tuple["model_name"].'</a></th>' . '<th>'. $tuple["quantity"] .'</th><th>$'. sprintf("%.2f", $cost) .' </tr>';
              }
              echo '</table>';
              echo '<form action="../checkout/" method="post"><input type="hidden" name="checking_out" value="true"><input type="submit" value="Checkout"></form>';
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


</body>
</html>

