<?php 
  // Gabriel Pinkard
  echo "Hello world";
  echo "<br>";
  $db_path = '../../db/modular.db'; 
  $db = new PDO('sqlite:' . $db_path);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $model_id = $_POST["model_id"];  
  $current_user = $_POST["current_user"];  
  $quantity = $_POST["qty"];  
  echo "model " . $model_id . " current " . $current_user . " quantity " . $quantity;
  $cart_stmt = $db->prepare("select quantity from InCart where user_id = ? and model_id = ?"); 
  $cart_stmt->bindParam(1, $current_user);
  $cart_stmt->bindParam(2, $model_id);
  $cart_stmt->execute(); 
  $results = $cart_stmt->fetchAll(); 
  echo "<br>";
  echo "size " . sizeOf($results);
  echo "<br>";
  echo "$current_user";
  echo "<br>";
  if(sizeOf($results) === 0){
    echo "<b>If statement triggered</b>";
    $insert_stmt = $db->prepare("insert into InCart values (?, ?, ?);");
    echo "<br>";
    echo "I made it here";
    $insert_stmt->bindParam(1, $current_user);
    echo "<br>";
    $insert_stmt->bindParam(2, $model_id);
    $insert_stmt->bindParam(3, $quantity);
    echo "<br>";
    echo "also made it here";
    $temp = $db->exec($insert_stmt);
    //$insert_stmt->execute();
    echo "<br>";
    echo "<b>inserting</b>";
  }
  foreach($results as $tuple){ 
    echo "<b>else statement triggered</b>";
    $cur = $tuple["quantity"]; 
    $cur = $cur + $quantity;
    echo "<br>";
    echo "cur " . $cur;
    echo "<br>";
    $update_stmt = $db->prepare("update InCart set quantity = ? where user_id = ? and model_id = ?");
    $update_stmt->bindParam(1, $cur);
    $update_stmt->bindParam(2, $current_user);
    $update_stmt->bindParam(3, $model_id);
    echo "made it here";
    echo "<br>";
    //$t = $db->exec($update_stmt);
    $update_stmt->execute();
    echo "<br>";
    echo "<b>updating</b>"; 
  }
  echo "<br>";
  //echo "<p>Added $quantity of $model_id to $current_user's cart</p>";
  $db = null; // disconnect  
?>
