
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
      <a class="navbar-brand" href="#">Modular</a> <!-- TODO logo -->
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
	echo "<div class='col-sm-3 text-center'>";
	$db_path = '../../db/modular.db';
	$model_id = $_GET["id"]; // model id
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  $get_Model = 'select * from Model natural join Material natural join Created natural join User where model_id = ' . $model_id . ' and creator_id = user_id;';
	  $result_set = $db->query($get_Model);
	  foreach($result_set as $tuple){
	    // change href to profile.php when that is ready
	    echo "<img src='PresleyReed.jpg' width='320' height='400'>";
	    echo "</div>";
	    echo "<div class='col-sm-6 text-left'>";
	    $model_name = $tuple["model_name"];
	    $creator_name = $tuple["username"];
	    $mass_in_grams = $tuple["mass_in_grams"];
	    $cost_per_gram = $tuple["cost_per_gram"];
	    $cost = $cost_per_gram * $mass_in_grams / 100;
	    $material_name = $tuple["material_name"];
	    $model_id = $tuple["model_id"];
	    echo "<font size='6' color='red'><b>$model_name<b></font><a href='/profile/profile.php?username=$creator_name'><font size='4'> by <i>$creator_name</i></font></a>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> Material: </font> <font size='4' color='black'><i>$material_name</i></font>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> Mass in grams:</font><font size='4' color='black'> <i>$mass_in_grams</i> </font>";
	    echo "<br>";
	    echo "<font size='4' color='282a2e'> price:</font> <font size='4' color='red'><i>$ $cost</i></font>";
	    echo "<br>";
	    echo "<form action='/cart/index.php'>";
	    echo "<font size='4' color='282a2e'> quantity:</font> <input name='count' type='number' value='1' min='1'/>"; 
	    echo "</form>";
	    echo "<a href='/cart/index.php?id=$model_id'&quantity=$quantity><button>Add to cart </button></a>";
	    echo "</div>";
	  }
	} catch(PDOException $e){
	  die('Exception : ' . $e->getMessage());
	}
	$db = null // disconnect 
      ?>
  </div>
</div>
<?php 
  echo "<div class='container-fluid text-center'>";
  echo "<div class='row content'>";
  echo "<div class='col-sm-1 sidenav'>";
  echo "</div>";
  echo "<font size='6' color''282a2e>Reviews</font>"; 
  $db_path = '../../db/modular.db';
  $model_id = $_GET["id"]; // model id
  try {
    $db = new PDO('sqlite:' . $db_path);
    $get_Model = 'select * from Review natural join User natural join Model where model_id = ' . $model_id;
    $result_set = $db->query($get_Model);
    foreach($result_set as $tuple){
      $score = $tuple["stars"];
      $comment = $tuple["comment"];
      echo "<div class='card' style='width:200px'>";
      echo "<div class='card-header'>header</div>";
      echo "<div class='card-body'>Basic card</div>";
      echo "<div class='card-footer'>footer</div>";
      echo "</div>";
      //echo "<style> asdf {border :2px solid #021a40;} </style>";
      //echo "<asdf>";
      //echo "<font size='4' color='black'>";
      //echo "<br>";
      //echo $score;
      //echo "<br>";
      //echo $comment;
      //echo "</font>";
      //echo "</asdf>";
    }
  } catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
  }
  //$db = null // disconnect 
  echo "</div>";
  echo "</div>";
?>
</body>
</html>
