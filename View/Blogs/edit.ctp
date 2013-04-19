<div id="blogs-edit" class="blogs edit">
	<?php
	echo $this->Form->create('Blog');
	echo $this->Form->input('Blog.id');
	echo $this->Form->input('Blog.title');
	echo $this->Form->end('Edit');
	?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blogs',
		'items' => array(
			 $this->Html->link(__('List'), array('controller' => 'blogs', 'action' => 'index')),
			 )
		)
	))); ?>