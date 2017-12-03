
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- TODO move to separate file -->
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
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Cart</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- TODO this should be conditioned on whether the user is logged in. We'll need to set a cookie to check this. -->
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav> 
<div class="container-fluid text-center" style="height: 450px">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
    </div>
<?php 
  // Gabriel Pinkard
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
    echo "<p>Added $quantity $model_name model to your cart</p>";
  } else {
    echo "There was an error processing your request";
  }
  $db = null; // disconnect  
  //header("Location: /index.php"); // go back to product page
?>
</body>
</html>
