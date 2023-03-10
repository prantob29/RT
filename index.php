<!DOCTYPE html>
<html>
<head>
	<title>MikroTik Interface Bandwidth Monitor</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f2f2f2;
		}
		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
			border-radius: 5px;
			margin-top: 50px;
			text-align: center;
		}
		h1 {
			font-size: 36px;
			margin-bottom: 20px;
		}
		p {
			font-size: 18px;
			margin-bottom: 10px;
			text-align: left;
		}
		input[type="text"] {
			font-size: 16px;
			padding: 10px;
			border-radius: 5px;
			border: none;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			margin-right: 10px;
			width: 200px;
		}
		button {
			font-size: 16px;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			background-color: #4CAF50;
			color: #fff;
			cursor: pointer;
		}
		button:hover {
			background-color: #3e8e41;
		}
		#bandwidth {
			font-size: 24px;
			font-weight: bold;
			margin-top: 20px;
			text-align: center;
		}
	</style>
	<script>
		$(document).ready(function() {
			$("#btn-refresh").click(function() {
				$.ajax({
					url: "get_bandwidth.php",
					type: "POST",
					data: {
						interface: $("#interface-name").val()
					},
					success: function(data) {
						$("#bandwidth").html(data);
					}
				});
			});
			setInterval(function() {
				$("#btn-refresh").click();
			}, 1000);
		});
	</script>
</head>
<body>
	<div class="container">
		<h1>MikroTik Interface Bandwidth Monitor</h1>
		<p>Enter the name of the interface you want to monitor:</p>
		<input type="text" id="interface-name" name="interface-name" autocomplete="on">
		<button id="btn-refresh">Refresh</button>
		<p>Current bandwidth usage for interface <span id="interface-label"></span>:</p>
		<div id="bandwidth"></div>
	</div>
</body>
</html>