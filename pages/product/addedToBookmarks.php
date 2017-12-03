<?php 
  // Gabriel Pinkard
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
      header("Location: /product/product.php?id=$model_id");
    } else {
      echo "There was an error adding this item to you bookmarks";
    }
  }
  else { // already bookmarked
    header("Location: /product/product.php?id=$model_id");
  }
?>
