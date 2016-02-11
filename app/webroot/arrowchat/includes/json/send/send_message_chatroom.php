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
	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions_send.php');

	// ########################### GET POST DATA #############################
	$userid 	= get_var('userid');
	$username	= get_var('username');
	$chatroomid = get_var('chatroomid');
	$message 	= get_var('message');
	$s_message	= sanitize($message);

	// ######################### START POST MESSAGE ##########################
	if (!empty($_POST['message'])) 
	{
		if (logged_in($userid)) 
		{
			$db->execute("
				INSERT INTO arrowchat_chatroom_messages (
					chatroom_id,
					user_id,
					username,
					message,
					global_message,
					sent
				) 
				VALUES (
					'" . $db->escape_string($chatroomid) . "', 
					'" . $db->escape_string($userid) . "', 
					'" . $db->escape_string($username) . "',
					'" . $db->escape_string($s_message) . "',
					'0',
					'" . time() . "'
				)
			");
			
			$last_id = $db->last_insert_id();
			
			// Update message history totals
			$result = $db->execute("
				SELECT sent
				FROM arrowchat_chatroom_messages
				ORDER BY id DESC
				LIMIT 1, 1
			");
			
			$date = time();
			$insert_date = date('Ymd', $date);
			
			if ($row = $db->fetch_array($result))
			{
				$last_date = date('Ymd', $row['sent']);
				
				if ($last_date != $insert_date && !empty($last_date))
				{
					$date1 = strtotime( $last_date );
					$date2 = strtotime( $insert_date );
					
					$days = count_days($date1, $date2);
					for ($i = 0; $i < $days; $i++) {
						$db->execute("
							INSERT INTO arrowchat_graph_log (
								date,
								chat_room_messages
							) 
							VALUES (
								'" . date('Ymd', $date1+(86400*$i)) . "',
								'0'
							) 
							ON DUPLICATE KEY 
								UPDATE chat_room_messages = chat_room_messages
						");	
					}
				}
				
				$db->execute("
					INSERT INTO arrowchat_graph_log (
						date,
						chat_room_messages
					) 
					VALUES (
						'" . $db->escape_string($insert_date) . "',
						'1'
					) 
					ON DUPLICATE KEY 
						UPDATE chat_room_messages = (chat_room_messages + 1)
				");
			}
			else
			{
				$db->execute("
					INSERT INTO arrowchat_graph_log (
						date,
						chat_room_messages
					) 
					VALUES (
						'" . $db->escape_string($insert_date) . "',
						'1'
					) 
				");
			}
			
			if ($push_on == 1)
			{
				$arrowpush->publish(array(
					'channel' => 'chatroom' . $chatroomid,
					'message' => array('chatroommessage' => array("id" => $last_id, "name" => $username, "message" => $s_message, "userid" => $userid, "sent" => time(), "global" => '0'))
				));
			}

			echo $last_id;
			close_session();
			exit(0);
		}
	}

?>