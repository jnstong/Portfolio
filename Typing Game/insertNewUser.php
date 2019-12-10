<html>
<head>
	<meta http-equiv="refresh" content="1;url=index.html">
</head>
	<?php
	
		$servername = "sql111.epizy.com";
		$username = "epiz_24432239";
		$password = "uhtayIl4oZMmqA";
		$dbname = "epiz_24432239_game_db";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "INSERT INTO Users(user_name, hashed_password, salt) VALUES ('".$_POST["userName"]."', '".$_POST["hashedPass"]."', '".$_POST["salt"]."')";

		if ($conn->query($sql) === TRUE) {
			echo $_POST["userName"]. " created! Salt: ".var_dump($_POST);
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	?>
	
</body>
</html>