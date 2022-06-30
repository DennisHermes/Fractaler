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
			const modeDegree = <?php if ($_POST["modeInput"] == "pi") echo 0; else echo 1; ?>;
			const beginLength = <?php if ($_POST["startLine"] != null) echo $_POST["startLine"]; else echo 3; ?>;
			const minLength = <?php if ($_POST["minLength"] != null) echo $_POST["minLength"]; else echo 3; ?>;
			const lines = <?php echo $_POST["linesInput"]; ?>;
			var alpha = <?php if ($_POST["rotation1"] != null) echo $_POST["rotation1"]; else echo 0.5; ?>;
			var beta = <?php if ($_POST["rotation2"] != null) echo $_POST["rotation2"]; else echo 0.5; ?>;
			var delta = <?php if ($_POST["rotation3"] != null) echo $_POST["rotation3"]; else echo 0.5; ?>;
			const ratioA = <?php if ($_POST["ratio1"] != null) echo $_POST["ratio1"]; else echo 60; ?> / 100;
			const ratioB = <?php if ($_POST["ratio2"] != null) echo $_POST["ratio2"]; else echo 60; ?> / 100;
			const ratioC = <?php if ($_POST["ratio3"] != null) echo $_POST["ratio3"]; else echo 60; ?> / 100;

			const Point = function(x, y) {
				this.X = x;
				this.Y = y;
			};

			const canvas = document.getElementById('canvas');
			const context = canvas.getContext('2d');
			canvas.width = window.innerWidth * 1;
    		canvas.height = 1200;

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
				addCalculation("Rotatie gegeven in graden, ombereken naar radialen: (" + delta + " / 180) x 𝜋 = " + delta / 180 + "𝜋");
				delta = delta / 180 * Math.PI;
			} else {
				alpha = alpha * Math.PI;
				beta = beta * Math.PI;
				delta = delta * Math.PI;
			}

			drawLine(new Point(canvas.width / 2, canvas.height), beginLength, Math.PI * 1.5);
		</script>
		
	</body>
	
</html>