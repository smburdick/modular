<!DOCTYPE html>
<html lang="en">

<!-- editor/index.php -->
<!-- Model editor view -->

<?php
    include '../boilerplate.php';
    generate_head('Editor', '');
?>
<body>
<div class="container-fluid text-center"> 
    <div class="row content">

        <div class="col-sm-2 sidenav">
        </div>

        <div class="col-sm-8 text-left"> <br><br>
<?php
    /**
     * Updates the model data with the given parameters.
     */

    $db_file  = '../../db/modular.db';
    $user_id  = $_COOKIE["user_id"];
    $model_id = $_POST["model_id"];
    $material_id = $_POST["model_material"];
    $mass = $_POST["model_mass"];
    $color = $_POST["model_color"];
    $name = $_POST["model_name"];
    $image = $_POST["image"];
    $description = $_POST["model_descr"];

    $category_id = $_POST["model_category"];

    if (isset($user_id)) {
        try {
            $db = new PDO('sqlite:' . $db_file);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $db->prepare('SELECT creator_id FROM Model WHERE model_id = ?;');
            $stmt->bindParam(1, $model_id);
            $success    = $stmt->execute();
            $result_set = $stmt->fetchAll();
                        
            $model = $result_set[0];
            
            if ($model["creator_id"] == $user_id) { // model's userID matches logged-in userID
                $stmt = $db->prepare('UPDATE Model SET material_id = ?, mass_in_grams = ?, color_hex = ?, model_name = ?, description = ?, image = ? WHERE model_id = ?;');
                $stmt->bindParam(1, $material_id);
                $stmt->bindParam(2, $mass);
                $stmt->bindParam(3, $color);
                $stmt->bindParam(4, $name);
                $stmt->bindParam(5, $description);
                $stmt->bindParam(6, $image);
                $stmt->bindParam(7, $model_id);

                $executed = $stmt->execute();

                // make sure this model isn't in the category
                $stmt = $db->prepare('SELECT model_id FROM BelongsTo WHERE category_id = ? AND model_id = ?');
                $stmt->bindParam(1, $category_id);
                $stmt->bindParam(2, $model_id);
                $stmt->execute();
                if (sizeof($stmt->fetchAll()) == 0) { // if it hasn't already been added to that category, add it.
                    $stmt = $db->prepare('INSERT INTO BelongsTo VALUES (?, ?);');
                    $stmt->bindParam(1, $model_id);
                    $stmt->bindParam(2, $category_id);
                    $stmt->execute();
                }


                if ($executed) {
                    echo 'Model successfully updated.';
                } else {
                    echo 'There was a problem uploading to the database; please try again.';
                }
            } else {
                echo 'You don\'t have permission to edit this model.';
            }
            $db = NULL;
        }
        catch (PDOException $e) {
            die('Exception : ' . $e->getMessage());
        }
    } else {
        echo 'Please sign in to edit a model.';
    }
?>
</div>
        <div class="col-sm-2 sidenav">
        </div>
</div>
</div>
</body>
</html>