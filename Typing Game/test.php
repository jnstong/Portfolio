<body>
	<h1> Test </h1>
	<div id="test"></div>
	<script>
	var blah = <?php
		//database login info
		$servername = "sql111.epizy.com";
		$username = "epiz_24432239";
		$password = "uhtayIl4oZMmqA";
		$dbname = "epiz_24432239_game_db";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT * FROM words";
		$result = $conn->query($sql);
		$rows = array();
		while($r = $result->fetch_assoc()){
			$rows[] = mb_convert_encoding($r["word"], 'UTF-8','UTF-8');
		}
		echo json_encode($rows);
		$conn->close();
	?>;
	document.getElementById(test).innerHTML = blah[0];
	</script>
</body>