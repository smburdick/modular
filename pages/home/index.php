<!DOCTYPE html>
<html lang="en">
<?php
  include '../boilerplate.php';
  generate_head('Modular', '');
  //style="height: auto; overflow: hidden"
  error_reporting(0);
?>
<body>
	<div class="container-fluid text-center">
		<div class="row content">
    		<div class="col-sm-1 sidenav"></div>
    		<div class="col-sm-10 text-center"> 
    			<br><br><center><h1>Welcome to Modular</h1></center>
    		</div>
    		<div class="col-sm-1 sidenav"></div>
    	</div>
    	<div class="row content">
    		<div class="col-sm-1 sidenav"></div>
			<div class="col-sm-10" align="center">
			<h4> Featured Categories </h4>
	  <?php 
      $db_file = '../../db/modular.db';
      //$user_id = $_COOKIE["user_id"];
      //$model_id = $_GET["id"];

      //if(isset($user_id)){
        try {
          //open connection to the modular database file
          $db = new PDO('sqlite:' . $db_file);
          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//SEARCH MODEL BY CATEGORY
            $search_query = "SELECT * FROM Category;";//" WHERE category_name LIKE " . $like_string . " COLLATE NOCASE;";
            $result = $db->query($search_query);
            $new_results;
            echo "<div class=\"card-deck\" align=\"center\">";
            $i = 0;
            foreach($result as $tuple) {
            if($i < 3){
              $query = "SELECT Model.model_id, Model.model_name, Model.image, category_id, category_name FROM Model NATURAL JOIN (BelongsTo NATURAL JOIN Category) WHERE category_id == " . $tuple['category_id'];
	               $image = $tuple[2];
	               $modname = $tuple[1];
	               $modid = $tuple[0];
	               $catid = $tuple['category_id'];
              $new_results = $db->query($query);
              $j = 0;
              foreach($new_results as $tuple) {
              	if($j < 1){
                  echo '<div class="card" align="center" style="margin-bottom: 20px">';
                    
                    echo '<h3 a href="">'.$tuple['category_name'].'</h3>';
	               echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                   //echo "<h4 class=\"card-title\">$modname</h4>";
                   echo "<a href=\"../categories/selected_category.php?id=$catid\" class=\"card-link\">View Category</a>";
                   echo "</div>";
                   //echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[category_name]</small></div>";     
                   echo '</div>';
                   $j++;
                  }
            	}
            	$i++;	
              }
            }
            echo "</div>";
          
      	 }
         catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
         }
     //}
         $db = null;
         ?>
         </div>
    	 </div>
    	 <div class="col-sm-1 sidenav"></div>
    	</div>
    	    		<div class="col-sm-1 sidenav"></div>
    		<div class="col-sm-10 text-center"> 
    			<br><br><center><h1>Welcome to Modular</h1></center>
    		</div>
    		<div class="col-sm-1 sidenav"></div>
    </div>
	
</body>
</html>