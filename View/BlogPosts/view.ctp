<?php
echo __('<div class="blogPosts view" id="blogPost_%s">', $blogPost['BlogPost']['id']);
echo $this->Html->tag('h1', $blogPost['BlogPost']['title']);
echo __('<div class="blog-post-sub-header well"> By %s | Added %s</div>', $blogPost['Author']['first_name'], ZuhaInflector::datify($blogPost['BlogPost']['published'])); 
echo __('<div class="blog-post-body">%s %s</div>', $this->Element('Galleries.thumb', array('model' => 'BlogPost', 'foreignKey' => $blogPost['BlogPost']['id'], 'showEmpty' => false)), $blogPost['BlogPost']['text']); 

if ($blogPost['BlogPost']['allow_comments'] == 1 && in_array('Comments', CakePlugin::loaded())) {
	__('<a name="comments"></a><div id="post-comments">%s %s</div>', $this->CommentWidget->options(array('allowAnonymousComment' => false)), $this->CommentWidget->display());
}
echo __('</div>'); 
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog',
		'items' => array(
		    $this->Html->link(__('Add', true), array('controller' => 'blog_posts', 'action' => 'add', $blogPost['BlogPost']['blog_id']), array('class' => 'add')),
			$this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'index',)),
			$this->Html->link(__('Edit', true), array('controller' => 'blog_posts', 'action' => 'edit', $blogPost['BlogPost']['id']), array('class' => 'edit')),
			)
		)
	))); ?>
