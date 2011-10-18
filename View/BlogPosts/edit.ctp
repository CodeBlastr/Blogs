<h2><?php __('Edit a Post'); ?></h2>
<div id="blogPosts-edit" class="blogPosts edit">
	<?php
	echo $this->Form->create('BlogPost');
	echo $this->Form->input('BlogPost.user_id',array('value' => $this->Session->read('Auth.User.id'), 'type'=>'hidden'));
	echo $this->Form->input('BlogPost.id', array('value' => $blogPost['BlogPost']['id']));
	echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true), 'value' => $blogPost['BlogPost']['title']));
	echo $this->Form->input('BlogPost.text', array('label' => '', 'value' => $blogPost['BlogPost']['text'], 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	echo $this->Form->end('Save');
	?>
</div>