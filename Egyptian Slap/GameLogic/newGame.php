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
	
	//check if the game already exists. If it does just have the player join the game
	$sql = "SELECT game_id, number_of_players, players_in_game FROM Games WHERE game_id='".$_POST["gameId"]."';";
	$result = $conn->query($sql)->fetch_assoc();
	//echo "Number of Players: ".$result["players_in_game"]."<br>";
	$playerId = 0;
	if($result != false){	//Game already exists
	
		$foundOpenSlot = false;
		$playerId = 1;
		while($foundOpenSlot == false and $playerId <= $result["number_of_players"]){
			$sql = "SELECT player_number FROM Decks WHERE game_id='".$_POST["gameId"]."' AND player_username='Player".$playerId."';";
			$slotOpen = $conn->query($sql)->fetch_assoc();
			if($slotOpen != false){
				$foundOpenSlot = true;
			}
			else{
				$playerId++;
			}
		}
		//$playerId = $result["players_in_game"]+1;
		$array = array("Id"=>$playerId);
		echo json_encode($array);
		
		
		
		
		
		
		if($playerId <= $result["number_of_players"]){
			$sql = "UPDATE Games SET players_in_game = players_in_game+1 WHERE game_id='".$_POST["gameId"]."';";
			$conn->query($sql);
		}
		
		$sql = "UPDATE Decks SET player_username='".$_POST["playerName"]."' WHERE game_id='".$_POST["gameId"]."' AND player_number=".$playerId.";";
		$conn->query($sql);
		$conn->close();
		exit();
		
	}
	else{			//Game did not exist
		$playerId = 1;
		$array = array("Id"=>$playerId);
		echo json_encode($array);
		
	}
	
	

	$discardDeck = array('2H', '3H', '4H', '5H', '6H', '7H', '8H', '9H', '10H', 'JH', 'QH', 'KH', 'AH',
						'2D', '3D', '4D', '5D', '6D', '7D', '8D', '9D', '10D', 'JD', 'QD', 'KD', 'AD',
						'2C', '3C', '4C', '5C', '6C', '7C', '8C', '9C', '10C', 'JC', 'QC', 'KC', 'AC',
						'2S', '3S', '4S', '5S', '6S', '7S', '8S', '9S', '10S', 'JS', 'QS', 'KS', 'AS',
						);
	shuffle($discardDeck);
	$playerDecks = array();
	$players = 2;		//number of players playing
	
	//creates a deck (array) for each player
	for($i=0; $i<$players; $i++){
		$playerDecks[] = array();
	}
	$players--; //here to prevent an off by 1 error
	
	//deals out cards to the players decks
	foreach($discardDeck as $card){
		if($players < 0){
			$players = count($playerDecks) - 1;
		}
		$playerDecks[$players][] = $card;
		$players--;
	}
	
	
	
	
	$players = count($playerDecks);
	//create the game
	$sql = "REPLACE INTO Games(game_id, number_of_players, players_in_game, turn_owner) VALUES ('".$_POST["gameId"]."', ".$players.",1 , 1)";
	$conn->query($sql);

	//Get Game Id
	$gameId = $_POST["gameId"];
	
	//echo "Game Id: ".$gameId."<br>";
	
	
	//loops through so each player is saved
	;
	for($i=0; $i<$players;){
		$deck = "";
		//formats the array to be saved in the database
		foreach($playerDecks[$i] as $card){
			$deck = $deck.$card.",";
		}
		$i++; //increments here so the "player_number" doesn't start at 0 when it gets saved
		if($i==1){
				$sql = "REPLACE INTO Decks(game_id,player_number, player_deck, player_username) VALUES ('".$gameId."',".$i.", '".$deck."','".$_POST["playerName"]."')";
		}else{
			$sql = "REPLACE INTO Decks(game_id,player_number, player_deck, player_username) VALUES ('".$gameId."',".$i.", '".$deck."','Player".$i."')";
		}
		
		$conn->query($sql);
		
	}
	//add the discard pile which is player 0
	$sql = "REPLACE INTO Decks(game_id,player_number, player_deck, player_username) VALUES ('".$gameId."',0,'', 'Discard Pile')";
	$conn->query($sql);
	$conn->close();
?>
