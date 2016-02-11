<?php

	/*
	|| #################################################################### ||
	|| #                             ArrowChat                            # ||
	|| # ---------------------------------------------------------------- # ||
	|| #    Copyright ©2010-2012 ArrowSuites LLC. All Rights Reserved.    # ||
	|| # This file may not be redistributed in whole or significant part. # ||
	|| # ---------------- ARROWCHAT IS NOT FREE SOFTWARE ---------------- # ||
	|| #   http://www.arrowchat.com | http://www.arrowchat.com/license/   # ||
	|| #################################################################### ||
	*/

	// ########################## INCLUDE BACK-END ###########################
	require_once (dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php');
	require_once (dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . 'init.php');

	// ########################### GET POST DATA #############################
	$userid 			= get_var('userid');
	$chatroom_name		= get_var('name');
	$chatroom_password	= get_var('password');
	
	$type = "1";
	$password = "";

	// ###################### START CREATE CHATROOM ##########################
	if (!empty($_POST['name'])) 
	{
		if (!empty($user_chatrooms)) 
		{
			$flood_time = $user_chatrooms_flood *60;

			$result = $db->execute("
				SELECT session_time
				FROM arrowchat_chatroom_rooms
				WHERE author_id = '" . $db->escape_string($userid) . "'
					AND session_time + " . $flood_time . " > " . time() . "
			");
			
			if ($result AND $db->count_select() < 1) 
			{
				if (!empty($chatroom_password)) {
					$type = "2";
					$password = $chatroom_password;
				}
				
				$db->execute("
					INSERT INTO arrowchat_chatroom_rooms (
						author_id, 
						name, 
						type, 
						password,
						length, 
						session_time
					) 
					VALUES (
						'" . $db->escape_string($userid) . "',
						'" . $db->escape_string($chatroom_name) . "', 
						'" . $type . "', 
						'" . $db->escape_string($password) . "',
						'" . $db->escape_string($user_chatrooms_length) . "', 
						'" . time() . "'
					)
				");
			
				echo "1";
			} 
			else 
			{
				echo "-1"; // Display flood time limit error
			}
		}
		else 
		{
			echo "-2"; // Display user created chatrooms off error
		}

		close_session();
		exit(0);
	}

?>