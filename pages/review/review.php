<!DOCTYPE html>
<html>
<?php
include "../boilerplate.php";
generate_head("Review", "search");
$model_id = $_GET["id"];
error_reporting(0);
?>
<script src="../css/stars/js/star-rating.js" type="text/javascript"></script>
<link href="../css/stars/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
<body style="height: 100%">
<div class="container-fluid text-center" style=" height: auto; overflow: hidden">
  <div class="row content" style="min-width: 761px; height: auto">

    <?php 
      $db_file = '../../db/modular.db';
      $user_id = $_COOKIE["user_id"];
      $model_id = $_GET["id"];
      if(isset($_COOKIE["user_id"])){
        try {
          //open connection to the modular database file
          $db = new PDO('sqlite:' . $db_file);
          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $check_stmt = "select * from review where user_id=? and model_id=?";
	  $check_prep = $db->prepare($check_stmt);
	  $check_prep->bindParam(1, $user_id);
	  $check_prep->bindParam(2, $model_id);
	  $check_prep->execute();
	  $review_result = $check_prep->fetchAll(); 
	  if(sizeOf($review_result) != 0){ // if they already have a review
	    header("Location: review_error.php?review_error=2");
	  } else{
      echo '<div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">
      </div>
      <div class="col-sm-4 text-left" style="margin-top: 10px"> 
      <h3>Headline</h3>';
      echo '<form method="post" action="review_help.php?id='.$model_id.'">';
      echo '<input type="text" name="review_title" placeholder="What\'s most important to know?" style="width:100%">
      <h3>Rating</h3>
      <input name="rating" id="input-id" type="text" class="rating" data-size="xxs" style="showCaption: false">
      <script type = "text/javascript">$("#input-id").rating();</script>
      </div>
      <div class="col-sm-3 text-left" style="margin-top: 10px">';
	    $prod_query = "SELECT model_name, image FROM Model WHERE model_id=:id LIMIT 1;";
	    $prod_prep = $db->prepare($prod_query);
	    $prod_prep->bindParam(":id", $model_id);
	    $result = $prod_prep->execute();
	    $result = $prod_prep->fetchAll();
	    $image = $result[0][1];
	    echo '<img src="'.$image.'" style="max-width:100%"/>
	    </div>
	    <div class="col-sm-3 text-left" style="margin-top: 10px">';
	    echo "<h2>" . $result[0][0] . "</h2>";
	    echo "<p> </p>";
	    echo "<p>". $result[0][9] . "</p>";
      echo '</div>
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
      <div class="col-sm-1 sidenav" style="height: auto; overflow: hidden">
      </div>';
	  }
         }
         catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
         }
      }
    ?>

  </div>

</div>


</body>
</html>
