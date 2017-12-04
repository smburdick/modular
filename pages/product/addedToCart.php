<?php 
  // Gabriel Pinkard
  echo "<!DOCTYPE html>";
  echo "<html lang='en'>";
  include '../boilerplate.php';
  generate_head('Categories', 'Categories');
  $success = false;
  $results = false;
  $db_path = '../../db/modular.db'; 
  $db = new PDO('sqlite:' . $db_path);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $model_id = $_POST["model_id"];  
  $current_user = $_POST["current_user"];  
  $model_name = $_POST["model_name"];
  $quantity = $_POST["qty"];  
  $cart_stmt = $db->prepare("select quantity from InCart where user_id = ? and model_id = ?"); 
  $cart_stmt->bindParam(1, $current_user);
  $cart_stmt->bindParam(2, $model_id);
  $cart_stmt->execute(); 
  $results = $cart_stmt->fetchAll(); 
  if(sizeOf($results) === 0){
    $insert_stmt = $db->prepare("insert into InCart values (?, ?, ?);");
    $insert_stmt->bindParam(1, $current_user);
    $insert_stmt->bindParam(2, $model_id);
    $insert_stmt->bindParam(3, $quantity);
    //$temp = $db->exec($insert_stmt);
    $success = $insert_stmt->execute();
  } else {
    foreach($results as $tuple){ 
      $cur = $tuple["quantity"]; 
      $cur = $cur + $quantity;
      $update_stmt = $db->prepare("update InCart set quantity = ? where user_id = ? and model_id = ?");
      $update_stmt->bindParam(1, $cur);
      $update_stmt->bindParam(2, $current_user);
      $update_stmt->bindParam(3, $model_id);
    //$t = $db->exec($update_stmt);
      $result = $update_stmt->execute();
    }
  }
  echo "<br>";
  if($success || $result){
    echo "<div class='col-sm-8 text-center'>"; 
    echo "<font size='6' color='282a2e'> Added $quantity $model_name model(s) to your cart.</font>";
    echo "</div>";
    //echo ""; // echo photo of item
  } else {
    echo "<div class='col-sm-8 text-center'>"; 
    echo "<font size='6' color='282a2e'> There was an error processing your request.</font>";
    echo "</div>";
  }
  $db = null; // disconnect  
  //header("Location: /index.php"); // go back to product page
?>
