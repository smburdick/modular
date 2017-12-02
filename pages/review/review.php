<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="../css/stars/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../css/style.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- important mandatory libraries -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
  <script src="../css/stars/js/star-rating.js" type="text/javascript"></script>
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
      <a class="navbar-brand" href="../">Modular</a> <!-- TODO logo -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="../">Home</a></li>
        <li><a href="../cart">Cart</a></li>
        <li><a href="#">Contact</a></li>
        <li>
          <form class="navbar-form" role="search" method="get" action="../search/search_results.php">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
          </form>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center" style=" height: 100%">
  <div class="row content" style="min-width: 761px; max-height: 350px">
    <div class="col-sm-1 sidenav">
    </div>
    <div class="col-sm-4 text-left" style="margin-top: 10px"> 
      <h2>Headline</h2>
      <form method="post" action="review_help.php">
        <input type="text" name="review_title" placeholder="What's most important to know?" style="width:100%">
      <h2>Rating</h2>
      <input name="rating" id="input-id" type="text" class="rating" data-size="sm" style="showCaption: false">
      <script type = "text/javascript">$("#input-id").rating();</script>
    </div>
    <div class="col-sm-3 text-left" style="margin-top: 10px"> 
      <img src="homer.png" style="max-width:100%"/>
    </div>
    <div class="col-sm-3 text-left" style="margin-top: 10px"> 
    <?php 
      $db_file = '../../db/modular.db';
      $user_id = $_COOKIE["userID"];
      $model_id = $_POST["model_ID"];
      //if(isset($user_id)){
        try {
          //open connection to the modular database file
          $db = new PDO('sqlite:' . $db_file);
          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //NOT FUNCTIONAL (need proper cookie)
          //replace Product Name and Other Info below with these 
          //php strings
          echo "<h2>Product Name</h2>";
          $prod_query = "SELECT model_name FROM Model WHERE model_id=:id;";
          $prod_prep = $db->prepare($prod_query);
          $prod_prep->bindParam(":id", $model_id);
          $result = $prod_prep->execute();
          echo "<h2>" . $result . "</h2>";
          echo "<h3>Other Info</h3>";
         }
         catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
         }
      //}
    
    //echo "<h3>Other Info</h3>";
    ?>
    </div>
    <div class="col-sm-1 sidenav">
    
    </div>
  </div>
  <div class="row content">
    <div class="col-sm-1 sidenav">   
    </div>
    <div class="col-sm-10 text-left">
      <h2>Review</h2>
      <input type="text" name="review" placeholder="What did you think of this product?" style="width:100%; height:100px">
      <input  type="submit" value="Submit">
    </div>
    
    </form>
    <!--TODO: use (now working) database connection to pull variables out into HTML-->
    <div class="col-sm-1 sidenav">   
    </div>
  </div>

</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>



</body>
</html>
