<?php
	session_start();
?>

<html>
<header>
<link rel="stylesheet" href="background.css">
</header>
<body>
<span class="outside">
<span class="inside">
	<?php
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
		$sql = "SELECT * FROM Users WHERE user_name='".$_SESSION["userName"]."' AND hashed_password='".$_POST["hashedPass"]."'";
		$result = $conn->query($sql);

		if($result->num_rows > 0){
			echo "<h1>Welcome to the typing game ".$_SESSION["userName"]."</h1>";
			echo"<button type='button' onclick=\"window.location.href = 'mainGame.html.php';\">Play Game</button>";
		}else{
			echo "Incorrect Password!";
			header("refresh:3; url=index.html");
		}
		
		$conn->close();
	?>
</span>
</span>
</body>
</html>