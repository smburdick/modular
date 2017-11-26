<?php
    /**
     * Updates the model data with the given parameters.
     */

    $db_file  = '../../db/modular.db';
    $user_id  = $_COOKIE["userID"];
    $model_id = $_GET["model_id"];
    $material_id = $_GET["model_material"];
    $mass = $_GET["model_mass"];
    $color = $_GET["model_color"];
    $name = $_GET["model_name"];

    if (isset($user_id)) {
        try {
            $db = new PDO('sqlite:' . $db_file);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $db->prepare('SELECT * FROM Model WHERE model_id = ?;');
            $stmt->bindParam(1, $model_id);
            $success    = $stmt->execute();
            $result_set = $stmt->fetchAll(); // an array of results
                        
            $model = $result_set[0];
            
            if ($model["creator_id"] == $user_id) { // model's userID matches logged-in userID
                $stmt = $db->prepare('UPDATE Model SET material_id = ?, mass_in_grams = ?, color = ?, name = ? WHERE model_id = ?;');
                $stmt->bindParam(1, $material_id);
                $stmt->bindParam(2, $mass);
                $stmt->bindParam(3, $color);
                $stmt->bindParam(4, $name);
                $stmt->bindParam(5, $model_id);
                $executed = $stmt->execute();
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
<br><br>
<form action="../index.php">
    <input type="submit" value="Return to homepage">
</form>