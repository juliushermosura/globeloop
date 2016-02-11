<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Globeloop');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>

	<link type="text/css" rel="stylesheet" id="arrowchat_css" media="all" href="/arrowchat/external.php?type=css" charset="utf-8" />

	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('style');
		echo $this->Html->css('users');
		echo $this->Html->css('jquery.qtip.min');
		echo $this->Html->css('perfect-scrollbar.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('jquery-1.9.1');
		echo $this->Html->script('jquery-migrate-1.2.1.min');
		echo $this->Html->script('jquery.qtip.min');
		echo $this->Html->script('jquery.jqdock.min');
		echo $this->Html->script('perfect-scrollbar.with-mousewheel.min');
		echo $this->fetch('script');
		
	?>
	<script type="text/javascript">
		$(function() {
		    $('#leftsidebar').hide();

		    // grab the initial top offset of the navigation 
		    var sticky_header_offset_top = $('#header').offset().top;
		    var sticky_leftsidebar_offset_top = $('#header').offset().top;
		    //var sticky_adsidebar_offset_top = $('#header').offset().top + 205;
		    
		    // our function that decides weather the navigation bar should have "fixed" css position or not.
		    var sticky_header = function(){
			var scroll_top = $(window).scrollTop(); // our current vertical position from the top
			
			// if we've scrolled more than the navigation, change its position to fixed to stick to top,
			// otherwise change it back to relative
			if (scroll_top > sticky_header_offset_top) {
			    $('#header').css({ 'position': 'fixed', 'top':0, 'left':0, 'width':'100%' });
			    //$('#headerbar').css({ 'width':'700', 'position':'absolute', 'right':'20px' });
			    if ($('#leftsidebar').is(':visible')) {
				$('#content').css({ 'top':70, 'left':49, 'min-width':963 });
			    } else {
				$('#content').css({ 'top':70, 'left':30, 'min-width':1030 });
			    }
			} else {
			    $('#header').css({ 'position': 'relative', 'width':'100%' });
			    if ($('#leftsidebar').is(':visible')) {
				$('#content').css({ 'top':0, 'left':0, 'min-width':963 });
			    } else {
				$('#content').css({ 'top':0, 'left':30, 'min-width':1030 });
			    }
			    $('#headerbar').css({ 'width':'700px', 'position':'relative', 'right':'0' });
			}
		    };
		    
		    var sticky_leftsidebar = function(){
			var scroll_top = $(window).scrollTop(); // our current vertical position from the top
			
			// if we've scrolled more than the navigation, change its position to fixed to stick to top,
			// otherwise change it back to relative
			/*if (scroll_top > sticky_leftsidebar_offset_top) { 
			    $('#leftsidebar').css({ 'position': 'fixed', 'top':70, 'left':0 });
			} else {
			    $('#leftsidebar').css({ 'position': 'relative', 'top':0 }); 
			}*/
		    };
		    
		    /*var sticky_adsidebar = function(){
			var scroll_top = $(window).scrollTop(); // our current vertical position from the top
			
			// if we've scrolled more than the navigation, change its position to fixed to stick to top,
			// otherwise change it back to relative
			if (scroll_top > sticky_adsidebar_offset_top) { 
			    $('#adsidebar').css({ 'position': 'fixed', 'top':30, 'right':190 });
			} else {
			    $('#adsidebar').css({ 'position': 'relative', 'top':0, 'right':5 }); 
			}
		    };*/
		
		    // run our function on load
		    sticky_header();
		    sticky_leftsidebar();
		    //sticky_adsidebar();
		    
		    // and run it again every time you scroll
		    $(window).scroll(function() {
			 sticky_header();
			 sticky_leftsidebar();
			 //sticky_adsidebar();
		    });
		    
		    $('#menu').mouseenter(function() {
			$(this).hide();
			var scroll_top = $(window).scrollTop();
			$('#leftsidebar').show();
			/*if ($('#adsidebar').is(':visible')) {
				//$('#content').css({ 'top':0, 'left':0, 'min-width': 1011 });
				//$('#contentarea').css({ 'min-width': 811 });
				//if (scroll_top > sticky_leftsidebar_offset_top) {
				//	$('#content').css({ 'left':49 });
				//}
			} else {
				$('#content').css({ 'top':0, 'left':0, 'min-width': 968 });
				$('#contentarea').css({ 'min-width': 946 });
				if (scroll_top > sticky_leftsidebar_offset_top) {
					$('#content').css({ 'left':49 });
				}
			}*/
			
		    });
		    
		    $('#leftsidebar').mouseleave(function() {
			$('#menu').show();
			var scroll_top = $(window).scrollTop();
			$('#leftsidebar').hide();
			/*if ($('#adsidebar').is(':visible')) {
				$('#content').css({ 'top':0, 'left':30, 'min-width': 1030 });
				$('#contentarea').css({ 'min-width': 830 });
			} else {
				$('#content').css({ 'top':0, 'left':30, 'min-width': 1030 });
				//$('#contentarea').css({ 'min-width': 1008 });
			}*/
		    });
		    
		    $('#online_viewPort').perfectScrollbar();
		    
		    $.fn.qtip_loader = function() {
		    	$('a[href*="/users/view/"][rel]').each(function() {
				$(this).qtip({
					content: {
						text: '<img src="/img/ajax-loader.gif" alt="Loading..." />',
						ajax: {
							url: $(this).prop('rel'), // Use the rel attribute of each element for the url to load
							once: false
						},
						title: {
							text: 'Globeloop - ' + $(this).text(), // Give the tooltip a title using each elements text
							button: true
						}
					},
					position: {
						at: 'bottom center', // Position the tooltip above the link
						my: 'top center',
						viewport: $(window), // Keep the tooltip on-screen at all times
						effect: false // Disable positioning animation
					},
					show: {
						event: 'mouseenter',
						solo: true // Only show one tooltip at a time
					},
					hide: 'unfocus',
					style: {
						classes: 'qtip-wiki qtip-light qtip-shadow'
					}
				})
			}).click(function(event) { event.preventDefault(); });
		    };
			
			$('#body').on('click', '.btn_friend_request', function() {
				var e = $(this);
				if ($(this).parent().hasClass('btn_disabled') == false) {
				    $.ajax({
					type: 'POST',
					url: '/users/send_friend_request/' + $(this).prop('rel')
				    }).done(function( msg ) {
					e.text('Sent friend request');
					e.prop('href', '');
					e.parent().addClass('btn_disabled');
				    }).fail(function() {
					return true;
				    });
				}
				return false;
			});
			
			$('#body').on('click', '.btn_friend_request_2', function() {
				var e = $(this);
				if ($(this).parent().hasClass('btn_disabled') == false) {
				    $.ajax({
					type: 'POST',
					url: '/users/accept_friend_request/' + $(this).prop('rel')
				    }).done(function( msg ) {
					e.parents('.user_search_details').remove();
				    }).fail(function() {
					return true;
				    });
				}
				return false;
			});
			
			$('#body').on('click', '.add_remove_selections', function() {
				var action;
				if ($(this).hasClass('add')) {
				    $(this).removeClass('add');
				    $(this).addClass('remove');
				    $(this).prop('title', 'Remove to Selection');
				    $(this).children('.selectionMarker').text('-');
				    action = 1;
				} else {
				    var ans = confirm('This will remove your friend from the news feeds on your Selections page.');
				    if (ans) {
					$(this).removeClass('remove');
					$(this).addClass('add');
					$(this).prop('title', 'Add to Selection');
					$(this).children('.selectionMarker').text('+');
					action = 0;
				    }
				}
				$.ajax({
				    type: 'POST',
				    url: '/users/add_remove_selections/',
				    data: {id: $(this).prop('id').replace('friend-', ''), action: action}
				}).done(function(msg) {
				    if (msg == 'failed') {
					alert('Oops! Something went wrong during adding your friend to Selections. Please reload the page and try again later.');
				    }
				}).fail(function() {
				    location.reload();
				});
				return false;
			});
		    
			$(this).qtip_loader();
			
		});
		
			var buddy = '';
			
			window.setInterval(function(){
			<?php foreach($onlinebuddies as $friend): ?>
				buddy = {'name': '<?php echo $friend['UserTo']['full_name'] ?>', 'id': '<?php echo $friend['UserTo']['id'] ?>'};
				<?php echo "jqac.arrowchat.getUser('" . $friend['UserTo']['id'] . "', 'userdetails', buddy); " ?>           
			<?php endforeach ?>
			}, 5000);
			
			function userdetails(data, bud) {
				if (data.s == 'available' || data.s == 'away' || data.s == 'busy') {
					if ($('.online_canvas li').hasClass('buddy-' + bud.id)) {
						//do nothing
					} else {
						//append user name
						$('.online_canvas').append('<li class="buddy-'+ bud.id +'"><a href="javascript:;" onClick="jqac.arrowchat.chatWith(\'' + bud.id + '\');">'+ bud.name +'</a></li>');
					}
				} else {
					$('.online_canvas li').remove('.buddy-' + bud.id);
				}
			}
	</script>
</head>
<body id="body">
	<div id="container">
		<div id="header">
			<div id="logo"><div style="position: absolute; left: 60px; top: 5px; z-index: -1"><img src="/img/spinning_globe.gif" /></div><?php echo $this->Html->link($this->Html->image('globeloop_logo.gif', array('alt' => $cakeDescription, 'border' => '0', 'width' => '270', 'height' => '45')), '/', array('escape' => false)); ?></div>
			<?php echo $this->element('headerbar') ?>
		</div>
		<?php echo $this->element('leftsidebar-professionals') ?>
		
		<div id="content">
			
			<?php echo $this->Session->flash() ?>
			
			<?php echo $this->element('main_nav_menu') ?>
			
			<?php echo '<div id="contentarea"><div class="title">' . $title . '</div>' . $this->fetch('content') . $this->element('adsidebar') . '</div>' ?>
		
			<br style="clear: both">
					<?php echo $this->element('footerbar') ?>

		</div>
		<?php echo $this->element('rightsidebar') ?>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
