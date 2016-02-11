<div class="subcat">

<?php echo $this->Html->link('All', array('controller' => 'shops', 'action' => $this->params['action'], 'all'), array('escape' => false)); ?>

<?php foreach ($subcats as $sc): ?>

<?php echo ' | ' . $this->Html->link($sc['Category']['name'], array('controller' => 'shops', 'action' => $this->params['action'], strtolower(Inflector::slug($sc['Category']['name']))), array('escape' => false)); ?>

<?php endforeach ?>

</div>