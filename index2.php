<!DOCTYPE html>
<html>
<head>
	<title>MikroTik Interface Bandwidth Monitor</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
	<h1>MikroTik Interface Bandwidth Monitor</h1>
	<p>Enter the name of the interface you want to monitor:</p>
	<input type="text" id="interface-name" name="interface-name">
	<button id="btn-refresh">Refresh</button>
	<p>Current bandwidth usage for interface <span id="interface-label"></span>:</p>
	<div id="bandwidth"></div>
</body>
</html>
