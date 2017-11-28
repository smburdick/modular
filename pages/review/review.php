<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="../css/stars/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="css/style.css"/>
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
      <a class="navbar-brand" href="#">Modular</a> <!-- TODO logo -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Cart</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
      
      <!--<p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>-->
      
    </div>
    <div class="col-sm-4 text-left" style="margin-top: 10px"> 
      <h1>Review Title</h1>
      <form method="post">
        <input type="text" name="review_title" style="width:100%">
      <h1>Rating</h1>
      <input name="rating" id="input-id" type="text" class="rating" data-size="sm" style="showCaption: false">
      <script type = "text/javascript">$("#input-id").rating();</script>
    </div>
    <div class="col-sm-3 text-left" style="margin-top: 10px"> 
      <img src="homer.png" style="max-width:100%"/>
    </div>
    <div class="col-sm-3 text-left" style="margin-top: 10px"> 
      <h1>Product Name</h1>
      <h3>Other Info</h3>
    </div>
    <div class="col-sm-1 sidenav">
      
      <!--<div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>-->
    
    </div>
  </div>
  <div class="row content">
    <div class="col-sm-1 sidenav">   
    </div>
    <div class="col-sm-10 text-left">
      <h1>Review</h1>
      <input type="text" name="review" style="width:100%; height:100px">
      <input  type="submit" value="Submit">
    </div>
    
    </form>
    <!--TODO: use (now working) database connection to pull variables out into HTML-->
<?php

  ////testing only/////
  $_COOKIE["userID"] = mt_rand();
  $_GET["model_ID"] = mt_rand();
  /////////////////////

  $db_file = '../../db/modular.db';
  $user_id = $_COOKIE["userID"];
  $model_id = $_GET["model_ID"];
  $review = $_POST["review"];
  $rating = $_POST["rating"];

  //$test_query = 'INSERT INTO Review(user_id, model_id, review_date, comment, stars) VALUES (' . $user_id . ', ' . $model_id . ", \"" . $date . "\", \"" . $_POST["review"] . "\", " . $_POST["rating"] . ');';
  //echo "<p> test_query: " . $test_query . "</p>";


  //$insert = "INSERT INTO myTable (title, value) VALUES (:title, :value)";



  //$query_str = $db->prepare('INSERT INTO Review(user_id, model_id, review_date, comment, stars) VALUES (' . $user_id . ', ' . $model_id . ", \"" . $date . "\",  \"" . $_POST["review"] . "\", " . $_POST["rating"] . ');');
  //echo "<p>" . $query_str . "</p>";
  try {
      //open connection to the modular database file
      //echo "<p> " . $db_file . " </p>";
      //phpinfo();
      $db = new PDO('sqlite:' . $db_file);

      //set errormode to use exceptions
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //get the date from the database
      //$date_query = '\'SELECT date(\'now\');\'';
      //echo "<p> datequery: " . $date_query . " </p>";
      //$date = $db->query("SELECT date('now');");
      //$daquery = $db->prepare($date_query);
      //$date = $daquery->execute();
      //store the rating in the datbase, keep user on the review page
      $date = date('Y-m-d H:i', strtotime('now'));
      
      //echo "<p> date: " . $date . " </p>";
      //echo "<p> test: " . $test . "</p>";
      //echo "<p> userid: " . $user_id . "</p>";
      //echo "<p> modelid: " . $model_id . "</p>";
      //echo "<p> date: " . $date . "</p>";
      //echo "<p> review: " . $_POST["review"] . "</p>";
      //echo "<p> rating: " . $_POST["rating"] . "</p>";

      $test_query2 = "INSERT INTO Review(user_id, model_id, review_date, comment, stars) VALUES (:userid, :modelid, :reviewdate, :comment, :stars);";
      $stmt = $db->prepare($test_query2);
      // Bind parameters to statement variables
      $stmt->bindParam(':userid', $user_id);
      $stmt->bindParam(':modelid', $model_id);
      $stmt->bindParam(':reviewdate', $date);
      $stmt->bindParam(':comment', $review);
      $stmt->bindParam(':stars', $rating);

      //echo "<p> stmt: " . $stmt . "</p>";
      //$db->query($query_str);
      $stmt->execute();
      //loop through each tuple in result set and print out the data
      //ssn will be shown in blue (see below)
      /*foreach($result_set as $tuple) {
           echo "<font color='blue'>$tuple[category_id]</font> $tuple[category_name] $tuple[category_description] <br/>\n";
      }*/
        //disconnect from db
        $db = null;
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>
    <div class="col-sm-1 sidenav">   
    </div>
  </div>

</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>



</body>
</html>