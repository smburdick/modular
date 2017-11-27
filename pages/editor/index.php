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

                    $color_stmt = $db->prepare('SELECT * FROM Color;');
                    $color_stmt->execute();
                    $colors = array($color_stmt->fetchAll())[0];

                    $obj_file = $model["object_file"];
                    $model_name = $model["model_name"];
                    $model_color = $model["color_hex"];
                    $model_mass = $model["mass_in_grams"];
                    $model_mat = $model["material_id"];

                } else {
                    echo 'You don\'t have permission to edit this page.<br><br>';
                    echo '<a href="../index.php"><button>Return to homepage</button></a>';
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

            const GOLD_ID = 0, SILVER_ID = 1, PLASTIC_ID = 2;

            var goldMaterial = new THREE.MeshPhongMaterial({
                shininess: 100,
                reflectivity: 100
            });

            var silverMaterial = new THREE.MeshPhongMaterial({
                shininess: 50,
                reflectivity: 50
            });

            var plasticMaterial = new THREE.MeshPhongMaterial({
                shininess: 0,
                reflectivity: 0
            });

       //     var displayColor, displayMat;

            var object, model;

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

                //console.log("Obj file: " + obj_file)
                var loader = new THREE.OBJLoader2();
                object = loader.parse(obj_file);
                //object.children[0].material = bodyMaterial
                object.scale.set(SCALE_FACTOR, SCALE_FACTOR, SCALE_FACTOR); // this is necessary for making the object be actually visible.

                model = object.children[0];   // the actual model object is a child object of the created object.

                scene.add(object);
            }

            function updateMaterial(newMaterial) {

//                displayMat = newMaterial;
                // preserve color
                var currentColor = model.material.color;

                if (newMaterial == GOLD_ID) {
                    model.material = goldMaterial;
                } else if (newMaterial == SILVER_ID) {
                    model.material = silverMaterial;
                } else {
                    model.material = plasticMaterial;
                }

                model.material.color = currentColor;

            }

            function updateColor(newColor) {
                model.material.color = new THREE.Color(newColor);
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

            function updateDOMElements() {
                addToDOM();
                animate();                
            }

            function display(color, material) {
                try {
                    init();
                    fillScene();
                    updateColor(color);
                    updateMaterial(material);
                    updateDOMElements();
                } catch (error) {
                    console.log("Your program encountered an unrecoverable error, can not draw on canvas. Error was:");
                    console.log(error);
                }
            }

        </script>
    </div>

    <script>
        const initialMaterial = "<?php echo $model_mat; ?>";
        const initialColor = "<?php echo $model_color; ?>";
        display(initialColor, initialMaterial);
    </script>

    <center>
    <?php
        echo '<form action="update-model.php"><br>';
        echo '<input type="hidden" name="model_id" value="'. $model_id .'">';
        echo 'Name: <input type="text" name="model_name" value="' . $model_name . '"><br>';
        echo 'Mass: <input type="number" name="model_mass" min="1" max="2000" value="' . $model_mass . '"> g<br>'; // TODO decide on range of valid masses
        echo 'Material: <select onchange="updateMaterial(this.value); updateDOMElements();" id="material_select" name="model_material" value="' . $model_material . '">';
        foreach ($materials as $mat) {
            $selected = '';
            if ($mat["material_id"] == $model_mat) { // if provided material is the one in the list, make it the default one in the dropdown
                $selected = 'selected="selected"';
            }
            $mat_price = floatval($mat["cost_per_gram"]) / 100; // convert cents to dollars
            echo '<option ' . $selected . ' value="'. $mat["material_id"] . '">' . $mat["material_name"] . ': $'. $mat_price . '/g</option>';
        }
        echo '</select><br>';

        echo 'Color: <select onchange="updateColor(this.value); updateDOMElements();" id="color_select" name="model_color">';
        foreach ($colors as $color) {
            $selected = ''; // if this is the given value of the model, it will be the one in the dropdown.
            if (strcmp($color["hex"], $model_color) == 0) {
                $selected = 'selected="selected"';
            }
            echo '<option ' . $selected . ' value="' . $color["hex"] . '">' . $color["name"] .'</option>';
        }
        echo '</select><br><br>';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    ?>
    </center>

</body>
</html>
