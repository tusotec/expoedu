 function onMouseDown( event ) 
{
    mouseKeep = true;
}

function onMouseMove( event ) 
{ 
    moveY = ((178-event.clientY) / 200);
    clickX = event.clientX;            
}

function onMouseUp(  event  ) 
{
    mouseKeep = false;
}

function onMousewheel( event ) 
{
    if(event.deltaY > 0)
    {
        console.log('bajar');
    }else{
        console.log('subir');
    }
    //mouseKeep = false;
}