<h2><?php __('Edit a Post'); ?></h2>
<div id="blogPosts-edit" class="blogPosts edit">
	<?php
	echo $form->create('BlogPost');
	echo $form->input('BlogPost.user_id',array('value' => $this->Session->read('Auth.User.id'), 'type'=>'hidden'));
	echo $form->input('BlogPost.id', array('value' => $blogPost['BlogPost']['id']));
	echo $form->input('BlogPost.title', array('label' => __('Post Title', true), 'value' => $blogPost['BlogPost']['title']));
	echo $form->input('BlogPost.text', array('label' => '', 'value' => $blogPost['BlogPost']['text'], 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	echo $form->end('Save');
	?>
</div>