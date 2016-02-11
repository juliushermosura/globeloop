			<div class="title_bg"> 
				<div class="title">General</div> 
				<div class="module_content">
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?do=<?php echo $do; ?>" enctype="multipart/form-data">
<?php
	if ($do == "chatfeatures") 
	{
?>
					<div class="subtitle">General Features</div>
					<fieldset class="firstFieldset">
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="hide_bar_on">
											<input type="checkbox" id="hide_bar_on" name="hide_bar_on" <?php if($hide_bar_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Hide Bar
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to completely hide the ArrowChat bar.
								</p>
							</dd>
						</dl>
						<?php
							if (ARROWCHAT_EDITION == "lite")
							{
						?>
							<input type="hidden" name="chatrooms_on" value="0" />
							<input type="hidden" name="applications_on" value="0" />
							<input type="hidden" name="notifications_on" value="0" />
						<?php
							} else {
						?>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="chatrooms_on">
											<input type="checkbox" id="chatrooms_on" name="chatrooms_on" <?php if($chatrooms_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Chat Rooms
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to use the chat rooms feature.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="applications_on">
											<input type="checkbox" id="applications_on" name="applications_on" <?php if($applications_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Applications
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to use the applications menu.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="notifications_on">
											<input type="checkbox" id="notifications_on" name="notifications_on" <?php if($notifications_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Site Notifications
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to use the site notifications feature. This feature must first be installed correctly to function. Please visit http://www.arrowchat.com/support/ for documentation on installation.
								</p>
							</dd>
						</dl>
					<?php
						}
					?>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="enable_mobile">
											<input type="checkbox" id="enable_mobile" name="enable_mobile" <?php if($enable_mobile == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Mobile Chat
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to use the bar when on a mobile device.
								</p>
							</dd>
						</dl>
					</fieldset>
					<fieldset>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="popout_chat_on">
											<input type="checkbox" id="popout_chat_on" name="popout_chat_on" <?php if($popout_chat_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Users to Pop Out the Chat
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to use pop out chat.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="theme_change_on">
											<input type="checkbox" id="theme_change_on" name="theme_change_on" <?php if($theme_change_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Users to Change Themes
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to change their theme to any theme that is currently set as active. Unchecking this will enable the default theme for all users.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="video_chat">
											<input type="checkbox" id="video_chat" name="video_chat" <?php if($video_chat == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Users to Video Chat
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to video chat with each other.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="file_transfer_on">
											<input type="checkbox" id="file_transfer_on" name="file_transfer_on" <?php if($file_transfer_on == 1) echo 'checked="checked"';  ?> value="1" />
											Enable Users to Transfer Files
										</label>
									</li>
								</ul>
								<p class="explain">
									Allows users to transfer files with each other. CHMOD your uploads folder to 777 before enabling this feature.
								</p>
							</dd>
						</dl>
					</fieldset>
					<dl class="selectionBox submitBox">
						<dt></dt>
						<dd>
							<div class="floatr">
								<a class="fwdbutton" onclick="document.forms[0].submit(); return false">
									<span>Save Changes</span>
								</a>
								<input type="hidden" name="chatfeatures_submit" value="1" />
							</div>
						</dd>
					</dl>
<?php
	}
?>
<?php
	if ($do == "chatsettings") 
	{
?>
					<div class="subtitle">General Settings</div>
					<fieldset class="firstFieldset">
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="guests_can_view">
											<input type="checkbox" id="guests_can_view" name="guests_can_view" <?php if($guests_can_view == 1) echo 'checked="checked"'; ?> value="1" />
											Guests Can View the Bar
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will allow guets to be able to view the chat bar with bar links and applications (if enabled) and a message telling them to register or login.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="guests_can_chat">
											<input type="checkbox" id="guests_can_chat" name="guests_can_chat" <?php if($guests_can_chat == 1) echo 'checked="checked"'; ?> value="1" />
											Guests Can Chat
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will allow guets to be able to chat without logging in.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="disable_buddy_list">
										<?php
											if (NO_FREIND_SYSTEM == 1)
											{
										?>
											<input type="checkbox" id="disable_buddy_list" disabled="disabled" checked="checked" 
value="1" />
											<input type="hidden" name="disable_buddy_list" value="1" />
										<?php
											} else {
										?>
											<input type="checkbox" id="disable_buddy_list" name="disable_buddy_list" <?php if($disable_buddy_list == 1) echo 'checked="checked"'; ?> value="1" />
										<?php
											}
										?>
											Show All Online Users
										</label>
									</li>
								</ul>
								<p class="explain">
								<?php
									if (NO_FREIND_SYSTEM == 1)
									{
								?>
									This feature has been disabled because we detected that your site has no friend system.  You can change this in the includes/config.php file.
								<?php
									} else {
								?>
									Checking this will disable the friend's list and everyone on your site will be able to chat with anyone online.
								<?php
									}
								?>
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt><label>Guests Chat With</label></dt>
							<dd>
								<ul>
									<li>
										<label for="chat_with_guests_1">
											<input type="radio" name="guests_chat_with" value="1" id="chat_with_guests_1" <?php if($guests_chat_with == 1) echo 'checked="checked"'; ?> /> Guests Only
										</label>
									</li>
									<li>
										<label for="chat_with_guests_2">
											<input type="radio" name="guests_chat_with" value="2" id="chat_with_guests_2" <?php if($guests_chat_with == 2) echo 'checked="checked"'; ?> /> Guests and Members
										</label>
									</li>
									<li>
										<label for="chat_with_guests_3">
											<input type="radio" name="guests_chat_with" value="3" id="chat_with_guests_3" <?php if($guests_chat_with == 3) echo 'checked="checked"'; ?> /> Members Only
										</label>
									</li>
								</ul>
								<p class="explain">
									Select what guest users will see in their buddy list if guest chat is enabled.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt><label>Users Chat With</label></dt>
							<dd>
								<ul>
									<li>
										<label for="chat_with_members_1">
											<input type="radio" name="users_chat_with" value="1" id="chat_with_members_1" <?php if($users_chat_with == 1) echo 'checked="checked"'; ?> /> Guests Only
										</label>
									</li>
									<li>
										<label for="chat_with_members_2">
											<input type="radio" name="users_chat_with" value="2" id="chat_with_members_2" <?php if($users_chat_with == 2) echo 'checked="checked"'; ?> /> Guests and Members
										</label>
									</li>
									<li>
										<label for="chat_with_members_3">
											<input type="radio" name="users_chat_with" value="3" id="chat_with_members_3" <?php if($users_chat_with == 3) echo 'checked="checked"'; ?> /> Members Only
										</label>
									</li>
								</ul>
								<p class="explain">
									Select what logged in users will see in their buddy list.
								</p>
							</dd>
						</dl>
					</fieldset>
					<fieldset>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="disable_avatars">
											<input type="checkbox" id="disable_avatars" name="disable_avatars" <?php if($disable_avatars == 1) echo 'checked="checked"'; ?> value="1" />
											Disable the Use of Avatars
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will disable avatars across your entire chat.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="disable_smilies">
											<input type="checkbox" id="disable_smilies" name="disable_smilies" <?php if($disable_smilies == 1) echo 'checked="checked"'; ?> value="1" />
											Disable the Use of Smilies
										</label>
									</li>
								</ul>
								<p class="explain">
									Check this to disable smilies in chat.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="us_time">
											<input type="checkbox" id="us_time" name="us_time" <?php if($us_time == 1) echo 'checked="checked"'; ?> value="1" />
											Enable AM/PM Time Format
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking will use the am/pm time format. Unchecking it will use the 24 hour time format.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="show_full_username">
											<input type="checkbox" id="show_full_username" name="show_full_username" <?php if($show_full_username == 1) echo 'checked="checked"'; ?> value="1" />
											Enable Showing Full Names
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will show the full names in chat instead of omitting things past a space.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt>
								<label for="search_number">Chat Search Threshold</label>
							</dt>
							<dd>
								<input type="text" id="search_number" class="selectionText" name="search_number" value="<?php echo $search_number; ?>" />
								<p class="explain">
									The amount of users that need to be online before the chat will show the search in the buddy list.
								</p>
							</dd>
						</dl>
					</fieldset>
					<fieldset>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="admin_chat_all">
											<input type="checkbox" id="admin_chat_all" name="admin_chat_all" <?php if($admin_chat_all == 1) echo 'checked="checked"'; ?> value="1" />
											ArrowChat Admins Can View All Online
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will allow administrators to view all online users instead of just friends. You can set a user as an admin by clicking 'Manage Users'.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="admin_view_maintenance">
											<input type="checkbox" id="admin_view_maintenance" name="admin_view_maintenance" <?php if($admin_view_maintenance == 1) echo 'checked="checked"'; ?> value="1" />
											ArrowChat Admins Ignore Maintenance Mode
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will allow administrators to still be able to use the chat bar when maintenance mode is enabled.
								</p>
							</dd>
						</dl>
					</fieldset>
					<fieldset>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="chat_maintenance">
											<input type="checkbox" id="chat_maintenance" name="chat_maintenance" <?php if($chat_maintenance == 1) echo 'checked="checked"'; ?> value="1" />
											Enable Chat Maintenance
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will disable chat on your site with a message saying it is down for maintenance.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="disable_arrowchat">
											<input type="checkbox" id="disable_arrowchat" name="disable_arrowchat" <?php if($disable_arrowchat == 1) echo 'checked="checked"'; ?> value="1" />
											Disable ArrowChat
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will completely disable ArrowChat on your site until it is unchecked again.
								</p>
							</dd>
						</dl>
					</fieldset>
					<dl class="selectionBox submitBox">
						<dt></dt>
						<dd>
							<div class="floatr">
								<a class="fwdbutton" onclick="document.forms[0].submit(); return false">
									<span>Save Changes</span>
								</a>
								<input type="hidden" name="chatsettings_submit" value="1" />
							</div>
						</dd>
					</dl>
<?php
	}
?>

<?php
	if ($do == "chatstyle") {
?>
					<script type="text/javascript">
						$(document).ready(function() {
							$( "#bar_left, #bar_right" ).sortable({
								connectWith: ".horzlist",
								axis: "x",
								items: "li:not(.ui-state-disabled)",
								placeholder: "ui-state-highlight",
								update: function() {
									var b = $(this).parent().attr('id');
									if (b == "left") {
										$(this).find('img').removeClass('border-left');
										$(this).find('img').addClass('border-right');
									} else {
										$(this).find('img').removeClass('border-right');
										$(this).find('img').addClass('border-left');
									}
								}
							}).disableSelection();
							$('#width_buddy_list').slider({
								value: <?php echo $width_buddy_list; ?>,
								min: 16,
								max: 200,
								step: 1,
								slide: function ( event, ui ) {
									$('#width_buddy_list_amt').val( ui.value );
									$('#width_buddy_list_amt2').html( ui.value );
								}
							});
							$('#width_chatrooms').slider({
								value: <?php echo $width_chatrooms; ?>,
								min: 16,
								max: 200,
								step: 1,
								slide: function ( event, ui ) {
									$('#width_chatrooms_amt').val( ui.value );
									$('#width_chatrooms_amt2').html( ui.value );
								}
							});
							$('#width_applications').slider({
								value: <?php echo $width_applications; ?>,
								min: 16,
								max: 200,
								step: 1,
								slide: function ( event, ui ) {
									$('#width_applications_amt').val( ui.value );
									$('#width_applications_amt2').html( ui.value );
								}
							});
							$('#bar_fixed_width').slider({
								value: <?php echo $bar_fixed_width; ?>,
								min: 500,
								max: 1200,
								step: 1,
								slide: function ( event, ui ) {
									$('#bar_fixed_width_amt').val( ui.value );
									$('#bar_fixed_width_amt2').html( ui.value );
								}
							});
							$('#bar_padding').slider({
								value: <?php echo $bar_padding; ?>,
								min: -2,
								max: 300,
								step: 1,
								slide: function ( event, ui ) {
									$('#bar_padding_amt').val( ui.value );
									$('#bar_padding_amt2').html( ui.value );
								}
							});
						});
					</script>
					<style type="text/css">
						.ui-state-highlight { height: 1.5em; line-height: 1.2em; border: 1px solid #000; }
						.border-right {
							border-right: 1px solid #999;
						}
						.border-left {
							border-left: 1px solid #999;
						}
						.horzlist {
							min-width: 16px;
							height: 30px;
						}
						.horzlist li
						{
							float: left;
							list-style-type: none;
							height: 30px;
							min-width: 16px;
							cursor: e-resize;
						}
						.ui-state-highlight { 
							background-color: #cecece;
							border: 1px dashed #333;
							width: 110px;
						}
						.ui-state-disabled {
							cursor: auto !important;
						}
						#left {
							float: left;
						}
						#right {
							float: right;
						}
					</style>
					<div class="subtitle">General Settings</div>
					<fieldset class="firstFieldset">
						<dl class="selectionBox">
							<dt>
								<label for="width_buddy_list">Buddy List Button Width</label>
							</dt>
							<dd>
								<div id="width_buddy_list" class="slider"></div><div id="width_buddy_list_amt2" class="slider-number"><?php echo $width_buddy_list; ?></div>
								<input type="hidden" id="width_buddy_list_amt" name="width_buddy_list" value="<?php echo $width_buddy_list; ?>" />
								<p class="explain">
									The width, in pixels, of the buddy list button. Settings this to 25px or below will display the icon only without the language file.  Default: 189
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt>
								<label for="width_chatrooms">Chat Rooms Button Width</label>
							</dt>
							<dd>
								<div id="width_chatrooms" class="slider"></div><div id="width_chatrooms_amt2" class="slider-number"><?php echo $width_chatrooms; ?></div>
								<input type="hidden" id="width_chatrooms_amt" name="width_chatrooms" value="<?php echo $width_chatrooms; ?>" />
								<p class="explain">
									The width, in pixels, of the chat room button. Settings this to 25px or below will display the icon only without the language file.  Default: 16
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt>
								<label for="width_applications">Applications Button Width</label>
							</dt>
							<dd>
								<div id="width_applications" class="slider"></div><div id="width_applications_amt2" class="slider-number"><?php echo $width_applications; ?></div>
								<input type="hidden" id="width_applications_amt" name="width_applications" value="<?php echo $width_applications; ?>" />
								<p class="explain">
									The width, in pixels, of the applications button. Settings this to 25px or below will display the icon only without the language file.  Default: 16
								</p>
							</dd>
						</dl>
					</fieldset>
					<fieldset>
						<dl class="selectionBox">
							<dt></dt>
							<dd>
								<ul>
									<li>
										<label for="bar_fixed">
											<input type="checkbox" id="bar_fixed" name="bar_fixed" <?php if($bar_fixed == 1) echo 'checked="checked"'; ?> value="1" />
											Enable Fixed Width Bar
										</label>
									</li>
								</ul>
								<p class="explain">
									Checking this will make the bar a fixed width instead of fluid (growing and shrinking with window size).
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt><label>Fixed Bar Alignment</label></dt>
							<dd>
								<ul>
									<li>
										<label for="bar_fixed_alignment_1">
											<input type="radio" name="bar_fixed_alignment" value="left" id="bar_fixed_alignment_1" <?php if($bar_fixed_alignment == "left") echo 'checked="checked"'; ?> /> Left
										</label>
									</li>
									<li>
										<label for="bar_fixed_alignment_2">
											<input type="radio" name="bar_fixed_alignment" value="center" id="bar_fixed_alignment_2" <?php if($bar_fixed_alignment == "center") echo 'checked="checked"'; ?> /> Center
										</label>
									</li>
									<li>
										<label for="bar_fixed_alignment_3">
											<input type="radio" name="bar_fixed_alignment" value="right" id="bar_fixed_alignment_3" <?php if($bar_fixed_alignment == "right") echo 'checked="checked"'; ?> /> Right
										</label>
									</li>
								</ul>
								<p class="explain">
									If a fixed bar is enabled, choose whether it is left, center, or right aligned.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt>
								<label for="bar_fixed_width">Fixed Bar Width</label>
							</dt>
							<dd>
								<div id="bar_fixed_width" class="slider"></div><div id="bar_fixed_width_amt2" class="slider-number"><?php echo $bar_fixed_width; ?></div>
								<input type="hidden" id="bar_fixed_width_amt" name="bar_fixed_width" value="<?php echo $bar_fixed_width; ?>" />
								<p class="explain">
									If a fixed bar is enabled, enter the width of the bar in pixels.
								</p>
							</dd>
						</dl>
						<dl class="selectionBox">
							<dt>
								<label for="bar_padding">Bar Padding</label>
							</dt>
							<dd>
								<div id="bar_padding" class="slider"></div><div id="bar_padding_amt2" class="slider-number"><?php echo $bar_padding; ?></div>
								<input type="hidden" id="bar_padding_amt" name="bar_padding" value="<?php echo $bar_padding; ?>" />
								<p class="explain">
									Enter the number, in pixels, that the bar should appear from the left and right edges of the window.  Default: 15
								</p>
							</dd>
						</dl>
					</fieldset>
					<dl class="selectionBox submitBox">
						<dt></dt>
						<dd>
							<div class="floatr">
								<a class="fwdbutton" onclick="document.forms[0].submit(); return false">
									<span>Save Changes</span>
								</a>
								<input type="hidden" name="chatstyle_submit" value="1" />
							</div>
						</dd>
					</dl>
					<!--
					<table cellspacing="0" cellpadding="0" class="module_table">
						<tr>
							<td colspan="2" style="font-size: 11px;">
								<span style="font-size: 14px;">Placement Editor</span><br />
								Drag and drop the features on the bar anywhere you want.  Each item must either float on the left or the right side.  The buddy list cannot be moved.  Features that are not enabled will not show up!<br /><br /><br /><br />
								<div id="placement_bar" style="width: 680px; height: 30px; border-left: 1px solid #999; border-right: 1px solid #999; border-top: 1px solid #999; background: url(images/images_core.png);">
									<div id="left">
										<ul id="bar_left" class="horzlist">
											<li class="ui-state-default" id="move_6"><img title="Bar Links" id="img_6" class="list_image border-right" src="images/button_barlinks.png" /></li>
											<li class="ui-state-default" id="move_1"><img title="Applications" id="img_1" class="list_image border-right" src="images/button_applications.png" /></li>

										</ul>
									</div>
									<div id="right">
										<ul id="bar_right" class="horzlist">
											<li class="ui-state-default ui-state-disabled" id="move_5"><img title="Buddy List Cannot Be Moved" id="img_5" class="list_image border-left" src="images/button_chat.png" /></li>
											<li class="ui-state-default" id="move_2"><img title="Chatrooms" id="img_2" class="list_image border-left" src="images/button_chatrooms.png" /></li>
											<li class="ui-state-default" id="move_3"><img title="Notifications" id="img_3" class="list_image border-left" src="images/button_notifications.png" /></li>
											<li class="ui-state-default" id="move_4"><img title="Hide/Show Bar" id="img_4" class="list_image border-left" src="images/button_hide.png" /></li>

										</ul>
									</div>
								</div>
								<br /><br />
							</td>
						</tr>
					</table>
					-->
<?php
	}
?>

					
					</form>

				</div>
			</div>