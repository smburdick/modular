<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<html>
<?php
include "../boilerplate.php";
generate_head("Search Results", "search");
?>

<body style="height: 100%">
<div class="container-fluid text-center" style="overflow: hidden; height: auto">    
  <div class="row content" style="height: 100px">
    <div class="col-sm-1 sidenav" style="margin-bottom: -99999px; padding-bottom: 99999px"></div>
    <div class="col-sm-10 text-left" style="margin-top: 10px; overflow: hidden;"> 
      <h3>Search Results</h3>
      <p>Search By</p>
    </div>
    <div class="col-sm-1 sidenav" style="margin-bottom: -99999px; padding-bottom: 99999px; overflow: hidden"></div>
  </div>
  <div class="row content" style="height: 100%">
    <div class="col-sm-1 sidenav" style="margin-bottom: -99999px; padding-bottom: 99999px; overflow: hidden">
    </div>
    <div class="col-sm-10 text-left">
      <ul class="nav nav-tabs">
      <?php 
        $search_by = $_GET['link'];
        $term = $_GET['srch-term'];
        $s1 = "";
        $s2 = "";
        $s3 = "";
        $s4 = "";
        $s6 = "";
        if($search_by == category){
          $s1 = "class=\"active\"";
        }
        else if($search_by == all || $search_by == ""){
          $s6 = "class=\"active\"";
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
        echo "<li role=\"presentation \"" . $s6 . "><a href=\"search_results.php?link=all&srch-term=" . $term . "\">All</a></li>";
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
      $search_array = preg_split("[ ]", $search_terms);
      //create expression for select query
      $i = 0;
      $search_like = array();
      foreach($search_array as $value){
        $value = "%" . $value . "%";
        $search_like[] = $value;
      }
      try {
          //open connection to the modular database file
          $db = new PDO('sqlite:' . $db_file);
          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //store the rating in the datbase, keep user on the review page
          $date = date('Y-m-d H:i', strtotime('now'));
          //SEARCH MODEL BY CATEGORY (DEFAULT)
          $count = count($search_like) - 1;
          $i = 0;
          //SEARCH MODEL BY CATEGORY
          if($search_by == category){
            foreach($search_like as $value){
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR category_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Category WHERE category_name LIKE " . $like_string . " COLLATE NOCASE;";
            $result = $db->query($search_query);
            $new_results;
            echo "<div class=\"card-deck\">";
            foreach($result as $tuple) {
              $query = "SELECT Model.model_id, Model.model_name, Model.image, category_id, category_name FROM Model NATURAL JOIN (BelongsTo NATURAL JOIN Category) WHERE category_id == " . $tuple[category_id];
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
                    <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
                    <?php
                      $image = $tuple[2];
                      $modname = $tuple[1];
                      $modid = $tuple[0];
	                    echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                      echo "<h4 class=\"card-title\">$modname</h4>";
                      echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";
                      echo "</div>";
                      echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[category_name]</small></div>";
                      ?>
                </div>
                <?php
              }
            }
            echo "</div>";
          }
          //SEARCH MODEL BY COLOR
    		  else if($search_by == color){
    			  foreach($search_like as $value){
    			    if($i == $count){
    			      $like_string .= "'".$value."'";
    			    }
    			    else{
    			      $like_string .= "'".$value."' OR name LIKE ";   
    			    }
    			    $i++;
    			  }
    			  $search_query = "SELECT * FROM Color WHERE name LIKE " . $like_string . " COLLATE NOCASE;";
    			  $result = $db->query($search_query);
    			  $new_results;
    			  echo "<div class=\"card-deck\">";
    			  foreach($result as $tuple) {
    			    $query = "SELECT Model.model_id, Model.model_name, Model.image, name FROM Color NATURAL JOIN Model WHERE name == '" . $tuple[name] . "';";
    			    $new_results = $db->query($query);
    			    foreach($new_results as $tuple) {
    			      ?>
    			        <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
    			        <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
    			          <?php
                          $image = $tuple[2];
                          $modname = $tuple[1];
                          $modid = $tuple[0];
    	                  echo '<img class="card-img-top" src="'.$image.'" alt="no image">
    	                    <div class="card-body">';
                          echo "<h4 class=\"card-title\">$modname</h4>";
                          echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";
    			            ?>
    			        </div>
    			      <?php
    			      echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[name]</small></div>";
    			      echo "</div>";
    			    }
    			  }
    			  echo "</div>";
    		  }
          //SEARCH MODEL BY MATERIAL
          else if($search_by == material){
            foreach($search_like as $value){
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR material_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM Material WHERE material_name LIKE " . $like_string . " COLLATE NOCASE;";
            //echo "<p>".$search_query."</p>";
            $result = $db->query($search_query);
            $new_results;
            echo "<div class=\"card-deck\">";
            foreach($result as $tuple) {
              $query = "SELECT Model.model_id, Model.model_name, Model.image, material_name FROM Material NATURAL JOIN Model WHERE material_name == '" . $tuple[material_name] . "';";
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
                    <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
                    <?php
                      $image = $tuple[2];
                      $modname = $tuple[1];
                      $modid = $tuple[0];
	                  echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                      echo "<h4 class=\"card-title\">$modname</h4>";
                      echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";
                      ?>
                  </div>
                
                <?php
                echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[material_name]</small></div>";
                echo "</div>";
              }
            }
            echo "</div>";
          }
          //SEARCH MODEL BY USERNAME
          else if($search_by == user){
            foreach($search_like as $value){
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR username LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT * FROM User WHERE username LIKE " . $like_string . " COLLATE NOCASE;";
            $result = $db->query($search_query);
            $new_results;
            ?>
          <div class="card-deck">
            <?php
            foreach($result as $tuple) {
              $query = "SELECT Model.model_id, Model.model_name, Model.image, username FROM User INNER JOIN Model ON User.user_id = Model.creator_id WHERE username == '" . $tuple[username] . "';";
              $new_results = $db->query($query);
              foreach($new_results as $tuple) {
                ?>
                  <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
                    <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
                    <?php
                      $image = $tuple[2];
                      $modname = $tuple[1];
                      $modid = $tuple[0];
	                  echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                      echo "<h4 class=\"card-title\">$modname</h4>";
                      echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";

                      ?>
                  </div>
                
                <?php
                echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[username]</small></div>";
                echo "</div>";
              }
            }
            echo "</div>";
          }
          //SEARCH MODEL BY ALL ATTRIBUTES GIVEN
          //making query strings for each category
          else if($search_by == all  || $search_by == ""){
            foreach($search_like as $value){
              if($i == $count){
                $like_string1 .= "'".$value."'";
              }
              else{
                $like_string1 .= "'".$value."' OR name LIKE ";   
              }
              $i++;
            }
            $i = 0;
            foreach($search_like as $value){
              if($i == $count){
                $like_string2 .= "'".$value."'";
              }
              else{
                $like_string2 .= "'".$value."' OR model_name LIKE ";   
              }
              $i++;
            }
            $i = 0;
            foreach($search_like as $value){
              if($i == $count){
                $like_string3 .= "'".$value."'";
              }
              else{
                $like_string3 .= "'".$value."' OR material_name LIKE ";   
              }
              $i++;
            }
            $i = 0;
            foreach($search_like as $value){
              if($i == $count){
                $like_string4 .= "'".$value."'";
              }
              else{
                $like_string4 .= "'".$value."' OR category_name LIKE ";   
              }
              $i++;
            }
            $i = 0;
            foreach($search_like as $value){
              if($i == $count){
                $like_string5 .= "'".$value."'";
              }
              else{
                $like_string5 .= "'".$value."' OR username LIKE ";   
              }
              $i++;
            }
            //join all these tables so we can get all the data 
            $join_table = "Material NATURAL JOIN (Color NATURAL JOIN (Category NATURAL JOIN (BelongsTo NATURAL JOIN (User INNER JOIN Model ON User.user_id = Model.creator_id))))";
            $q1 = "SELECT Model.model_id, Model.model_name, Model.image, name, material_name, category_name, username FROM ".$join_table." WHERE name LIKE " . $like_string1 . " OR model_name LIKE " . $like_string2 . " OR material_name LIKE " . $like_string3 . " OR category_name LIKE " . $like_string4 . " OR username LIKE " . $like_string5 .  ";";
            //echo "<p>".$q1."</p>";

            //queries for each relation
            $query1 = "SELECT * FROM ".$join_table." WHERE name LIKE " . $like_string1;
            $query2 = "SELECT * FROM ".$join_table." WHERE model_name LIKE " . $like_string2;
            $query3 = "SELECT * FROM ".$join_table." WHERE material_name LIKE " . $like_string3;
            $query4 = "SELECT * FROM ".$join_table." WHERE category_name LIKE " . $like_string4;
            $query5 = "SELECT * FROM ".$join_table." WHERE username LIKE " . $like_string5;

            $color_match = $db->query($query1);
            $model_match = $db->query($query2);
            $material_match = $db->query($query3);
            $category_match = $db->query($query4);
            $user_match = $db->query($query5);

            $matched_models = array();
            $model_counts = array();

            foreach($color_match as $tuple){
              //if this model already exists in the array
              if(in_array($tuple[model_id], $matched_models)){
                //get the index of the model
                $key = array_search($tuple[model_id], $matched_models);
                //get the count of that model using the index and add 1
                $model_help = array_values($model_counts);
                $count = $model_help[$key] + 1;
                //update the array at the specified index
                array_splice($model_counts, $key, 1, $count);
              }
              //if it doesn't already exist in the array, insert into the array
              else{
                array_push($model_counts, 1);
                array_push($matched_models, $tuple[model_id]);
              }
            }
            foreach($model_match as $tuple){
              //if this model already exists in the array
              if(in_array($tuple[model_id], $matched_models)){
                //get the index of the model
                $key = array_search($tuple[model_id], $matched_models);
                //get the count of that model using the index and add 1
                $model_help = array_values($model_counts);
                $count = $model_help[$key] + 1;
                //update the array at the specified index
                array_splice($model_counts, $key, 1, $count);
              }
              //if it doesn't already exist in the array, insert into the array
              else{
                array_push($model_counts, 1);
                array_push($matched_models, $tuple[model_id]);
              }
            }
            foreach($material_match as $tuple){
              //if this model already exists in the array
              if(in_array($tuple[model_id], $matched_models)){
                //get the index of the model
                $key = array_search($tuple[model_id], $matched_models);
                //get the count of that model using the index and add 1
                $model_help = array_values($model_counts);
                $count = $model_help[$key] + 1;
                //update the array at the specified index
                array_splice($model_counts, $key, 1, $count);
              }
              //if it doesn't already exist in the array, insert into the array
              else{
                array_push($model_counts, 1);
                array_push($matched_models, $tuple[model_id]);
              }
            }
            foreach($category_match as $tuple){
              //if this model already exists in the array
              if(in_array($tuple[model_id], $matched_models)){
                //get the index of the model
                $key = array_search($tuple[model_id], $matched_models);
                //get the count of that model using the index and add 1
                $model_help = array_values($model_counts);
                $count = $model_help[$key] + 1;
                //update the array at the specified index
                array_splice($model_counts, $key, 1, $count);
              }
              //if it doesn't already exist in the array, insert into the array
              else{
                array_push($model_counts, 1);
                array_push($matched_models, $tuple[model_id]);
              }
            }
            foreach($user_match as $tuple){
              //if this model already exists in the array
              if(in_array($tuple[model_id], $matched_models)){
                //get the index of the model
                $key = array_search($tuple[model_id], $matched_models);
                //get the count of that model using the index and add 1
                $model_help = array_values($model_counts);
                $count = $model_help[$key] + 1;
                //update the array at the specified index
                array_splice($model_counts, $key, 1, $count);
              }
              //if it doesn't already exist in the array, insert into the array
              else{
                array_push($model_counts, 1);
                array_push($matched_models, $tuple[model_id]);
              }
            }
            /*
            echo "<p> model counts pre sort</p>";
            foreach($model_counts as $item) {
              echo $item;
            }
            echo "<p></p>";
            echo "<p> model ids pre sort</p>";
            foreach($matched_models as $item) {
              echo $item;
            }
            echo "<p></p>";
            */
            array_multisort($model_counts, SORT_DESC, $matched_models);
            /*
            echo "<p> model counts post sort</p>";
            foreach($model_counts as $item) {
              echo $item;
            }
            echo "<p></p>";
            echo "<p> model ids post sort</p>";
            foreach($matched_models as $item) {
              echo $item;
            }
            echo "<p></p>";
            echo "<p>" . $q1 . "</p>";
            */
            echo "<div class=\"card-deck\">";
            foreach($matched_models as $value){
              $result = $db->query("SELECT model_id, model_name, uploaded_date, image FROM Model WHERE model_id == ".$value.";");
              foreach($result as $tuple) {
                ?>
                  <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
                    <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
                    <?php
                      $image = $tuple[3];
                      $modname = $tuple[1];
                      $modid = $tuple[0];
	                  echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                      echo "<h4 class=\"card-title\">$modname</h4>";
                      echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";
                      echo "</div>";
                      echo "<div class=\"card-footer\"><small class=\"text-muted\">Modular 2017</small></div>";
                      ?>
                  </div>
                <?php
              }
            }
              echo "</div>";
          }

          //SEARCH MODEL BY MODEL NAME 
          if($search_by == model){
            foreach($search_like as $value){
              if($i == $count){
                $like_string .= "'".$value."'";
              }
              else{
                $like_string .= "'".$value."' OR model_name LIKE ";   
              }
              $i++;
            }
            $search_query = "SELECT model_id, model_name, uploaded_date, image FROM Model WHERE model_name LIKE " . $like_string . " COLLATE NOCASE;";
            $result = $db->query($search_query);
            echo "<div class=\"card-deck\">";
              foreach($result as $tuple) {
                ?>
                  <div class="card" align="center" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
                    <div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
                    <?php
                      $image = $tuple[image];
                      $modname = $tuple[model_name];
	                  echo '<img class="card-img-top" src="'.$image.'" alt="no image">
	                    <div class="card-body">';
                      echo "<h4 class=\"card-title\">$modname</h4>";
                      echo "<a href=\"../product/product.php?id=$modid\" class=\"card-link\">View Model</a>";
                      echo "</div>";
                      echo "<div class=\"card-footer\"><small class=\"text-muted\">Modular 2017</small></div>";
                      ?>
                  </div>
                
                <?php
              }
              echo "</div>";
          }
            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
      ?>
    </div>
    
    </form>
    <div class="col-sm-1 sidenav" style="margin-bottom: -99999px; padding-bottom: 99999px">   
    </div>
  </div>

</div>




</body>
</html>