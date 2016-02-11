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
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('style');
		echo $this->Html->css('shops');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('jquery-1.9.1');
		echo $this->Html->script('jquery.jqdock.min');
		echo $this->fetch('script');
		
	?>
	<script type="text/javascript">
		$(function() {			
		    $('#leftsidebar').hide();

		    // grab the initial top offset of the navigation 
		    var sticky_header_offset_top = $('#header').offset().top;
		    var sticky_leftsidebar_offset_top = $('#header').offset().top;
		    
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
			
		    // run our function on load
		    sticky_header();
		    sticky_leftsidebar();
		    
		    // and run it again every time you scroll
		    $(window).scroll(function() {
			 sticky_header();
			 sticky_leftsidebar();
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
		    
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="logo"><div style="position: absolute; left: 60px; top: 5px; z-index: -1"><img src="/img/spinning_globe.gif" /></div><?php echo $this->Html->link($this->Html->image('globeloop_logo.gif', array('alt' => $cakeDescription, 'border' => '0', 'width' => '270', 'height' => '45')), '/', array('escape' => false)); ?></div>
			<?php echo $this->element('headerbar') ?>
		</div>

		<?php echo $this->element('leftsidebar-shops') ?>

		<div id="content">
			
			<?php echo $this->Session->flash() ?>
			
			<?php echo $this->element('main_nav_menu') ?>
			
			<?php echo '<div id="contentarea"><div class="title">' . $title . '</div>' . $this->element('heading_subcat') . $this->fetch('content') . '</div>' ?>
			
			<br style="clear: both">
				
			<?php echo $this->element('footerbar') ?>

		</div>

	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
