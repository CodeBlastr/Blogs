<div id="blogs-edit" class="blogs edit">
	<?php
	echo $this->Form->create('Blog');
	echo $this->Form->input('Blog.id');
	echo $this->Form->input('Blog.title');
	echo $this->Form->input('Alias.id');
	echo $this->Form->input('Alias.name', array('label' => 'Permanent Url'));
	echo $this->Form->input('Alias.title', array('label' => 'SEO Title'));
	echo $this->Form->input('Alias.keywords', array('label' => 'SEO Keywords'));
	echo $this->Form->input('Alias.description', array('label' => 'SEO Description'));
	echo $this->Form->end('Save');
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