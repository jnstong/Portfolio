<?php

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
		case('create'):
				include 'newGame.php';
			break;	
			
		case('update'):
				
			include 'update.php';
			
        	  
        break;
    	 
    	 case('send'):
			//$hello = "hello";
			if($_POST['message'] == "S")
			{
				 include 'discardPile.php';

			}
			else if($_POST['message'] == "F")
			{
				 include 'playerDeck.php';
			}	
        	 break;
    	
    }
    


?>