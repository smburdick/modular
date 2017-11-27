
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
	$db_path = '/db/modular.db';
	$model_id = $_GET["id"]; // model id
	//$id = 1;
	echo "<h1>Product Page</h1>";
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  $get_Model = 'select * from Model natural join Material natural join Created natural join User where model_id = ' . $model_id . ';';
	  $result_set = $db->query($get_Model);
	  foreach($result_set as $tuple){
	    $model_name = $tuple["model_name"];
	    $creator_name = $tuple["username"];
	    $creator_id = $tuple["user_id"];
	    $cost = $tuple["cost_per_gram"] * $tuple["mass_in_grams"] / 100;
	    // change href to profile.php when that is ready
	    echo "<font size='6' color='red'><b>$model_name<b></font><a href='/profile/profile.html?id=$creator_id'><font size='4' color='black'> by <i>$creator_name</i></font></a>";
	    echo "$: $cost";
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
