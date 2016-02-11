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

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('jquery-1.9.1');
		echo $this->fetch('script');
		
	?>
	<script type="text/javascript">
		$(function() {
		
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="logo"><?php echo $this->Html->link($this->Html->image('globeloop_logo.png', array('alt' => $cakeDescription, 'border' => '0', 'width' => '270', 'height' => '45')), '/', array('escape' => false)); ?></div>
			<?php echo $this->element('headerbar') ?>
		</div>
		<div id="content">
			
			<?php echo $this->Session->flash() ?>
			
			<?php echo $this->fetch('content') ?>
			
			<br style="clear: both">
			
		</div>
		<div id="footer">
			
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
