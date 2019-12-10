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
	
	//get the top 5 cards of the discard pile
	$sql = "SELECT player_deck FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = 0;";
	$result = $conn->query($sql)->fetch_assoc();
	$returnValue = array();
	//echo "Discard: ".$result["player_deck"];
	$discard = $result["player_deck"];
	$pos1 = -1;
	$pos2 = strpos($discard, ",");
	$cards = array();
	for($i=0; $i<5 && $pos2 > $pos1; $i++){
		$card = substr($discard, $pos1+1, $pos2-$pos1-1);
		//echo "<br>".$card;
		$pos1 = $pos2;
		$pos2 = strpos($discard, ",", $pos1+1);
		$cards[$i] = $card;
	}
	
	$returnValue["cards"] = $cards;
	
	//get the important info from the current game
	$sql = "SELECT game_id, number_of_players, turn_owner, attempts_left, current_owner FROM Games WHERE game_id = '".$_POST["gameId"]."';";
	$result = $conn->query($sql)->fetch_assoc();
	$numberOfPlayers = $result["number_of_players"];
	$turnOwner = $result["turn_owner"];
	$currentOwner = $result["current_owner"];
	$attemptsLeft = $result["attempts_left"];
	$current_owner = $result["current_owner"];
	
	$decks = array();
	$names = array();
	for(;$numberOfPlayers >= 0; $numberOfPlayers--){
		//fetch data from database
		$sql = "SELECT player_number, player_deck, player_username FROM Decks WHERE game_id = '".$_POST["gameId"]."' AND player_number = ".$numberOfPlayers.";";
		$result = $conn->query($sql)->fetch_assoc();
		
		//get the players username
		$names[$numberOfPlayers] = $result["player_username"];
		
		
		//check if they win the pile or if it is their turn to play a card
		if($attemptsLeft == 0 and !is_null($attemptsLeft)){
			if($result["player_number"] == $current_owner){
				$returnValue["turnOwner"] = $result["player_username"]." wins the pile!";
			}
		}
		elseif($result["player_number"] == $turnOwner){
			$returnValue["turnOwner"] = $result["player_username"];
		}
		
		//gets how many cards are in the players deck
		$deck = $result["player_deck"];
		$numberOfCards = 0;
		$pos1 = -1;
		$pos2 = strpos($deck, ",");
		while($pos2 != false){
			$numberOfCards++;
			$pos1 = $pos2;
			$pos2 = strpos($deck, ",", $pos1+1);
		}
		$decks[$numberOfPlayers] = $numberOfCards;
		
	}	
	
	$returnValue["deckSizes"] = $decks;
	$returnValue["userNames"] = $names;
	
	//check if someone won the game
	$decksWithCards = 0;
	$winner = 0;
	for($i = 1; $i < count($decks); $i++){
		if($decks[$i] > 0){
			$decksWithCards++;
			$winner = $i;
		}
	}
	
	if($decksWithCards > 1){
		$winner = 0;
	}elseif(substr($cards[0],0, strlen($cards[0])-1) == substr($cards[1],0, strlen($cards[1])-1) and $decks[0]>1){
		$winner = 0;
	}elseif($currentOwner != $winner and !is_null($currentOwner)){
		$winner = 0;
	}
	
	
	
	$returnValue["winner"] = $winner;
	echo json_encode($returnValue);
	
	
	
	
	
	
	
	$conn->close();

	
?>