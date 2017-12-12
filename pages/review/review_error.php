<!DOCTYPE html>
<html lang="en">
<?php
  include "../boilerplate.php";
  generate_head("Review Error", "search");
  error_reporting(0);
?>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav"></div>
    <div class="col-sm-10 text-center" style="margin-top: 30px">
      <?php
        $error_code = $_GET["review_error"];
        $model_id = $_GET["id"];
        if($error_code == 0){
          echo '<h3>Missing one or more fields in the review.</h3>';
        }
        else if($error_code == 1){
          echo '<h3>You must be logged in to write a review.</h3>
          <a href="../login/login.php" class="btn btn-info" role="button">Login</a>';
        }
        else if($error_code == 2){
          echo '<h3>You have already created a review for this product.</h3>';
        }
      ?>
    </div>
    <div class="col-sm-1 sidenav"></div>
  </div>
</div>


</body>
</html>