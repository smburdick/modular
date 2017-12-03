<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<html>
<?php
include "../boilerplate.php";
generate_head("Search Results", "search");
?>
<script src="../css/stars/js/star-rating.js" type="text/javascript"></script>
<link href="../css/stars/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
<body style="height: 100%">
<div class="container-fluid text-center" style=" height: auto; overflow: hidden">
  <div class="row content" style="min-width: 761px; height: auto">
    <div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">
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
    <div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">
    
    </div>
  </div>
  <div class="row content" style="height: auto; overflow: hidden">
    <div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">   
    </div>
    <div class="col-sm-10 text-left">
      <h2>Review</h2>
      <input type="text" name="review" placeholder="What did you think of this product?" style="width:100%; height:100px">
      <input  type="submit" value="Submit">
    </div>
    
    </form>
    <!--TODO: use (now working) database connection to pull variables out into HTML-->
    <div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">   
    </div>
  </div>

</div>





</body>
</html>
