<h1><?php echo __('Create a Blog'); ?></h1>
<div id="blogs-add" class="blogs add">
	<?php
	echo $this->Form->create('Blog');
	echo $this->Form->input('Blog.title');
	echo $this->Form->input('Blog.owner_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	echo $this->Form->end('Add');
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