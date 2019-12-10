<?php
	$servername = "sql209.epizy.com";
	$username = "epiz_24645009";
	$password = "4cOMn3ct3F8";
	$dbname = "epiz_24645009_egyptian_slap";
		 
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$gameId = $_POST["gameId"];
	$playerId = $_POST["player"];
	
	$sql = "SELECT players_in_game FROM Games WHERE game_id='".$gameId."';";
	$result = $conn->query($sql)->fetch_assoc();
	if($result["players_in_game"]-1 <= 0){
		$sql = "DELETE FROM Games WHERE game_id='".$_POST["gameId"]."';";
		$conn->query($sql);
		$sql = "DELETE FROM Decks WHERE game_id='".$_POST["gameId"]."';";
		$conn->query($sql);
		$conn->close();
		exit();
	}else{
		$sql = "UPDATE Decks SET player_username='Player".$playerId."' WHERE game_id='".$_POST["gameId"]."' AND player_number=".$playerId.";";
		$conn->query($sql);
		
		$sql = "UPDATE Games SET players_in_game = players_in_game-1 WHERE game_id='".$_POST["gameId"]."';";
	    $conn->query($sql);
		
		
		$conn->close();
	}
	
	
	

	
?>