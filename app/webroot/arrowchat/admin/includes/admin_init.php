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
	require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "bootstrap.php");
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "functions/functions.php");
	require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "init.php");
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "functions/functions_update.php");
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "functions/functions_login.php");
	require_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . "classes/Smarty/Smarty.class.php");
	
	// Create a new session if one already exists from the integration file
	@session_destroy();
	session_name('arrowchat_sess');
	if (isset($_COOKIE['arrowchat_sess']))
		session_id($_COOKIE['arrowchat_sess']);
	else
		session_id(sha1(mt_rand()));
	session_start();
	
	$smarty = new Smarty;
	
	// Get do variable
	$do = get_var('do');
	
	// Admin Login
	if (var_check('login'))
	{
		$error = admin_login(get_var('username'), get_var('password'));
	}
	
	// Admin logout
	if ($do == "logout") 
	{
		admin_logout();
	}
	
	$smarty->assign('username_post', get_var('username'));
	$smarty->assign('password_post', get_var('password'));
	$smarty->assign('login_post', get_var('login'));
	
	// Check if logged in as admin
	admin_check_login($error);
	
	session_write_close();
	
	// Various admin checks
	$theme = convert_numeric_theme($theme);
	$write = check_config_file();
	$install = check_install_folder();
	
	//*********Smarty Variables************
	// Check if features are disabled to display message
	$feature_disabled = "";
	if ($chatrooms_on != 1 AND $do == "chatroomsettings")
	{
		$feature_disabled = "Chatrooms";
	}
	
	if ($notifications_on != 1 AND $do == "notificationsettings")
	{
		$feature_disabled = "Notifications";
	}
	
	if ($applications_on != 1 AND $do == "appsettings")
	{
		$feature_disabled = "Applications";
	}
	
	$admin_username = $_SESSION['arrowchat_admin' . $base_url];
	
	// Assign smarty variables
	$smarty->assign('admin_username', $admin_username);
	$smarty->assign('write', $write);
	$smarty->assign('install', $install);
	$smarty->assign('feature_disabled', $feature_disabled);
	$smarty->assign('arrowchat_has_update', $arrowchat_has_update);
	$smarty->assign('applications_have_update', $applications_have_update);
	$smarty->assign('applications_update_count', $applications_update_count);
	$smarty->assign('themes_have_update', $themes_have_update);
	$smarty->assign('themes_update_count', $themes_update_count);
	
?>