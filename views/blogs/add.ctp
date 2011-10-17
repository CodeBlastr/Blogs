<h1><?php __('Create a Blog'); ?></h1>
<div id="blogs-add" class="blogs add">
	<?php
	echo $form->create('Blog');
	echo $form->input('Blog.title');
	echo $form->input('Blog.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	echo $form->end('Add');
	?>
</div>