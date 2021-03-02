<html>
  <head>
    <title>Desenhando com jQuery</title>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
var count = 0;
	$(document).ready(function() {
		
		var clear = document.getElementById('clear');
		
		var c = document.getElementById('canvas'),
		
    ctx = c.getContext('2d');
	
	var anImage = new Image();
    anImage.src = 'images/SABSZG2AN190102_13.jpg';

    anImage.onload = function() {
      ctx.drawImage(anImage,0,0);
    };


function draw(e) {
	ctx.globalAlpha = 0.6;
  // ctx.fillStyle = '#09F';
   ctx.strokeStyle =  '#FF0000';
   ctx.lineWidth = 10;
   // ctx.fillRect(e.x, e.y, 10, 10);
  // ctx.arc(100, 75, 50, 0, 2 * Math.PI);
  // ctx.fill();
   
    ctx.beginPath();
	ctx.arc(e.x, e.y, 40, 0, Math.PI*2, true); 
	//ctx.closePath();
	ctx.stroke();
	
	//ctx.beginPath();
//ctx.arc(e.x, e.y, 50, 0, 2 * Math.PI);
//ctx.stroke();
}

function reset() {
    ctx.restore();
  //  ctx.fillStyle = '#000000';
   // ctx.fillRect(0, 0, c.width, c.height);
    ctx.save();
}

//reset();

c.addEventListener('click', draw);
//clear.addEventListener('click', reset);
		
		});
	
	
	function saveimage(){
		var dataURL = document.getElementById('canvas').toDataURL();
		$.ajax({
  type: "POST",
  url: "upload_draw.php",
  data: { 
     imgBase64: dataURL
  }
}).done(function(o) {
  //console.log('saved'); 
  // If you want the file to be visible in the browser 
  // - please modify the callback in javascript. All you
  // need is to return the url to the file, you just saved 
  // and than put the image in your browser.
});
		}
</script>
  </head>

  <body >
 <!-- <img src="images/logo_ipack3.png">-->
	<canvas id="canvas" width="900" height="672"></canvas>
	<input type="button" value="save" onClick="saveimage();">
 
  </body>

</html>