	<?php
    error_reporting(0);
    $db_file = '../../db/modular.db';
    $user_id = $_COOKIE["user_id"];
    if(isset($user_id)){
      $review_title = $_POST["review_title"];
      $rating = $_POST["rating"];
      $review = $_POST["review"];
      $model_id = $_GET["id"];
      if($review_title == null || $review == null || $rating == null){
        header("Location: review_error.php?review_error=0");
        exit();
      }
      try {
        //open connection to the modular database file
        $db = new PDO('sqlite:' . $db_file);
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
      header("Location: review_error.php?review_error=3");
      exit();
    }
    ?>