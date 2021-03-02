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

function draw(e) {
   ctx.fillStyle = '#09F';
   // ctx.fillRect(e.x, e.y, 10, 10);
  // ctx.arc(100, 75, 50, 0, 2 * Math.PI);
  // ctx.fill();
   
    ctx.beginPath();
	ctx.arc(e.x, e.y, 10, 0, Math.PI*2, true); 
	ctx.closePath();
	ctx.fill();
	
	//ctx.beginPath();
//ctx.arc(e.x, e.y, 50, 0, 2 * Math.PI);
//ctx.stroke();
}

function reset() {
    ctx.restore();
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, c.width, c.height);
    ctx.save();
}

reset();

c.addEventListener('click', draw);
clear.addEventListener('click', reset);
		
		});
	
	
	
</script>
  </head>

  <body>
	<canvas id="canvas" width="500" height="500"><img src="images/logo_ipack3.png"></canvas>
	<input type="button" value="clear" id="clear">

  </body>

</html>