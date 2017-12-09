<!DOCTYPE html>
<html lang="en">

<!-- editor/index.php -->
<!-- Model editor view -->

<?php
    include '../boilerplate.php';
    generate_head('Editor', '');
?>

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
<script src="js/OBJLoader.js"></script>
<body>
<div class="container-fluid text-center"> 
    <div class="row content">

        <div class="col-sm-2 sidenav">
        </div>

        <div class="col-sm-8 text-left"> <br><br>
        <?php

            $db_file  = '../../db/modular.db';
            $user_id  = $_COOKIE["user_id"];
            $model_id = $_GET["modelID"];
            if (isset($user_id)) {
                try {
                    $db = new PDO('sqlite:' . $db_file);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $stmt = $db->prepare('SELECT * FROM Model WHERE model_id = ?;');
                    $stmt->bindParam(1, $model_id);
                    $success    = $stmt->execute();
                    $result_set = $stmt->fetchAll(); // an array of results
                                    
                    $model = $result_set[0];
                    $editable = true;
                    
                    if ($model["creator_id"] == $user_id) { // model's userID matches logged-in userID
                       
                        $mat_stmt = $db->prepare('SELECT * FROM Material;');
                        $mat_stmt->execute();
                        $materials = array($mat_stmt->fetchAll())[0];

                        $color_stmt = $db->prepare('SELECT * FROM Color;');
                        $color_stmt->execute();
                        $colors = array($color_stmt->fetchAll())[0];

                        $cat_stmt = $db->prepare('SELECT category_id, category_name FROM Category;');
                        $cat_stmt->execute();
                        $categories = $cat_stmt->fetchAll();

                        $obj_file = $model["object_file"];
                        $model_name = $model["model_name"];
                        $model_color = $model["color_hex"];
                        $model_mass = $model["mass_in_grams"];
                        $model_mat = $model["material_id"];
                        $model_descr = $model["description"];
                        $image = $model["image"];

                        echo '<div id="canvas"></div>';


                    } else {
                        echo 'You don\'t have permission to edit this model.<br><br>';
                        $editable = false;
                    }

                    $db = NULL;
                    
                    
                }
                catch (PDOException $e) {
                    die('Exception : ' . $e->getMessage());
                }
            }
        ?>
            <script>
                /*global THREE, Coordinates, document, window  */
                var camera, scene, renderer;
                var cameraControls;

                var obj_file;

                var scaleFactor = 100;

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

                var glassMaterial = new THREE.MeshPhongMaterial({
                    transparent: true,
                    shininess: 100,
                    reflectivity: 60,
                    opacity: 0.55
                });

                const materialMap = {
                    0: goldMaterial,
                    1: silverMaterial,
                    2: plasticMaterial,
                    3: glassMaterial
                }

                const MAX_SCALE_FACTOR = 2000;

                var object;

                var image;

                var currentColor, currentMaterial;

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
                    //scene.add(gridXZ);

                    //axes
                    var axes = new THREE.AxisHelper(150);
                    axes.position.y = 1;
                    //scene.add(axes);

                    var obj_file = `<?php echo $obj_file; ?>`; // a string representation of the file

                    var loader = new THREE.OBJLoader();
                    object = loader.parse(obj_file);

                    scaleFactor = "<?php echo $model_mass;?>"; // mass indicates display size
                    rescale(scaleFactor);
                    object.position.y = 300;

                    scene.add(object);
                }

                function updateMaterial(newMaterial) {
                    currentMaterial = materialMap[newMaterial];
                }

                function updateColor(newColor) {
                    currentColor = new THREE.Color(newColor);
                }

                function init() {
                    var canvasWidth = 600;
                    var canvasHeight = 400;
                    var canvasRatio = canvasWidth / canvasHeight;
                    renderer = new THREE.WebGLRenderer({
                        antialias: true,
                        preserveDrawingBuffer: true
                    });
                    renderer.gammaInput = true;
                    renderer.gammaOutput = true;
                    renderer.setSize(canvasWidth, canvasHeight);
                    renderer.setClearColor(0xAAAAAA, 1.0);
                    camera = new THREE.PerspectiveCamera(45, canvasRatio, 1, 7000);
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

                function rescale(newScaleFactor) {
                    if (newScaleFactor <= MAX_SCALE_FACTOR) {
                        object.scale.set(newScaleFactor, newScaleFactor, newScaleFactor);
                    }
                }

                function updateDOMElements() {
                    for (child of object.children) {
                        child.material = currentMaterial;
                        child.material.color = currentColor;
                    }
                    addToDOM();
                    animate();                
                }

                function takeScreenshot() {
                    var screenshot = renderer.domElement.toDataURL("image/png");
                    return screenshot;
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

        <script>
            const initialMaterial = "<?php echo $model_mat; ?>";
            const initialColor = "<?php echo $model_color; ?>";
            display(initialColor, initialMaterial);
        </script>

        <?php
        if ($editable) {
            echo '<form action="update-model.php" method="post">';
            echo '<input type="hidden" name="model_id" value="'. $model_id .'">';
            echo '<input type="hidden" name="image" id="image" value=""><br>';
            echo '<button type="button" id="shutter"><img height="50px" width="50px" src="img/camera.png" ></button>'; // button must be of type button to make it not submit
            echo '<div>Your screenshot: </div><img id="screenshot" width="15%" height="25%" src="' . $image . '"><br><br>';
            echo 'Name: <input type="text" name="model_name" value="' . $model_name . '"><br>';
            echo 'Mass: <input type="number" name="model_mass" min="1" max="2000" onchange="rescale(this.value);" value="' . $model_mass . '"> g<br>';
            echo 'Material: <select onchange="updateMaterial(this.value); updateDOMElements();" id="material_select" name="model_material" value="' . $model_mat . '">';
            foreach ($materials as $mat) {
                $selected = '';
                if ($mat["material_id"] == $model_mat) { // if provided material is the one in the list, make it the default one in the dropdown
                    $selected = 'selected="selected"';
                }
                $mat_price = floatval($mat["cost_per_gram"]) / 100; // convert cents to dollars
                echo '<option ' . $selected . ' value="'. $mat["material_id"] . '">' . $mat["material_name"] . ': $'. sprintf("%.2f", $mat_price). '/g</option>';
            }
            echo '</select><br>';

            echo 'Color: <select onchange="updateColor(this.value); updateDOMElements(); takeScreenshot()" id="color_select" name="model_color">';
            foreach ($colors as $color) {
                $selected = ''; // if this is the given value of the model, it will be the one in the dropdown.
                if (strcmp($color["hex"], $model_color) == 0) {
                    $selected = 'selected="selected"';
                }
                echo '<option ' . $selected . ' value="' . $color["hex"] . '">' . $color["name"] .'</option>';
            }
            echo '</select><br>';
            
            echo 'Add to a category: <select name="model_category">';
            foreach ($categories as $category) {
                $cat_name = $category["category_name"];
                $cat_id = $category["category_id"];
                echo '<option value="' . $cat_id . '">' . $cat_name . '</option>';
            }
            echo '</select><br>';

            echo 'Description: <input type="text" name="model_descr" value="' . $model_descr . '""><br><br>';
            echo '<input type="submit" value="Submit" id="submit" id="submitButton">';
            echo '</form>';
            echo '</div>';
        }
        ?>

    <script>
        // callback to add screenshot to display and image submission
        $('#shutter').click(function() {
            var screenshot = takeScreenshot();
            $('#image').val(screenshot);
            $('#screenshot').attr("src", screenshot);
        });
    </script>

    </div>

        <div class="col-sm-2 sidenav">
        </div>

    </div>
    </div>
</body>
</html>
