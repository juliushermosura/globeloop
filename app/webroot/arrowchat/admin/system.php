<?php

	/*
	|| #################################################################### ||
	|| #                             ArrowChat                            # ||
	|| # ---------------------------------------------------------------- # ||
	|| #    Copyright �2010-2012 ArrowSuites LLC. All Rights Reserved.    # ||
	|| # This file may not be redistributed in whole or significant part. # ||
	|| # ---------------- ARROWCHAT IS NOT FREE SOFTWARE ---------------- # ||
	|| #   http://www.arrowchat.com | http://www.arrowchat.com/license/   # ||
	|| #################################################################### ||
	*/
	
	// ########################## INCLUDE BACK-END ###########################
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "includes/admin_init.php");
	
	// Get the page to process
	if (empty($do))
	{
		$do = "update";
	}
	
	// ####################### START SUBMIT/POST DATA ########################
	
	// Config Settings Submit Processor
	if (var_check('config_submit')) 
	{
		$new_base_url = get_var('config_base_url');
		$heart_beat_test = true;
		
		if (get_var('config_buddy_list_heart_beat') >= get_var('config_online_timeout')) 
		{
			$heart_beat_test = false;
		}
		
		// Add a slash to the end of the base URL is one doesn't exist
		if (substr($new_base_url, -1) != "/")
		{
			$new_base_url = $new_base_url . "/";
		}
		
		$result = $db->execute("
			UPDATE arrowchat_config 
			SET config_value = CASE 
				WHEN config_name = 'base_url' THEN '" . $new_base_url . "'
				WHEN config_name = 'online_timeout' THEN '" . get_var('config_online_timeout') . "'
				WHEN config_name = 'heart_beat' THEN '" . get_var('config_heart_beat') . "'
				WHEN config_name = 'buddy_list_heart_beat' THEN '" . get_var('config_buddy_list_heart_beat') . "'
				WHEN config_name = 'idle_time' THEN '" . get_var('config_idle_time') . "'
				WHEN config_name = 'push_on' THEN '" . get_var('push_on') . "'
				WHEN config_name = 'push_publish' THEN '" . get_var('push_publish') . "'
				WHEN config_name = 'push_subscribe' THEN '" . get_var('push_subscribe') . "'
			END WHERE config_name IN ('channel_name', 'base_url', 'online_timeout', 'disable_smilies', 'heart_beat', 'buddy_list_heart_beat', 'idle_time', 'push_on', 'push_publish', 'push_subscribe')
		");
					
		if ($result && $heart_beat_test) 
		{
			$base_url = $new_base_url;
			$online_timeout = get_var('config_online_timeout');
			$heart_beat = get_var('config_heart_beat');
			$buddy_list_heart_beat = get_var('config_buddy_list_heart_beat');
			$idle_time = get_var('config_idle_time');
			$push_on = get_var('push_on');
			$push_publish = get_var('push_publish');
			$push_subscribe = get_var('push_subscribe');
			
			update_config_file();
			$msg = "Your settings were successfully saved.";
		} 
		else if (!$heart_beat_test)
		{
			$error = "The buddy list heart beat cannot be equal to or lower than the online timeout.  Please adjust the settings.";
		}
		else
		{
			$error = "There was a database error.  Please try again.";
		}
	}
	
	// Repair Processor
	if (var_check('repair_submit')) 
	{
		$result = $db->execute("
			INSERT IGNORE INTO arrowchat_config (
				config_name, 
				config_value, 
				is_dynamic
			) 
			VALUES  ('theme', 'new_facebook_full', 0), 
					('base_url', '" . $db->escape_string($base_url) . "', 0), 
					('online_timeout', '120', 0), 
					('disable_smilies', '0', 0), 
					('auto_popup_chatbox', '1', 0), 
					('heart_beat', '3', 0), 
					('language', 'en', 0), 
					('idle_time', '3', 0), 
					('install_time', '" . $db->escape_string($install_time) . "', 0), 
					('chatrooms_on', '0', 0), 
					('notifications_on', '0', 0), 
					('hide_bar_on', '1', 0), 
					('applications_on', '0', 0), 
					('popout_chat_on', '1', 0), 
					('theme_change_on', '0', 0), 
					('disable_avatars', '0', 0), 
					('disable_buddy_list', '1', 0), 
					('search_number', '5', 0), 
					('chat_maintenance', '0', 0), 
					('announcement', '', 0), 
					('admin_chat_all', '1', 0), 
					('admin_view_maintenance', '1', 0), 
					('user_chatrooms', '0', 0), 
					('user_chatrooms_flood', '10', 0), 
					('user_chatrooms_length', '30', 0), 
					('guests_can_view', '0', 0), 
					('video_chat', '0', 0), 
					('us_time', '1', 0), 
					('file_transfer_on', '0', 0), 
					('width_applications', '16', 0), 
					('width_buddy_list', '189', 0), 
					('width_chatrooms', '16', 0), 
					('buddy_list_heart_beat', '60', 0),
					('bar_fixed', '0', 0),
					('bar_fixed_alignment', 'center', 0),
					('bar_fixed_width', '900', 0),
					('bar_padding', '15', 0),
					('chatroom_auto_join', '0', 0),
					('chat_display_type', '1', 0),
					('chatroom_history_length', '60', 0),
					('disable_arrowchat', '0', 0),
					('enable_mobile', '1', 0),
					('guests_can_chat', '0', 0),
					('guests_chat_with', '1', 0),
					('push_on', '0', 0),
					('push_publish', '', 0),
					('push_subscribe', '', 0),
					('push_secret', '', 0),
					('show_full_username', '0', 0),
					('users_chat_with', '3', 0)
		");
		
		$result2 = $db->execute("
			DROP TABLE IF EXISTS `arrowchat_status`
		");
		
		$result3 = $db->execute('
			CREATE TABLE IF NOT EXISTS "arrowchat_status" (
			  "userid" varchar(50) NOT NULL,
			  "message" text,
			  "status" varchar(10) default NULL,
			  "theme" int(3) unsigned default NULL,
			  "popout" int(11) unsigned default NULL,
			  "typing" text,
			  "hide_bar" tinyint(1) unsigned default NULL,
			  "play_sound" tinyint(1) unsigned default \'1\',
			  "window_open" tinyint(1) unsigned default NULL,
			  "only_names" tinyint(1) unsigned default NULL,
			  "chatroom_window" varchar(2) NOT NULL default \'-1\',
			  "chatroom_stay" varchar(2) NOT NULL default \'-1\',
			  "chatroom_block_chats" tinyint(1) unsigned default NULL,
			  "chatroom_sound" tinyint(1) unsigned default NULL,
			  "announcement" tinyint(1) unsigned NOT NULL default \'1\',
			  "unfocus_chat" text,
			  "focus_chat" varchar(20) default NULL,
			  "last_message" text,
			  "apps_bookmarks" text,
			  "apps_other" text,
			  "apps_open" int(10) unsigned default NULL,
			  "block_chats" text,
			  "session_time" int(20) unsigned NOT NULL,
			  "is_admin" tinyint(1) unsigned NOT NULL default \'0\',
			  "hash_id" varchar(20) NOT NULL,
			  PRIMARY KEY  ("userid"),
			  KEY "hash_id" ("hash_id"),
			  KEY "session_time" ("session_time")
			)
		');
		
		if ($result && $result2 && $result3) 
		{
			update_config_file();
			$msg = "The repair has been successfully completed";
		}
	}
	
	$row = $db->fetch_row("
		SELECT email 
		FROM arrowchat_admin
	");
	$admin_email = $row->email;
	
	// Admin Settings Submit Processor
	if (var_check('admin_submit')) 
	{
		$admin_new_password = get_var('admin_new_password');
		$admin_confirm_password = get_var('admin_confirm_password');
		$admin_email = get_var('admin_email');
		$admin_old_password = get_var('admin_old_password');
		
		if (!empty($admin_new_password) OR !empty($admin_confirm_password)) 
		{
			if ($admin_new_password != $admin_confirm_password) 
			{
				$error = "Your new password and confirmation passwords do not match.";
			}
			
			if (!empty($admin_new_password) AND empty($admin_confirm_password)) 
			{
				$error = "You must supply a confirmation password.";
			}
			
			if (empty($admin_new_password) AND !empty($admin_confirm_password)) 
			{
				$error = "You must supply a new password.";
			}
		}
		
		if (empty($admin_email)) 
		{
			$error = "The admin email cannot be blank.";
		}
		
		if (empty($admin_old_password)) 
		{
			$error = "You must input your old password.";
		}
		
		if (empty($error)) 
		{
			$result = $db->execute("
				SELECT * 
				FROM arrowchat_admin
			");

			if ($result AND $db->count_select() > 0) 
			{
				$row = $db->fetch_array($result);
				
				$old_password = $row['password'];
				$old_email = $row['email'];
				$admin_old_password = md5($admin_old_password);
				$admin_new_password = md5($admin_new_password);
				
				if ($admin_old_password != $old_password) 
				{
					$error = "Your old password is not correct.";
				} 
				
				if (empty($error)) 
				{
					if (empty($_POST['admin_new_password'])) 
					{
						$admin_new_password = $old_password;
					}
					
					if (empty($_POST['admin_email'])) 
					{
						$admin_email = $old_email;
					}
					
					$result = $db->execute("
						UPDATE arrowchat_admin 
						SET password = '" . $db->escape_string($admin_new_password) . "', 
							email = '" . $db->escape_string($admin_email) . "'
					");

					if ($result) 
					{
						$msg = "Your settings were successfully saved.";
					} 
					else 
					{
						$error = "There is a database error.  Please try again.";
					}
				}
			} 
			else 
			{
				$error = "There is a database error.  Please try again.";
			}
		}
	}
	
	// Language Active Processor
	if ($do == "language") 
	{
		if (!empty($_REQUEST['activate'])) 
		{
			$result = $db->execute("
				UPDATE arrowchat_config 
				SET config_value = '" . get_var('activate') . "' 
				WHERE config_name = 'language'
			");

			if ($result) 
			{
				$msg = "Your language has been successfully activated.";
				update_config_file();
			} 
			else 
			{
				$error = "There was a database error.";
			}
		}
	}

	$smarty->assign('msg', $msg);
	$smarty->assign('error', $error);

	$smarty->display(dirname(__FILE__) . DIRECTORY_SEPARATOR . "layout/pages_header.tpl");
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "layout/pages_system.php");
	$smarty->display(dirname(__FILE__) . DIRECTORY_SEPARATOR . "layout/pages_footer.tpl");
	
	flush_headers();
?>