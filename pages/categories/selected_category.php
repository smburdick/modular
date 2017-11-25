
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- TODO move to separate file -->
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
      <h1>Categories</h1>
      <?php
      // database path
      // REMEMBER TO CHANGE DB PATH WHEN YOU MOVE OVER BACK TO SERVER
	$db_path = '/srv/http/modular/db/modular.db';
	$category_id = '1';// remove hardcoding later
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  $get_belongsTo = 'select model_id, cost, material from Category natural join BelongsTo natural join Model where Category.category_id = ' . $category_id;
	  $result_belongsTo = $db->query($get_belongsTo);
	  //loop and print out all the categories
	  foreach($result_belongsTo as $tuple){
	    echo "<font color='red'>$tuple[model_id]</font> $tuple[cost] $tuple[material] <br/>";
	  }
	//$db = null // disconnect 
	} catch(PDOException $e){
	  die('Exception : ' . $e->getMessage());
	}
      ?>
      <hr>
      <h3>Test</h3>
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
