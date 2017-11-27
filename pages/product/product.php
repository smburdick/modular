
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
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    </div>
    <div class="col-sm-8 text-left"> 
      <?php
      // database path
      // REMEMBER TO CHANGE DB PATH WHEN YOU MOVE OVER BACK TO SERVER
	$db_path = '/srv/http/modular/db/modular.db';
	//$id = $_GET["modelID"]; // model id
	$id = 0;
	// need to get name of item, who made it, calculate cost
	$model = $tuple[model_id];
	echo "<h1>Product Page</h1>";
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  $get_Model = 'select * from Model natural join Created natural join User where model_id = ' . $id . ';';
	  $get_Material = 'select * from Material natural join Model where model_id = ' . $id . ';';
	  $result_set = $db->query($get_Model);
	  $result_material = $db->query($get_Material);
	  foreach($result_set as $tuple){
	    echo "<font color='red' size='6'>$tuple[name]</font> by $tuple[username]<br/>";
	    foreach($result_material as $tup){
	      $cost = $tup[mass_in_grams] * $tup[cost_per_gram]; 
	      echo "COST: ";
	      //echo "<input type='checkbox' name = $$tup["Model.name"]></input> <B>$tup["Material.name"]</B> <i>$cost</i><br/>";
	    }
	  }
	//$db = null // disconnect 
	} catch(PDOException $e){
	  die('Exception : ' . $e->getMessage());
	}
      ?>
      <hr>
    </div>
    <div class="col-sm-2 sidenav">
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>

</body>
</html>
