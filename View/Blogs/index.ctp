<?php
echo $this->Element('scaffolds/index', array('data' => $blogs)); 

$this->set('context_menu', array('menus' => array(
	array('heading' => 'Blogs',
		'items' => array(
			 $this->Html->link(__('Add', true), array('controller' => 'blogs', 'action' => 'add'), array('class' => 'add')),
			 )
		)
	))); ?>
