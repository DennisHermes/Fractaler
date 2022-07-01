<!DOCTYPE HTML>
<html>

	<head>
	
		<link rel="icon" type="image/x-icon" href="svg/draw.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://fonts.googleapis.com/css2?family=Hubballi&family=Oxygen:wght@300&family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/viewer.css" />
		
		<script type="text/javascript">
            var timerStart = Date.now();
        </script>

	</head>
	
	<body onload="draw();">
	
		<canvas class="canvas" id="canvas"></canvas>

		<div class="navbar">
			<div style="float: left;">
				<button class="button" onclick="zoomIn()">Inzoomen</button>
				<button class="button" onclick="zoomOut()">Uitzoomen</button>
			</div>
			<div style="float: right;">
				<button class="button" onclick="window.location.replace('index.html');">Terug</button>
			</div>
		</div>

		<div class="loading style-2" id="loading"><div class="loading-wheel"></div></div>
		
		<script>
			const modeDegree = <?php if ($_POST["modeInput"] == "pi") echo 0; else echo 1; ?>;
			var beginLength = <?php if ($_POST["startLine"] != null) echo $_POST["startLine"]; else echo 3; ?>;
			const minLength = <?php if ($_POST["minLength"] != null) echo $_POST["minLength"]; else echo 3; ?>;
			const lines = <?php echo $_POST["linesInput"]; ?>;
			var alpha = <?php if ($_POST["rotation1"] != null) echo $_POST["rotation1"]; else echo 0.5; ?>;
			var beta = <?php if ($_POST["rotation2"] != null) echo $_POST["rotation2"]; else echo 0.5; ?>;
			var delta = <?php if ($_POST["rotation3"] != null) echo $_POST["rotation3"]; else echo 0.5; ?>;
			var eta = <?php if ($_POST["rotation4"] != null) echo $_POST["rotation4"]; else echo 0.5; ?>;
			const ratioA = <?php if ($_POST["ratio1"] != null) echo $_POST["ratio1"]; else echo 60; ?> / 100;
			const ratioB = <?php if ($_POST["ratio2"] != null) echo $_POST["ratio2"]; else echo 60; ?> / 100;
			const ratioC = <?php if ($_POST["ratio3"] != null) echo $_POST["ratio3"]; else echo 60; ?> / 100;
			const ratioD = <?php if ($_POST["ratio4"] != null) echo $_POST["ratio4"]; else echo 60; ?> / 100;

			const Point = function(x, y) {
				this.X = x;
				this.Y = y;
			};

			var canvas = document.getElementById('canvas');
			var context = canvas.getContext('2d');
			canvas.height = window.innerHeight * 0.9;
			canvas.width = window.innerWidth * 0.9;
			context.scale(0.5, 0.5);

			const drawLine = function(rootPoint, r, theta) {
				context.beginPath();
				const endX = rootPoint.X + r * Math.cos(theta);
				const endY = rootPoint.Y + r * Math.sin(theta);
				const endPoint = new Point(endX, endY);

				context.moveTo(rootPoint.X, rootPoint.Y);
				context.lineTo(endPoint.X, endPoint.Y);
				context.strokeStyle = generateColor();
				context.stroke();

				if (r * ratioA < minLength || r * ratioB < minLength || r * ratioC < minLength || r * ratioD < minLength) {
					return;
				} else {
					drawLine(endPoint, r * ratioA, theta + alpha);
					if (lines >= 2) drawLine(endPoint, r * ratioB, theta + beta);
					if (lines >= 3) drawLine(endPoint, r * ratioC, theta + delta);
					if (lines >= 4) drawLine(endPoint, r * ratioD, theta + eta);
				}
			};

			function generateColor() {
				return "rgb(" + Math.floor(Math.random() * 256) + ", " + Math.floor(Math.random() * 256) + ", " + Math.floor(Math.random() * 256) + ")";
			}

			if (modeDegree) {
				alpha = alpha / 180 * Math.PI;
				beta = beta / 180 * Math.PI;
				delta = delta / 180 * Math.PI;
				eta = eta / 180 * Math.PI;
			} else {
				alpha = alpha * Math.PI;
				beta = beta * Math.PI;
				delta = delta * Math.PI;
				eta = eta * Math.PI;
			}

			function draw() {
				drawLine(new Point(canvas.width, canvas.height * 2), beginLength, Math.PI * 1.5);
				document.getElementById("loading").style.display = "none";
			}

			var zoom = 1;
			function zoomIn() {
				document.getElementById("loading").style.display = "block";
				context.clearRect(0, 0, canvas.height * 10, canvas.width * 10);
				beginLength = beginLength * 1.2;
				drawLine(new Point(canvas.width, canvas.height * 2), beginLength, Math.PI * 1.5);
				setTimeout(() => {
                	document.getElementById("loading").style.display = "none";
            	}, 100);
			}
			function zoomOut() {
				document.getElementById("loading").style.display = "block";
				context.clearRect(0, 0, canvas.height * 10, canvas.width * 10);
				beginLength = beginLength * 0.8;
				drawLine(new Point(canvas.width, canvas.height * 2), beginLength, Math.PI * 1.5);
				setTimeout(() => {
                	document.getElementById("loading").style.display = "none";
            	}, 100);
			}
		</script>
		
	</body>
	
</html>