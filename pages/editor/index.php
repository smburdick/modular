<!-- editor/index.php -->
<!-- Model editor view -->
<html>
  <head>
    <title>Editor</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <style type="text/css">
    </style>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="three.min.js"></script>
    <script src="js/Detector.js"></script>
    <script src="js/CanvasRenderer.js"></script>
    <script src="js/Projector.js"></script>
    <script src="js/OrbitControls.js"></script>
    <script src="js/dat.gui.min.js"></script>
    <script src="js/KeyboardState.js"></script>


  </head>

  <body>
    <div id="canvas" style="width:600px; margin: 0 auto;">
        <script src="robotStart.js"> </script>
    </div>
    <?php
    	/*
			TODO
				- Reposition editor view onto the side
				- editor options: dropdown,...
				- url should contain modelID. if the user doesn't have this model, page should read "Error: you don't have permission to edit this model"
				- otherwise, editor should load the model.
    	*/
    ?>
</body>
</html>
