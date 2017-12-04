
<?php 
  // Gabriel Pinkard
  echo "<!DOCTYPE html>";
  echo "<html lang='en'>";
  include '../boilerplate.php';
  generate_head('Categories', 'Categories');
  $db_path = '../../db/modular.db'; 
  $db = new PDO('sqlite:' . $db_path);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $model_id = $_POST["model_id"];  
  $current_user = $_POST["current_user"];  
  $bm_stmt = $db->prepare("select * from Bookmarks where user_id = ? and model_id = ?"); 
  $bm_stmt->bindParam(1, $current_user);
  $bm_stmt->bindParam(2, $model_id);
  $bm_stmt->execute(); 
  $results = $bm_stmt->fetchAll(); 
  if(sizeOf($results) === 0){ // if user has not bookmarked the item
    $ins_stmt = $db->prepare("insert into Bookmarks values (?, ?);");
    $ins_stmt->bindParam(1, $current_user);
    $ins_stmt->bindParam(2, $model_id);
    $success = $ins_stmt->execute(); 
    if($success){
      //header("Location: /product/product.php?id=$model_id");
      echo "<div class='col-sm-8 text-center'>"; 
      echo "<font size='6' color='282a2e'>This model has been added to your bookmarks.</font>";
      echo "</div>";
    } else {
      echo "<div class='col-sm-8 text-center'>"; 
      echo "<font size='6' color='282a2e'>There was an error processing your request.</font>";
      echo "</div>";
    }
  }
  else { // already bookmarked
    //header("Location: /product/product.php?id=$model_id");
    echo "<div class='col-sm-8 text-center'>"; 
    echo "<font size='6' color='282a2e'>This item was already bookmarked.</font>";
    echo "</div>";
  }
?>
