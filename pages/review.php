<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Modular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="css/stars/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="css/style.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- important mandatory libraries -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
  <script src="css/stars/js/star-rating.js" type="text/javascript"></script>
</head>
<body>
  <!--TODO: use (now working) database connection to pull variables out into HTML-->
  <?php
  /*
        //path to the SQLite database file
        $db_file = 'modular.db';

        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //return all passengers, and store the result set
            $query_str = "select * from category;";
            $result_set = $db->query($query_str);
            //loop through each tuple in result set and print out the data
            //ssn will be shown in blue (see below)
            foreach($result_set as $tuple) {
                 echo "<font color='blue'>$tuple[category_id]</font> $tuple[category_name] $tuple[category_description] <br/>\n";
            }

            //disconnect from db
            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
        */
  ?>

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
      <p>Rating:</p>
      <input id="input-id" type="text" class="rating" data-size="sm" style="showCaption: false">
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
    </div>
    <div class="col-sm-1 sidenav">   
    </div>
  </div>

</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>

</body>
</html>