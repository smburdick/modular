<?php
    // testing zone
    $testUserID = 0; // Sam's test user ID
    setcookie("userID", $testUserID, time() + 86400); // 86400 = 1 day
    //$_COOKIE["userID"] = $testUserID; // necessary?
?>

<!-- editor/index.php -->
<!-- Model editor view -->

<html>
<head>
    <title>Editor</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/three.min.js"></script>
    <script src="js/Detector.js"></script>
    <script src="js/CanvasRenderer.js"></script>
    <script src="js/Projector.js"></script>
    <script src="js/OrbitControls.js"></script>
    <script src="js/dat.gui.min.js"></script>
    <script src="js/KeyboardState.js"></script>
    <script src="js/LoaderSupport.js"></script>
    <script src="js/OBJLoader2.js"></script>
    <h2>MODULAR</h2>
    <center><h1>Model Editor</h1>


</head>

<body>

    <?php
        /*
        TODO
            - Reposition editor view onto the side
            - editor options: dropdown,...
            - url should contain modelID. if the user doesn't have this model, page should read "Error: you don't have permission to edit this model"
            - otherwise, editor should load the model.
        */
        $db_file  = '../../db/modular.db';
        $user_id  = $_COOKIE["userID"];
        $model_id = $_GET["modelID"];
        if (isset($user_id)) {
            try {
                $db = new PDO('sqlite:' . $db_file);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $db->prepare('SELECT * FROM Model WHERE model_id = ?;');
                $stmt->bindParam(1, $model_id);
                $success    = $stmt->execute();
                $result_set = $stmt->fetchAll(); // an array of results
                
                $obj_file = NULL;
                
                $model = $result_set[0];
                
                if ($model["creator_id"] == $user_id) { // model's userID matches logged-in userID
                   
                    $mat_stmt = $db->prepare('SELECT * FROM Material;');
                    $mat_stmt->execute();
                    $materials = array($mat_stmt->fetchAll())[0];

                    $obj_file = $model["object_file"];
                    $model_name = $model["name"];
                    $model_color = $model["name"];
                    $model_mass = $model["mass_in_grams"];

                } else {
                    echo '<script type="text/javascript">
                        alert("You don\'t have permission to edit this model.")
                        </script>
                    ';
                    // TODO redirect to homepage.
                }
                // TODO we could get values based on the user id, however this would be insecure
                // as anyone could set their cookie to be the user id and edit someone else's model
                // but for our purposes this should be fine
                // in real world code we'd have an extra layer of verification--could hold a password as the cookie, and use this as verification.

                $db = NULL;
                
                
            }
            catch (PDOException $e) {
                die('Exception : ' . $e->getMessage());
            }
        }
    ?>
    <div id="canvas" style="width:600px; margin: 0 auto;">
        <script>
            /*global THREE, Coordinates, document, window  */
            var camera, scene, renderer;
            var cameraControls;

            var obj_file;

            const SCALE_FACTOR = 100;

            const GOLD_ID = 0, SILVER_ID = 1;

            var clock = new THREE.Clock();

            function fillScene() {
                scene = new THREE.Scene();

                scene.add(new THREE.AmbientLight(0x222222));

                var light = new THREE.DirectionalLight(0xffffff, 0.7);
                light.position.set(200, 500, 500);
                scene.add(light);

                light = new THREE.DirectionalLight(0xffffff, 0.9);
                light.position.set(-200, -100, -400);

                scene.add(light);

                var gridXZ = new THREE.GridHelper(2000, 100, new THREE.Color(0xCCCCCC), new THREE.Color(0x888888));
                scene.add(gridXZ);

                //axes
                var axes = new THREE.AxisHelper(150);
                axes.position.y = 1;
                scene.add(axes);

                var obj_file = "<?php echo $obj_file; ?>"; // a string representation of the file
                var material_number = "<?php echo $mat_num; ?>";

                //console.log("Obj file: " + obj_file)
                var loader = new THREE.OBJLoader2();
                var object = loader.parse(obj_file);
                var bodyMaterial = new THREE.MeshLambertMaterial();
                bodyMaterial.color.setRGB(1, 0,0);
                //object.children[0].material = bodyMaterial
                object.scale.set(SCALE_FACTOR, SCALE_FACTOR, SCALE_FACTOR); // this is necessary for making the object be actually visible.

                var model = object.children[0];   // the actual model object is a child object of the created object.

               // model.material = bodyMaterial;


                scene.add(object);
            }

            function init() {
                var canvasWidth = 600;
                var canvasHeight = 400;
                var canvasRatio = canvasWidth / canvasHeight;

                // RENDERER
                renderer = new THREE.WebGLRenderer({ antialias: true });

                renderer.gammaInput = true;
                renderer.gammaOutput = true;
                renderer.setSize(canvasWidth, canvasHeight);
                renderer.setClearColor(0xAAAAAA, 1.0);

                // CAMERA
                camera = new THREE.PerspectiveCamera(45, canvasRatio, 1, 7000);
                // CONTROLS
                cameraControls = new THREE.OrbitControls(camera, renderer.domElement);
                camera.position.set(-400, 1500, -2500);
                cameraControls.target.set(4, 301, 92);
            }

            function addToDOM() {
                var canvas = document.getElementById("canvas");
                canvas.appendChild(renderer.domElement);
            }

            function animate() {
                window.requestAnimationFrame(animate);
                render();
            }

            function render() {
                var delta = clock.getDelta();
                cameraControls.update(delta);

                renderer.render(scene, camera);
            }

            try {
                init();
                fillScene();
                addToDOM();
                animate();
            } catch (error) {
                console.log("Your program encountered an unrecoverable error, can not draw on canvas. Error was:");
                console.log(error);
            }

        </script>
    </div>
    <center>
    <?php
        echo '<form action="update-model.php"><br>';
        echo '<input type="hidden" name="model_id" value="'. $model_id .'">';
        echo 'Name: <input type="text" name="model_name" value="' . $model_name . '"><br>';
        echo 'Mass: <input type="number" name="model_mass" min="1" max="2000" value="' . $model_mass . '"> g<br>'; // TODO decide on range of valid masses
        echo 'Material: <select id="material_select" name="model_material" value="' . $model_material . '">';
        foreach ($materials as $mat) {
            $mat_price = floatval($mat["cost_per_gram"]) / 100; // convert cents to dollars
            echo '<option value="'. $mat["material_id"] . '">' . $mat["name"] . ': $'. $mat_price . '/g</option>';
        }
        echo '</select><br>';

        $colors = array(
            0 =>  array("name" => "white", "hex" => "#FFFFFF"),
            1 =>  array("name" => "red", "hex" => "#FFFFFF")

        );

        echo 'Color: <select id="color_select" name="model_color">';
        foreach ($colors as $color) {
            echo '<option value="' . $color["rgb"]. '">'. $color["name"] .'</option>';
        }
        echo '</select><br><br>';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    ?>
    </center>
    <!-- TODO jquery elements to update view. -->

    <script>
        // TODO update the editor view from here
    </script>

</body>
</html>