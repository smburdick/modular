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
// GET RID OF PRESLEYS PHOTO AND MAKE IT IMAGE (in slack)
// MAKE BETTER addedToCart.php 
// make better css for editor and project
	echo "<div class='col-sm-3 text-center'>";
	$db_path = '../../db/modular.db';
	$model_id = $_GET["id"]; // model id
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $get_Model = 'select * from Model natural join Material natural join User where model_id = ' . $model_id . ' and creator_id = user_id;';
	  $result_set = $db->query($get_Model);
	  foreach($result_set as $tuple){
	    // change href to profile.php when that is ready
	    echo "<img src='PresleyReed.jpg' width='320' height='400'>";
	    echo "</div>";
	    echo "<div class='col-sm-8 text-left'>";
	    $model_name = $tuple["model_name"];
	    $creator_name = $tuple["username"];
	    $mass_in_grams = $tuple["mass_in_grams"];
	    $cost_per_gram = $tuple["cost_per_gram"];
	    $cost = $cost_per_gram * $mass_in_grams / 100;
	    $material_name = $tuple["material_name"];
	    $model_id = $tuple["model_id"];
	    $current_user = $_COOKIE["user_id"];
	    //if(!isset($current_user)) echo "USER NOT SET";
	    //else echo "USER SET " . $current_user;
	    $description = $tuple["description"];
	    echo "<font size='6' color='red'><b>$model_name<b></font><a href='/profile/profile.php?username=$creator_name'><font size='4'> by <i>$creator_name</i></font></a>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> <u>Material:</u> </font> <font size='4' color='black'><i>$material_name</i></font>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> <u>Mass in grams:</u></font><font size='4' color='black'> <i>$mass_in_grams</i> </font>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> <u>price:</u></font> <font size='4' color='red'><i>$ $cost</i></font>";
	    echo "<br>";
	    echo "<form action='/product/addedToCart.php' method='post'";
	    echo "<font size='4' color='282a2e'><u>quantity</u></font>: <input type='number' name='qty' value='1' min='1'/><br>"; 
	    echo "<input type='hidden' name='current_user' value=$current_user>";
	    echo "<input type='hidden' name='model_id' value=$model_id>";
	    echo "<br>";
	    echo "<input type='submit' value='Add to cart'/>";
	    echo "</form>";
	    echo "<br>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'><b><i>Description:</i></b></font>";
	    echo "<p>$description</p>";
	    echo "</div>";
	  }
	} catch(PDOException $e){
	  die('Exception : ' . $e->getMessage());
	}
	$db = null; // disconnect 
      ?>
  </div>
</div>
<?php 
  echo "<div class='container-fluid text-center'>";
  echo "<div class='row content'>";
  echo "<div class='col-sm-1 sidenav'>";
  echo "</div>";
  echo "<div class='col-sm-9 text-center'>";
  echo "<font size='6' color='282a2e'>Reviews</font>"; 
  $db_path = '../../db/modular.db';
  $model_id = $_GET["id"]; // model id
  try {
    $db = new PDO('sqlite:' . $db_path);
    $get_Model = 'select * from Review natural join User natural join Model where model_id = ' . $model_id;
    $result_set = $db->query($get_Model);
    echo "<br>";
    echo "<br>";
    foreach($result_set as $tuple){
      echo "<div class='col-sm-1'>";
      echo "</div>";
      $score = $tuple["stars"];
      $user_name = $tuple["username"];
      $model_name = $tuple["model_name"];
      $date = $tuple["review_date"];
      // MAKE SURE TO GET REVIEW TITLE
      $comment = $tuple["comment"];
      echo "<div class='card col-sm-10'>";
      echo "<div class='card-header'><i>$user_name</i> gave <i>$model_name</i> $score stars</div>";
      echo "<div class='card-body'>$comment</div>";
      echo "<div class='card-footer'>Reviewd on $date</div>";
      echo "</div>";
    }
    //echo "</div>";
  } catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
  }
  //$db = null // disconnect
  echo "</div>";
  echo "</div>";
  $db = null;
?>
</body>
</html>
