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
	
	// Turns off PHP error reporting. Comment this out if you are debugging.
	error_reporting(0);
	@ini_set('display_errors', 0);

	// Define the current ArrowChat version
	define('ARROWCHAT_VERSION', '1.5.11');
	
	// Define that we are within ArrowChat
	define('IN_ARROWCHAT', true);

	// Define the ArrowChat directory paths
	define('AC_FOLDER_ADMIN', 'admin');
	define('AC_FOLDER_APPLICATIONS', 'applications');
	define('AC_FOLDER_CACHE', 'cache');
	define('AC_FOLDER_INCLUDES', 'includes');
	define('AC_FOLDER_INSTALL', 'install');
	define('AC_FOLDER_LANGUAGE', 'language');
	define('AC_FOLDER_PUBLIC', 'public');
	define('AC_FOLDER_THEMES', 'themes');
	define('AC_FOLDER_UPGRADE', 'upgrade');
	define('AC_FOLDER_UPLOADS', 'uploads');
	
	// Require core files
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "edition.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "classes/class_database.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "config.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_CACHE . DIRECTORY_SEPARATOR . "data_admin_options.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "integration.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "functions/functions_php.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "functions/functions_common.php");
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_LANGUAGE . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $language . ".php");
	
	// Require push system if enabled
	if ($push_on == 1)
	{
		require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "classes/class_arrowpush.php");
		$arrowpush = new ArrowPush( $push_publish, $push_subscribe, '', false);
	}

?>