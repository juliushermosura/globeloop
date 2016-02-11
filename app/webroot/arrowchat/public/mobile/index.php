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
	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Mobile Chat</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; user-scalable=0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<meta name="apple-touch-fullscreen" content="yes" />
		
		<link rel="apple-touch-icon" href="images/apple-touch-icon.png"/> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
		<link type="text/css" rel="stylesheet" id="arrowchat_css" media="all" href="<?php echo $base_url; ?><?php echo AC_FOLDER_PUBLIC; ?>/mobile/includes/css/style.css" charset="utf-8" />

		<script type="text/javascript" src="<?php echo $base_url; ?><?php echo AC_FOLDER_INCLUDES; ?>/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo $base_url; ?><?php echo AC_FOLDER_PUBLIC; ?>/mobile/includes/js/jquery-mobile.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>external.php?type=djs" charset="utf-8"></script> 
		<script type="text/javascript" src="<?php echo $base_url; ?>external.php?type=mjs" charset="utf-8"></script> 
	</head>
    <body>
        <div data-role="page" id="page1">
            <div data-theme="b" data-role="header">
                <h3>
                    <?php echo $language[110]; ?>
					
                </h3>
            </div>
            <div data-role="content">
                <ul id="buddylist-container-available" data-role="listview" data-divider-theme="c" data-inset="false"></ul>
				<ul id="buddylist-container-away" data-role="listview" data-divider-theme="c" data-inset="false"></ul>
            </div>
        </div>
		<div data-role="page" id="page2">
            <div data-theme="b" data-role="header">
                <h3 id="username-header">
					<?php echo $language[110]; ?>
					
                </h3>
                <a data-role="button" id="back-button" data-direction="reverse" data-transition="slide" data-theme="b" href="#page1" data-icon="arrow-l" data-iconpos="left">
                    <?php echo $language[113]; ?>
					
                </a>
            </div>
            <div data-role="content" class="chat_user_content">
            </div>
            <div data-theme="d" data-role="footer" data-position="fixed" style="height: 50px;">
                <div data-role="fieldcontain">
						<fieldset data-role="controlgroup" data-inline="true" style="margin-top:-23px;">
							<label for="textinput1">
							</label>
							<input id="textinput1" placeholder="" value="" type="text" style="width: 70%; float: left; margin-left: 10px;" />
							<a id="send_button" data-role="button" data-inline="true" data-transition="none" data-theme="b" href="javascript:;" style="float:right; margin-right: 10px; margin-top:3px">
								<?php echo $language[114]; ?>
							</a>
						</fieldset>
                </div>
            </div>
		</div>
    </body>
</html>