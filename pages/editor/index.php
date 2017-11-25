<!-- editor/index.php -->
<!-- Model editor view -->
<html>
  <head>
    <title>Editor</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <style type="text/css">
    </style>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="three.js/build/three.min.js"></script>
    <script src="js/Detector.js"></script>
    <script src="js/CanvasRenderer.js"></script>
    <script src="js/Projector.js"></script>
    <script src="js/OrbitControls.js"></script>
    <script src="js/dat.gui.min.js"></script>
    <script src="js/KeyboardState.js"></script>
    <script src="three.js/examples/js/loaders/LoaderSupport.js"></script>
    <script src="three.js/examples/js/loaders/OBJLoader2.js"></script>


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
      $db_file = '../../db/modular.db';
      $user_id = $_COOKIE["userID"];
      $model_id = $_GET["modelID"];
      
      if (isset($user_id)) {
        try {
          $db = new PDO('sqlite:'.$db_file);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $db->prepare('SELECT * FROM Model WHERE model_id = ?;');
          $stmt->bindParam(1, $model_id);
          $success = $stmt->execute();
          $result_set = $stmt->fetchAll(); // an array of results

          $obj_file = NULL;

          $model = $result_set[0]; // model data

          if (strcmp($model["user_id"], $user_id) == 0) { // model's userID matches logged-in userID
            $obj_file = $model["object_file"];
          } else {
            echo "<p>You don't have permission to edit this model.</p>"
          }

          // TODO we could get values based on the user id, however this would be insecure
          // as anyone could set their cookie to be the user id and edit someone else's model
          // but for our purposes this should be fine
          // in real world code we'd have an extra layer of verification--could hold a password as the cookie, and use this as verification.
          if ($success) {
            
            
          } else {
            // TODO this really shouldn't happen?
          }

          $db = null;


        } catch (PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
      }
      
        //$obj_file = 123;
    ?>
    <div id="canvas" style="width:600px; margin: 0 auto;">

       <script>
            /*global THREE, Coordinates, document, window  */
            var camera, scene, renderer;
            var cameraControls;

            var obj_file;

            var clock = new THREE.Clock();

            function fillScene() {
                scene = new THREE.Scene();
                //scene.fog = new THREE.Fog( 0x808080, 2000, 4000 );

                // LIGHTS

                scene.add( new THREE.AmbientLight( 0x222222 ) );

                var light = new THREE.DirectionalLight( 0xffffff, 0.7 );
                light.position.set( 200, 500, 500 );

                scene.add( light );

                light = new THREE.DirectionalLight( 0xffffff, 0.9 );
                light.position.set( -200, -100, -400 );

                scene.add( light );

            //grid xz
             var gridXZ = new THREE.GridHelper(2000, 100, new THREE.Color(0xCCCCCC), new THREE.Color(0x888888));
             scene.add(gridXZ);

             //axes
             var axes = new THREE.AxisHelper(150);
             axes.position.y = 1;
             scene.add(axes);
           //  var obj_file =; // a string representation of the file
             let obj_file = `
                # cube.obj
                #
                 
                g cube
                 
                v  0.0  0.0  0.0
                v  0.0  0.0  1.0
                v  0.0  1.0  0.0
                v  0.0  1.0  1.0
                v  1.0  0.0  0.0
                v  1.0  0.0  1.0
                v  1.0  1.0  0.0
                v  1.0  1.0  1.0

                vn  0.0  0.0  1.0
                vn  0.0  0.0 -1.0
                vn  0.0  1.0  0.0
                vn  0.0 -1.0  0.0
                vn  1.0  0.0  0.0
                vn -1.0  0.0  0.0
                 
                f  1//2  7//2  5//2
                f  1//2  3//2  7//2 
                f  1//6  4//6  3//6 
                f  1//6  2//6  4//6 
                f  3//3  8//3  7//3 
                f  3//3  4//3  8//3 
                f  5//5  7//5  8//5 
                f  5//5  8//5  6//5 
                f  1//4  5//4  6//4 
                f  1//4  6//4  2//4 
                f  2//1  6//1  8//1 
                f  2//1  8//1  4//1 
             `;

             var loader = new THREE.OBJLoader2();
             var object = loader.parse(obj_file);
             var bodyMaterial = new THREE.MeshLambertMaterial();
                bodyMaterial.color.setRGB( 1,1,1);
            object.children[0].material = bodyMaterial
            object.scale.set(100,100,100)
            console.log(object)
             // TODO apply color, material
             scene.add(object);
            }

            function init() {
                var canvasWidth = 600;
                var canvasHeight = 400;
                var canvasRatio = canvasWidth / canvasHeight;

                // RENDERER
                renderer = new THREE.WebGLRenderer( { antialias: true } );

                renderer.gammaInput = true;
                renderer.gammaOutput = true;
                renderer.setSize(canvasWidth, canvasHeight);
                renderer.setClearColor( 0xAAAAAA, 1.0 );

                // CAMERA
                camera = new THREE.PerspectiveCamera( 45, canvasRatio, 1, 7000 );
                // CONTROLS
                cameraControls = new THREE.OrbitControls(camera, renderer.domElement);
                camera.position.set( -400, 1500, -2500);
                cameraControls.target.set(4,301,92);
            }

            function addToDOM() {
                var canvas = document.getElementById('canvas');
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
            obj_file = "<?php echo $obj_file ?>"
              init();
              fillScene();
              addToDOM();
              animate();
            } catch(error) {
                console.log("Your program encountered an unrecoverable error, can not draw on canvas. Error was:");
                console.log(error);
            }

       </script>
    </div>
</body>
</html>
