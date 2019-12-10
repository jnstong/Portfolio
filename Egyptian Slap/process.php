<?php

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
		 case('getState'):
		 	include 'newGame.php';
        	 if(file_exists('ajax.txt')){
               $lines = file('ajax.txt');
        	 }
             $log['state'] = count($lines); 
        	 break;	
    	
    	 case('update'):
			echo("Im working");
		 	$servername = "sql209.epizy.com";
			$username = "epiz_24645009";
			$password = "4cOMn3ct3F8";
		 	$dbname = "epiz_24645009_egyptian_slap";
		 
			 // Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
		 	if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT game_id, number_of_players, turn_owner, attempts_left FROM Games WHERE game_id = ".$_POST["gameId"].";";
			$result = $conn->query($sql)->fetch_assoc();


			//Output result, send back to ajax as var 'response'
			echo "<table>";
			if(mysql_num_rows($result) > 0){
			//Fetch rows
			while($row = mysql_fetch_array($result)){
				 echo "<tr><td>".$row['game_id']."</td></tr>";
			}
			}else{
				echo "<tr><td>No results</td></tr>";
			}
			echo "</table>";
			 
		 	// $state = $_POST['state'];


			
			//include 'newGame.php';

        	// if(file_exists('ajax.txt')){
        	//    $lines = file('ajax.txt');
        	//  }
        	// //  $count =  count($lines);
        	// //  if($state == $count){
        	// 	 $log['state'] = $state;
        	// 	//  $log['text'] = false;
        		 
        		//  }
        		//  else{
        			//  $text= array();
        			//  $log['state'] = $state + count($lines) - $state;
        			//  foreach ($lines as $line_num => $line)
                    //    {
        			// 	   if($line_num >= $state){
                    //      	$text[] =  $line = str_replace("\n", "", $line);
        			// 	   }
         
                    //     }
        			//  $log['text'] = $text; 
        		//  }
        	  
             break;
    	 
    	 case('send'):
		  $playerName = htmlentities(strip_tags($_POST['playerName']));
			 //$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  //$message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){
        	
			 //if(preg_match($reg_exUrl, $message, $url)) {
       			//$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				//} 

			 if($_POST['message'] == "S")
			 {
				 include 'discardPile.php';
			 }
			 else if($_POST['message'] == "F")
			 {
				 include 'playerDeck.php';
			 }	
			 
        	 
        	 //fwrite(fopen('ajax.txt', 'a'),  $playerName . " " . $message = str_replace("\n", " ", $message) . "\n"); 
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>