<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	<!-- Three js -->
		<script type="text/javascript" src="js/three.js"></script>

		<!-- jQuery -->
		<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

		<!-- stats js -->
		<script type="text/javascript" src="js/stats.min.js"></script>
		
		<!-- dat gui js -->
    <script type="text/javascript" src="js/dat.gui.min.js"></script>

    <!-- require js -->
    <script type="text/javascript" src="js/require.js"></script>
        
    <!-- standXXX js -->
    <script type="text/javascript" src="js/standXXX.js"></script>

    <script id="vertexShader" type="x-shader/x-vertex">
  varying vec2 vUv;
  void main() {
    vUv = uv;
    gl_Position = projectionMatrix *
          modelViewMatrix * vec4(position, 1.0 );
  }
</script>
<script id="fragmentShader" type="x-shader/x-fragment">
  precision highp float;
  varying vec2 vUv;
  uniform sampler2D colTex;
  uniform sampler2D shadTex;
  void main(void) {
    gl_FragColor = texture2D(colTex, vUv) * texture2D(shadTex, vUv);
    //gl_FragColor = vec4(1.0, 1.0, 1.0, 1.0);
  }
</script>
<body>

	<!-- div #WebGL-salida donde se renderiza la escena -->
	<div id="WebGL-salida"></div>


	<!-- ejecutar contenido three js -->
		<script type="text/javascript">
		   $(function () {
		
        // creamos una scene, que contendrá todos nuestros elementos, como objetos, cámaras y luces.
        var scene = new THREE.Scene();

        // creamos una camera, que define desde donde vamos a mirar.
        var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
        


        document.addEventListener( 'keypress', onDocumentKeyPress, false );

        // creamos un render y configuramos el tamaño
        var renderer = new THREE.WebGLRenderer();

        renderer.setClearColor(0xeeeeee);
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.shadowMapEnabled = true;

        var axes = new THREE.AxisHelper( 80 );
        scene.add(axes);

        // creamos un cubo
        var cubeGeometry = new THREE.CubeGeometry(6,6,6);
        var cubeMaterial = new THREE.MeshBasicMaterial({color: 0xff0000});
        var cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
        cube.castShadow = true;

        // posicionamos el cubo
        cube.position.x=10;
        cube.position.y=3;
        cube.position.z=0;

        // añadimos el cubo a la escena
        scene.add(cube);

        // creamos un plano
        var planeGeometry = new THREE.PlaneGeometry(160,160);
        var planeMaterial = new THREE.MeshBasicMaterial({color: 0x000000});
        var plane = new THREE.Mesh(planeGeometry, planeMaterial);
      
        plane.rotation.x = Math.PI*(1.5);
        plane.position.x = 0; 
        plane.position.y = -2; 
        plane.position.z = 0; 
        plane.receiveShadow = true;

        scene.add(plane);

  		
  		// loader para el modelO

  		  function LoadStand(model, diff, occ, func) {
			    var colorTexture = THREE.ImageUtils.loadTexture(diff);
			    var shadeTexture = THREE.ImageUtils.loadTexture(occ);
			    var uniforms = {
			      'color': {type: 'f', value: 0.0},
			      'colTex': {type: 't', value: colorTexture},
			      'shadTex': {type: 't', value: shadeTexture}
			    };
			    var material = new THREE.ShaderMaterial({
			      'fog': false,
			      'uniforms': uniforms,
			      'vertexShader': vertexShader.innerHTML,
			      'fragmentShader': fragmentShader.innerHTML
			    });
			    
			    //var material = new THREE.MeshBasicMaterial({map:colorTexture});
			    var standGeom, stand;

			    var loader = new THREE.JSONLoader();
          loader.load(model, function(obj) {
            standGeom = obj;
            stand = new THREE.Mesh(obj, material);
            func(stand);
          });
        }
var stand01;
  var stand02;
  var loaded = false;
         function setLoaded(){
    if (loaded) {
      loadingSpan.style.display = "none";
      loadedSpan.style.display = "inline";

      addStand02();
    } else {
      loaded = true;
    }
  }


   LoadStand("js/standXXX.js", "../nuevasTexturas/concrete-floor-texture.png",
            "../nuevasTexturas/grass_grass_0099_02_preview.jpg", function (obj) {
    stand01 = obj;
    setLoaded();
  });
   scene.add(stand01);
      //---------------------------------------------------------------------------------
        // posiciona y apunta la cámara al centro de la escena
        camera.position.x = 160;
        camera.position.y = 160;
        camera.position.z = 160;
        camera.lookAt(scene.position);

          
        

        // añadir la salida de la renderización al elemento html
        $("#WebGL-salida").append(renderer.domElement);

        /*
          var controls =
            {
               cuboX : 0.1,
            };

            var gui = new dat.GUI();
            gui.add(controls, 'cuboX').min(0).max(1);
        */
          
        render();

        
        // eventos teclado
        function onDocumentKeyPress( event )
        {

            var keyCode = event.which;

            if ( keyCode == 8 ) 
            {
            event.preventDefault();
            }else{

                if ( keyCode == 115 ){
                    cube.position.x += 1;
                    camera.position.x += 1;
                }
                if ( keyCode == 119 ) {
                    cube.position.x -= 1;
                    camera.position.x -= 1;
                }
                if ( keyCode == 97 ){
                    cube.position.z += 1;
                    camera.position.z += 1;
                }
                if ( keyCode == 100 ){
                    cube.position.z -= 1;
                   camera.position.z -= 1;
                }
            camera.lookAt(cube.position);
            }

        }

        function render(){
            requestAnimationFrame(render);

            camera.lookAt(cube.position);

            // renderizar la escena
            renderer.render(scene, camera);
        }
    });
		</script>

</body>
</html>