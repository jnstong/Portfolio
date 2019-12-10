<?php
	session_start();
	$_SESSION["score"] = $_POST["score"];
	//database info
	$servername = "sql111.epizy.com";
	$username = "epiz_24432239";
	$password = "uhtayIl4oZMmqA";
	$dbname = "epiz_24432239_game_db";
	
	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO Scores(user_name, score) VALUES ('".$_SESSION["userName"]."', '".$_POST["score"]."')";
	if (!($conn->query($sql) === TRUE)) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	header('Location: scores.html.php');

?>