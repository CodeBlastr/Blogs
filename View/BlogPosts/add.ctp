<h2><?php echo __('Create a Post'); ?></h2>
<div id="blogPosts-add" class="blogPosts add">
	<?php
	echo $this->Form->create('BlogPost');
	echo $this->Form->input('BlogPost.user_id', array('value' => $this->Session->read('Auth.User.id'), 'type'=>'hidden'));
	echo $this->Form->hidden('BlogPost.blog_id', array('value' => $blogId));
	echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true)));
	echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	echo $this->Form->end('Add');
	?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			 $this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'view', $blogId)),
			 )
		)
	))); ?>