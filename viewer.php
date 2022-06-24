<!DOCTYPE HTML>
<html>

	<head>
	
		<link rel="icon" type="image/x-icon" href="svg/draw.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://fonts.googleapis.com/css2?family=Hubballi&family=Oxygen:wght@300&family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/viewer.css" />
		
	</head>
	
	<body>
	
		<canvas id="canvas"></canvas>
		
		
		<ul id="calculations">
			
		</ul>
		
		<script>
			const modeDegree = <?php echo true; ?>;
			const beginLength = <?php echo 600; ?>;
			const minLength = <?php echo 1; ?>;
			var alpha = <?php echo 90; ?>;
			var beta = <?php echo -90; ?>;
			var delta = <?php echo 0; ?>;
			const ratioA = <?php echo 0.5; ?>;
			const ratioB = <?php echo 0.5; ?>;
			const ratioC = <?php echo 0.5; ?>;

			const Point = function(x, y) {
				this.X = x;
				this.Y = y;
			};

			const canvas = document.getElementById('canvas');
			const context = canvas.getContext('2d');
			canvas.width = window.innerWidth * 1;
    		canvas.height = window.innerHeight * 1;

			const drawLine = function(rootPoint, r, theta) {
				context.beginPath();
				const endX = rootPoint.X + r * Math.cos(theta);
				const endY = rootPoint.Y + r * Math.sin(theta);
				const endPoint = new Point(endX, endY);

				context.moveTo(rootPoint.X, rootPoint.Y);
				context.lineTo(endPoint.X, endPoint.Y);
				context.strokeStyle = generateColor();
				context.stroke();

				if (r * ratioA < minLength || r * ratioB < minLength || r * ratioC < minLength) {
					return;
				} else {
					drawLine(endPoint, r * ratioA, theta + alpha);
					drawLine(endPoint, r * ratioB, theta + beta);
					drawLine(endPoint, r * ratioC, theta + delta);
				}
			};

			function generateColor() {
				return "rgb(" + Math.floor(Math.random() * 256) + ", " + Math.floor(Math.random() * 256) + ", " + Math.floor(Math.random() * 256) + ")";
			}

			function addCalculation(calculation) {
				const node = document.createElement("li");
				const textnode = document.createTextNode(calculation);
				node.appendChild(textnode);
				document.getElementById("calculations").appendChild(node);
			}

			addCalculation("Middelpunt van canvas zoeken: ((" + canvas.width + " ÷ " + 2 + "), " + canvas.height + ") = (" + canvas.width / 2 + ", " + canvas.height + ")");
			if (modeDegree) {
				addCalculation("Rotatie gegeven in graden, ombereken naar radialen: (" + alpha + " / 180) x 𝜋 = " + alpha / 180 + "𝜋");
				alpha = alpha / 180 * Math.PI;
				addCalculation("Rotatie gegeven in graden, ombereken naar radialen: (" + beta + " / 180) x 𝜋 = " + beta / 180 + "𝜋");
				beta = beta / 180 * Math.PI;
			}

			drawLine(new Point(canvas.width / 2, canvas.height), beginLength, Math.PI * 1.5);
		</script>
		
	</body>
	
</html>