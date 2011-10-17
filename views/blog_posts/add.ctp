<h2><?php __('Create a Post'); ?></h2>
<div id="blogPosts-add" class="blogPosts add">
	<?php
	echo $form->create('BlogPost');
	echo $form->input('BlogPost.user_id',array('value' => $this->Session->read('Auth.User.id'), 'type'=>'hidden'));
	echo $form->input('BlogPost.blog_id',array('value'=>$this->params['named']['blog_id'],'type'=>'hidden'));
	echo $form->input('BlogPost.title', array('label' => __('Post Title', true)));
	echo $form->input('BlogPost.text', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	echo $form->end('Add');
	?>
</div>