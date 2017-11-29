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
      <a class="navbar-brand" href="../../pages">Modular</a> <!-- TODO logo -->
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
  <div class="row content" style="height: 100px">
    <div class="col-sm-1 sidenav"></div>
    <div class="col-sm-10 text-left" style="margin-top: 10px"> 
      <h3>Search Results</h3>
      <p>Sort By</p>
    </div>
    <div class="col-sm-1 sidenav"></div>
  </div>
  <div class="row content">
    <div class="col-sm-1 sidenav">   
    </div>
    <div class="col-sm-10 text-left">
      <div class="card-deck">
  <div class="card">
    <img class="card-img-top" src="../review/homer.png" alt="Card image cap" style="height: 200px; width: 100%>
    <div class="card-body">
      <h4 class="card-title">Card title</h4>
      <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="../review/homer.png" alt="Card image cap" style="height: 200px; width: 100%>
    <div class="card-body">
      <h4 class="card-title">Card title</h4>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="../review/homer.png" alt="Card image cap" style="height: 200px; width: 100%">
    <div class="card-body">
      <h4 class="card-title">Card title</h4>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
</div>
      <ul class="nav nav-tabs">
      <?php 
        $search_by = $_GET['link'];
        $term = $_GET['srch-term'];
        $s1 = "";
        $s2 = "";
        $s3 = "";
        $s4 = "";
        if($search_by == category || $search_by == ""){
          $s1 = "class=\"active\"";
        }
        else if($search_by == color){
          $s2 = "class=\"active\"";
        }
        else if($search_by == material){
          $s3 = "class=\"active\"";
        }
        else if($search_by == user){
          $s4 = "class=\"active\"";
        }
        else if($search_by == model){
          $s5 = "class=\"active\"";
        }
        echo "<li role=\"presentation \"" . $s1 . "><a href=\"search_results.php?link=category&srch-term=" . $term . "\">Category</a></li>";
        echo "<li role=\"presentation \"" . $s2 . "><a href=\"search_results.php?link=color&srch-term=" . $term . "\">Color</a></li>";
        echo "<li role=\"presentation \"" . $s3 . "><a href=\"search_results.php?link=material&srch-term=" . $term . "\">Material</a></li>";
        echo "<li role=\"presentation \"" . $s4 . "><a href=\"search_results.php?link=user&srch-term=" . $term . "\">User</a></li>";
        echo "<li role=\"presentation \"" . $s5 . "><a href=\"search_results.php?link=model&srch-term=" . $term . "\">Model Name</a></li>";
      ?>
      </ul>
    <?php
      $search_by = $_GET['link'];
      $db_file = '../../db/modular.db';
      $search_terms = $_GET['srch-term'];
      echo "<p>results for \"" . $search_terms . "\"</p>";
      //global $search_array;
      $search_array = preg_split("[ ]", $search_terms);
      //$search_array[0] = "%" . $search_array[0] . "%";
      //echo "<p>" . $search_array[0] . " count: " . count($search_array) . "</p>";
      //create expression for select query
      $i = 0;
      $search_like = array();
      foreach($search_array as $value){
        $value = "%" . $value . "%";
        //print $value."\n";
        //$search_array[] = $value;
        $search_like[] = $value;
        //print $search_array[i]."\n";
        //$i++;
      }
      //echo "<p> value " . $value . "</p>";
      //echo "<p> search 0 " . $search_array[0] . "</p>";
      //echo "<p> search 1 " . $search_array[1] . "</p>";
      //echo "<p> search_like 0 " . $search_like[0] . "</p>";
      //echo "<p> search_like 1 " . $search_like[1] . "</p>";
      //print_r($search_array);
      //$user_id = $_COOKIE["userID"];
      //$model_id = $_GET["model_ID"];
      //$review = $_POST["review"];
      //$rating = $_POST["rating"];
      //$review_title = $_POST["review_title"];
      try {

          //open connection to the modular database file
          $db = new PDO('sqlite:' . $db_file);

          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //store the rating in the datbase, keep user on the review page
          $date = date('Y-m-d H:i', strtotime('now'));
          //SEARCH MODEL BY CATEGORY (DEFAULT)
          //$like_string = "";
          $count = count($search_like) - 1;
          $i = 0;
          //SEARCH MODEL BY CATEGORY
          //echo "<p>" . $search_like[0] . "</p>";
          if($search_by == category || $search_by == ""){
            foreach($search_like as $value){
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR category_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Category WHERE category_name LIKE " . $like_string . ";";
            $result = $db->query($search_query);
            $new_results;
            foreach($result as $tuple) {
              $query = "SELECT * FROM BelongsTo NATURAL JOIN Model WHERE category_id == " . $tuple[category_id];
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" style="width: 60rem;">
                    <div class="card-body">
                      <?php
                      echo "<h4 class=\"card-title\">$tuple[model_name]</h4>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[username]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[material_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[category_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[uploaded_date]</h6>";
                      //<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      echo "<a href=\"#\" class=\"card-link\">Card link</a>";
                      //<a href="#" class="card-link">Another link</a>
                      ?>
                    </div>
                  </div>
                <?php
              }
            }
          }
          //SEARCH MODEL BY COLOR
          else if($search_by == color){
            foreach($search_like as $value){
              //echo "<p>" . $value . "</p>";
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Color WHERE name LIKE " . $like_string . ";";
            //echo "<p>" . $search_query . "</p>";
            $result = $db->query($search_query);
            $new_results;
            foreach($result as $tuple) {
              $query = "SELECT * FROM Color NATURAL JOIN Model WHERE name == '" . $tuple[name] . "';";
              //echo "<p>" . $query . "</p>";
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" style="width: 60rem;">
                    <div class="card-body">
                      <?php
                      echo "<h4 class=\"card-title\">$tuple[model_name]</h4>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[username]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[material_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[category_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[uploaded_date]</h6>";
                      //<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      echo "<a href=\"#\" class=\"card-link\">Card link</a>";
                      //<a href="#" class="card-link">Another link</a>
                      ?>
                    </div>
                  </div>
                <?php
              }
            }
          }
          //SEARCH MODEL BY MATERIAL
          else if($search_by == material){
            foreach($search_like as $value){
              //echo "<p>" . $value . "</p>";
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR material_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Material WHERE material_name LIKE " . $like_string . ";";
            //echo "<p>" . $search_query . "</p>";
            $result = $db->query($search_query);
            $new_results;
            foreach($result as $tuple) {
              $query = "SELECT * FROM Material NATURAL JOIN Model WHERE material_name == '" . $tuple[material_name] . "';";
              //echo "<p>" . $query . "</p>";
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" style="width: 60rem;">
                    <div class="card-body">
                      <?php
                      echo "<h4 class=\"card-title\">$tuple[model_name]</h4>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[username]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[material_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[category_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[uploaded_date]</h6>";
                      //<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      echo "<a href=\"#\" class=\"card-link\">Card link</a>";
                      //<a href="#" class="card-link">Another link</a>
                      ?>
                    </div>
                  </div>
                <?php
              }
            }
          }
          //SEARCH MODEL BY USERNAME
          else if($search_by == user){
            foreach($search_like as $value){
              //echo "<p>" . $value . "</p>";
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR username LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM User WHERE username LIKE " . $like_string . ";";
            //echo "<p>" . $search_query . "</p>";
            $result = $db->query($search_query);
            $new_results;
            foreach($result as $tuple) {
              $query = "SELECT * FROM User INNER JOIN Model ON User.user_id = Model.creator_id WHERE username == '" . $tuple[username] . "';";
              //echo "<p>" . $query . "</p>";
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" style="width: 60rem;">
                    <div class="card-body">
                      <?php
                      echo "<h4 class=\"card-title\">$tuple[model_name]</h4>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[username]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[material_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[category_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[uploaded_date]</h6>";
                      //<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      echo "<a href=\"#\" class=\"card-link\">Card link</a>";
                      //<a href="#" class="card-link">Another link</a>
                      ?>
                    </div>
                  </div>
                <?php
              }
            }
          }
          //SEARCH MODEL BY MODEL NAME 
          echo "<p>" . $search_by . "</p>";
          if($search_by == model){
            echo "<p>" . $search_by . "</p>";
            foreach($search_like as $value){
              //echo "<p>" . $value . "</p>";
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR model_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Model WHERE model_name LIKE " . $like_string . ";";
            echo "<p>" . $search_query . "</p>";
            $result = $db->query($search_query);
              foreach($result as $tuple) {
                ?>
                  <div class="card" style="width: 60rem;">
                    <div class="card-body">
                      <?php
                      echo "<h4 class=\"card-title\">$tuple[model_name]</h4>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[username]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[material_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[category_name]</h6>";
                      echo "<h6 class=\"card-subtitle mb-2 text-muted\">$tuple[uploaded_date]</h6>";
                      //<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      echo "<a href=\"#\" class=\"card-link\">Card link</a>";
                      //<a href="#" class="card-link">Another link</a>
                      ?>
                    </div>
                  </div>
                <?php
              }
            }
          
          //also want to include color and material as search criteria
          //$stmt = $db->prepare($search_query);
          // Bind parameters to statement variables
          /*$stmt->bindParam(':userid', $user_id);
          $stmt->bindParam(':modelid', $model_id);
          $stmt->bindParam(':reviewdate', $date);
          $stmt->bindParam(':reviewtitle', $review_title);
          $stmt->bindParam(':comment', $review);
          $stmt->bindParam(':stars', $rating);
    
          //echo "<p> stmt: " . $stmt . "</p>";*/
          
          //$result = $stmt->execute();
          //echo "<p>" . $result . " eyyyyy </p>";

         
          /*foreach($result as $tuple) {
            $query = "SELECT * FROM BelongsTo NATURAL JOIN Model WHERE category_id == " . $tuple[category_id];
            $new_results[] = $db->query($query);
          }*/
          
            //disconnect from db
            $db = null;

        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
      ?>
    </div>
    
    </form>
    <div class="col-sm-1 sidenav">   
    </div>
  </div>

</div>

<footer class="container-fluid text-center">
  <p align="left">2017 Modular</p>
</footer>



</body>
</html>