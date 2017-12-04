<HTML>
  <body>
	<?php
    $db_file = '../../db/modular.db';
    ////testing only/////
    $user_id = $_COOKIE["user_id"];
    //$_GET["model_ID"] = mt_rand();
    if(isset($user_id)){
      $review = $_POST["review"];
      $rating = $_POST["rating"];
      $review_title = $_POST["review_title"];
      $model_id = $_GET["id"];
      try {
        //open connection to the modular database file
        $db = new PDO('sqlite:' . $db_file);
        echo '<p> testing 123 </p>';
        echo '<p> ' . $review_title . '</p>';
        //set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //store the rating in the datbase, keep user on the review page
        $date = date('Y-m-d H:i', strtotime('now'));
        $test_query2 = "INSERT INTO Review(user_id, model_id, review_date, review_title, comment, stars) VALUES (:userid, :modelid, :reviewdate, :reviewtitle, :comment, :stars);";
        $stmt = $db->prepare($test_query2);
        // Bind parameters to statement variables
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':modelid', $model_id);
        $stmt->bindParam(':reviewdate', $date);
        $stmt->bindParam(':reviewtitle', $review_title);
        $stmt->bindParam(':comment', $review);
        $stmt->bindParam(':stars', $rating);
        //echo "<p> stmt: " . $stmt . "</p>";
        //$db->query($query_str);
        $stmt->execute();
        //disconnect from db
        $db = null;
      }
      catch(PDOException $e) {
          die('Exception : '.$e->getMessage());
      }
      header("Location: ../product/product.php?id=".$model_id);
      exit();
    }
    else{
      header("Location: review_error.php");
      //echo "<p>You must be logged in to write a review</p>";
      exit();
    }
    ?>

  </body>
</HTML>