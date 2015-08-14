
    function functionKeydown(event) 
    {
       keyPressed[event.keyCode] = true;
       charPressed[event.charCode] = true;
       
    }

    function functionKeyup(event) 
    {
      keyPressed[event.keyCode] = false;
      charPressed[event.charCode] = false;
    }
    
function eventosKey()
{
	//mov mouse
    if(mouseKeep)
    {
      camera.lookAt(new THREE.Vector3(cube.position.x, cube.position.y+moveY, cube.position.z));                   
      if( clickX > 400 )
        cube.rotation.y -= 0.1;
      if( clickX < 200 )
        cube.rotation.y += 0.1;
    }

    // mov key
    if(keyPressed[38] || keyPressed[87]) // W
    {
      cube.position.z = cube.position.z - velocidadDesplazamiento * Math.cos( cube.rotation.y );
      cube.position.x = cube.position.x - velocidadDesplazamiento * Math.sin( cube.rotation.y );
    }

    if(keyPressed[37] || keyPressed[65]) // A
    {
      cube.rotation.y += 0.06;
    }

    if(keyPressed[83] || keyPressed[40]) // S
    {
      cube.position.z = cube.position.z + velocidadDesplazamiento * Math.cos( cube.rotation.y );
      cube.position.x = cube.position.x + velocidadDesplazamiento * Math.sin( cube.rotation.y );   
    }

    if(keyPressed[68] || keyPressed[39]) // D
    {
      cube.rotation.y -= 0.06;
    }

    if(keyPressed[32]) // barra espaciadora
    {
      cube.position.y += 1;
      camera.lookAt(new THREE.Vector3(cube.position.x, cube.position.y - 1, cube.position.z));   
    }
}