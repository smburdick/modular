////////////////////////////////////////////////////////////////////////////////
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
 alert(val);
 drawRobot();
}

function alertTest() {
	alert("This is a JS test")
}

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
//	scene.add( cylinder );

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
		new THREE.CylinderGeometry(40,40,400), bodyMaterial	);
	upperArm.position.x = 280;
	upperArm.position.y = 800;
	upperArm.position.z = -200;
	upperArm.rotation.x = Math.PI/4;
	scene.add(upperArm);

	var forearm = new THREE.Mesh(
		new THREE.CylinderGeometry(40,40,200), bodyMaterial	);
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
//	shape.lineTo(250,500);

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
