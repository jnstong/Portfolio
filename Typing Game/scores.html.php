<?php
	session_start();
?>
<html>

<head>
	<link rel="stylesheet" href="background.css">
	<style>
		table{
			width: 100%;
			 
		}
		tr{
			text-align: center;
		}
		th, td{
			padding: 3px;
		}
		table, th, td{
			border: 1px solid black;
			border-collapse: collapse;
		}
		caption{
			font-size: 2em;
			font-weight: bold;
		}
		.outside{
			transform:translate(-50%,-50%);
			
		}
	</style>
</head>
<body onload="load()">
<span class="outside">
<span class="inside">
	<h1 id="currentScore"><?php echo $_SESSION["userName"]." your score was: ".$_SESSION["score"] ?></h1>
	
	<table id="highScoresTable">
		<caption>High Scores</caption>
		<tr>
			<th>User Name</th>
			<th>Score</th>
		</tr>
	</table>
	<br>
	<button type="button" onclick="window.location.href = '/mainGame.html.php';">Play Again</button>
	<button type="button" onclick="quitGame()">Quit Game</button>
</span>
</span>
	<script>
		var highScores = <?php
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
			
			$sql = "SELECT * FROM Scores ORDER BY score DESC LIMIT 10";
			$result = $conn->query($sql);

			$rows = array();
			while($r = $result->fetch_assoc()){
				$rows[] = $r;
			}
			echo json_encode($rows);
			
			$conn->close();
		?>;
		
		
		
		function load(){
			var string = "";
			for(score of highScores){
				string += "<tr><td>"+ score["user_name"]+ "</td><td>" + score["score"] + "</td></tr>";
			}
			
			document.getElementById("highScoresTable").innerHTML += string;
		}
		
		function quitGame(){
	
			window.location.replace("index.html");
		}
		
	</script>
</body>
</html>