
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
      <h1>Categories</h1>
      <?php
      // database path
	$db_path = '/db/modular.db';
	$cat_id = $_GET["id"];
	if(!isset($cat_id)) echo "ERROR!";
	try {
	  $db = new PDO('sqlite:' . $db_path);
	  // try to optimize this later, doing three natural joins!
	  $get_belongsTo = 'select * from Category natural join BelongsTo natural join Model natural join User where category_id = ' . $cat_id . ';';
	  $result_belongsTo = $db->query($get_belongsTo);
	  foreach($result_belongsTo as $tuple){
	    $model_name = $tuple["model_name"];
	    $user_name = $tuple["username"];
	    $model_id = $tuple["model_id"];
	    //echo "<font color='red'>$model_name</font> <font color='blue'><br/>";
	    echo "<a href='/product/product.php?id=$model_id'><button><B>$model_name</B> by $user_name</button></a>";
	    echo "<br>";
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