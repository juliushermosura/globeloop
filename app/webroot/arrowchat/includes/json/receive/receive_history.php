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

	// ########################### INITILIZATION #############################
	$response = array();
	$messages = array();
	$timestamp = time();

	// ######################## START HISTROY RECEIVE ########################
	if (logged_in($userid)) 
	{
		if (!empty($_POST['chatbox'])) 
		{
			$chatbox = get_var('chatbox');
			
			$result = $db->execute("
				SELECT last_message 
				FROM arrowchat_status 
				WHERE userid = '" . $db->escape_string($userid) . "'
			");

			$row = $db->fetch_array($result);
			
			$last_message = $row['last_message'];
			
			if (!empty($last_message)) 
			{
				if (preg_match("#:$chatbox/[0-9]+#", $last_message, $matches)) 
				{
					$matches2 = explode("/", $matches[0]);
					$time_check = (int)$matches2[1] - 3600;
				} 
				else 
				{
					$time_check = time() - 3600;
				}
			} 
			else 
			{
				$time_check = time() - 3600;
			}
			
			$result = $db->execute("
				SELECT arrowchat.id, arrowchat.from, arrowchat.to, arrowchat.message, arrowchat.sent, arrowchat.read 
				FROM arrowchat 
				WHERE ((arrowchat.to = '" . $db->escape_string($userid) . "' 
							AND arrowchat.from = '" . $db->escape_string($chatbox) . "') 
						OR (arrowchat.from = '" . $db->escape_string($userid) . "' 
							AND arrowchat.to = '" . $db->escape_string($chatbox) . "')) 
					AND (arrowchat.sent > " . $time_check . " 
						OR arrowchat.user_read = '0') 
				ORDER BY arrowchat.id
			");
		 
			while ($chat = $db->fetch_array($result)) 
			{
				$self = 0;
				$old = 0;
				
				if ($chat['from'] == $userid) 
				{
					$chat['from'] = $chat['to'];
					$self = 1;
					$old = 1;
				}

				if ($chat['read'] == 1) 
				{
					$old = 1;
				}
				
				$chat_message = $chat['message'];
				$chat_message = str_replace("\\'", "'", $chat_message);
				$chat_message = str_replace('\\"', '"', $chat_message);
				$chat_message = clickable_links($chat_message);

				$messages[] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat_message, 'self' => $self, 'old' => $old, 'sent' => $chat['sent']);

				$timestamp = $chat['id'];
			}	
			
			$db->execute("
				UPDATE arrowchat 
				SET arrowchat.user_read = '1' 
				WHERE arrowchat.from = '" . $db->escape_string($chatbox) . "' 
					AND arrowchat.to = '" . $db->escape_string($userid) . "' 
					AND arrowchat.user_read = '0'
			");
		}
		
		if (!empty($messages)) 
		{
			$response['messages'] = $messages;
		}
	}

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($response);
	close_session();
	exit;

?>