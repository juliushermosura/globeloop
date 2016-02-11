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

	/**
	 * Does everything to turn text into a readable, safe format
	 *
	 * @param	string	$text	The text to convert
	 * @return	string	The new string in a readable, safe format
	*/
	function sanitize($text) 
	{
		global $base_url;
		global $db;
		global $disable_smilies;
		global $language;
		global $smileys;
		global $theme;
		
		$text = htmlspecialchars($text, ENT_NOQUOTES);
		$text = str_replace("\n\r", "\n", $text);
		$text = str_replace("\r\n", "\n", $text);
		$text = str_replace("\n", " <br> ", $text);
		
		// Get the theme's directory if it is numeric
		if (is_numeric($theme)) 
		{
			$result = $db->execute("
				SELECT folder 
				FROM arrowchat_themes 
				WHERE id='".$theme."'
			");
			
			if ($result AND $db->count_select() > 0) 
			{
				$row = $db->fetch_array($result);
				$theme = $row['folder'];
			} 
			else 
			{
				$theme = "new_facebook";
			}
		}
		
		if ($disable_smilies != 1) 
		{ 
			if (!empty($smileys)) 
			{
				foreach ($smileys as $pattern => $result) 
				{
					$pattern = htmlspecialchars($pattern);
					$text = str_replace($pattern, '<img class="arrowchat_smiley" height="16" width="16" src="' . $base_url . AC_FOLDER_THEMES . DIRECTORY_SEPARATOR . $theme . '/images/smilies/' . $result . '.gif" alt="' . $result . '">', $text);
				}
			}
		}
		
		$text = preg_replace('@video[{](.*)[}]@', '<div class="arrowchat_action_message">' . $language[61] . '<br /><a href="javascript:jqac.arrowchat.videoWith(\'$1\');">' . $language[62] . '</a></div>', $text);
		
		$text = preg_replace('@file[{]([0-9]{10})[}]@', '<div class="arrowchat_action_message">' . $language[69] . '<br /><a href="' . $base_url . 'public/download.php?file=$1">' . $language[70] . '</a></div>', $text);

		return $text;
	}

?>