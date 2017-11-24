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
          // TODO populate the database with some toy data, and test on it
          $success = $stmt->execute();
          $result_set = $stmt->fetchAll(); // an array of results

          if($result_set["user_id"] == $user_id) { // TODO not sure how to do this in php

          } else {
            // sorry can't edit
          }

          $model = $result_set[0]; // model data

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
             var obj_file = "<?php echo $obj_file ?>"; // a string representation of the file
         /*    let obj_file = `
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
             `;*/

             var loader = new THREE.OBJLoader2();
             var object = loader.parse(obj_file);
             var bodyMaterial = new THREE.MeshLambertMaterial();
                bodyMaterial.color.setRGB( 1,1,1);
            object.children[0].material = bodyMaterial
            object.scale.set(100,100,100)
            console.log(object)
             // TODO apply color, material
             scene.add(object);
            // drawRobot();
            }

            // TODO this won't be called but may serve as a good example
            function drawRobot() {

                //////////////////////////////
                // MATERIALS

                var bodyMaterial = new THREE.MeshLambertMaterial();
                bodyMaterial.color.setRGB( 1,0,0);

                var cylinder;

                // MODELS

             //body
                cylinder = new THREE.Mesh(
                    new THREE.CylinderGeometry( 60, 60, 150, 32 ), bodyMaterial );
                cylinder.position.x = 0;
                cylinder.position.y = 320;
                cylinder.position.z = 0;
            //  scene.add( cylinder );

                var head = new THREE.Mesh(
                    new THREE.OctahedronGeometry(200,0), bodyMaterial);
                head.position.y = 1230;
                scene.add(head);

                var torsoOptions = {
                    amount: 200,
                    bevelThickness: 30,
                    bevelSize: 10,
                    bevelSegments: 4,
                    bevelEnabled: true
                };
                var torso = new THREE.Mesh(
                    new THREE.ExtrudeGeometry(drawTorsoOutline(), torsoOptions), bodyMaterial);
                torso.position.y = 550;
                torso.position.z = -50;
                scene.add(torso);

                var leftClaw = new THREE.Mesh(
                    new THREE.ExtrudeGeometry(drawLeftClaw(), 10), bodyMaterial);
                scene.add(leftClaw);
                var leftLeg = new THREE.Mesh(
                    new THREE.BoxGeometry(100,550,100), bodyMaterial);
                leftLeg.position.x = -200;
                leftLeg.position.y = 270;
                scene.add(leftLeg);
                var rightLeg = new THREE.Mesh(
                    new THREE.BoxGeometry(100,550,100), bodyMaterial);
                rightLeg.position.x = 200;
                rightLeg.position.y = 270;
                scene.add(rightLeg);

                var rightShoulderJoint = new THREE.Mesh(
                    new THREE.SphereGeometry(110), bodyMaterial);
                rightShoulderJoint.position.x = 280;
                rightShoulderJoint.position.y = 970;
                scene.add(rightShoulderJoint);

                var upperArm = new THREE.Mesh(
                    new THREE.CylinderGeometry(40,40,400), bodyMaterial );
                upperArm.position.x = 280;
                upperArm.position.y = 800;
                upperArm.position.z = -200;
                upperArm.rotation.x = Math.PI/4;
                scene.add(upperArm);

                var forearm = new THREE.Mesh(
                    new THREE.CylinderGeometry(40,40,200), bodyMaterial );
                forearm.position.x = 280;
                forearm.position.y = 600;
                forearm.position.z = -600;
                forearm.rotation.x = Math.PI/2;
                scene.add(forearm);

                var rightElbowJoint = rightShoulderJoint.clone();
                rightElbowJoint.position.x = 280;
                rightElbowJoint.position.y = 600;
                rightElbowJoint.position.z = -400;
                scene.add(rightElbowJoint);

                var rightClaw = new THREE.Mesh(new THREE.ExtrudeGeometry(drawRightClaw(),10), bodyMaterial);
                scene.add(rightClaw);
                rightClaw.rotation.x = Math.PI/2;
                leftClaw.rotation.x = Math.PI/2;
                leftClaw.position.z = -1200;
                rightClaw.position.z = -1200;
                rightClaw.position.y = 650;
                leftClaw.position.y = 650;
                leftClaw.position.x = -500;
                rightClaw.position.x = -580;

                var leftShoulderJoint = rightShoulderJoint.clone();
                leftShoulderJoint.position.x = -280;
                leftShoulderJoint.position.y = 970;
                scene.add(leftShoulderJoint);
                var leftUpperArm = upperArm.clone();
                leftUpperArm.position.x = -280;
                leftUpperArm.position.y = 800;
                leftUpperArm.position.z = -200;
                leftUpperArm.rotation.x = Math.PI/4;
                scene.add(leftUpperArm);
                var leftElbowJoint = rightShoulderJoint.clone();
                leftElbowJoint.position.x = -280;
                leftElbowJoint.position.y = 600;
                leftElbowJoint.position.z = -400;
                scene.add(leftElbowJoint);

                var leftForearm = forearm.clone();
                leftForearm.position.x = -280;
                leftForearm.position.y = 600;
                leftForearm.position.z = -600;
                scene.add(leftForearm);

                var rightHandLeftClaw = leftClaw.clone();
                rightHandLeftClaw.position.y = 550;
                rightHandLeftClaw.position.z = -1200;
                rightHandLeftClaw.position.x = 500;
                rightHandLeftClaw.rotation.y = Math.PI;
                scene.add(rightHandLeftClaw);

                var rightHandRightClaw = rightClaw.clone();
                rightHandRightClaw.rotation.y = Math.PI;
                rightHandRightClaw.position.x = 580;
                rightHandRightClaw.position.y = 550;

                scene.add(rightHandRightClaw);

                var leftFoot = new THREE.Mesh( new THREE.TorusGeometry(100, 70, 16,12), bodyMaterial );
                leftFoot.rotation.x = Math.PI/2;
                leftFoot.position.x = 200;
                leftFoot.position.y = 55;

                scene.add(leftFoot);

                var rightFoot = leftFoot.clone();
                rightFoot.position.x = -200;
                scene.add(rightFoot);

                var rightWrist  = new THREE.Mesh( new THREE.TorusGeometry(50, 30, 16,12), bodyMaterial );
                rightWrist.position.x = 280;
                rightWrist.position.y = 600;
                rightWrist.position.z = -700;
                scene.add(rightWrist);

                var leftWrist = rightWrist.clone();
                leftWrist.position.x = -280
                scene.add(leftWrist);
            }


            function drawTorsoOutline() {
                var shape = new THREE.Shape();
                var width = 300;
                var height = 500;
                shape.moveTo(-width,0);
                shape.lineTo(-width,height/1.5);
                shape.lineTo(-width/1.5,height)
                shape.lineTo(width/1.5,height);
                shape.lineTo(width,height/1.5);
                shape.lineTo(width,0);
                return shape;
            }

            // quadratic bezier curve followed by a series of zigzags
            function drawLeftClaw() {
                var shape = new THREE.Shape();

                shape.moveTo(250,500);
                shape.quadraticCurveTo(500,250,250,0);
                shape.moveTo(250,100);
                shape.moveTo(300,150);
                shape.moveTo(250,200);
                shape.moveTo(300,250);
                shape.moveTo(250,300);
                shape.moveTo(300,350);
                shape.moveTo(250,400);
                shape.moveTo(250,500);
            //  shape.lineTo(250,500);

                return shape;
            }

            function drawRightClaw() {
                var shape = new THREE.Shape();
                shape.moveTo(250,500);
                shape.quadraticCurveTo(0,250,250,0);
                shape.moveTo(250,100);
                shape.moveTo(300,150);
                shape.moveTo(250,200);
                shape.moveTo(300,250);
                shape.moveTo(250,300);
                shape.moveTo(300,350);
                shape.moveTo(250,400);
                shape.moveTo(250,500);
                return shape;
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
