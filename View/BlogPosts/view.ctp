<h2><?php echo $blogPost['BlogPost']['title'] ?></h2>    
<div class="blogPosts view" id="blogPost_<?php $blogPost['BlogPost']['id']; ?>">
	<div class="blog-post-sub-header">By <?php echo $blogPost['User']['username']; ?>  | Last updated <?php echo $blogPost['BlogPost']['modified'] ?></div>
	<div class="blog-post-body"><?php echo $blogPost['BlogPost']['text']; ?></div>
	<a name="comments"></a>
	<div id="post-comments">
		<?php $this->CommentWidget->options(array('allowAnonymousComment' => false));?>
		<?php echo $this->CommentWidget->display();?>
	</div>
</div>
<?php 
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog',
		'items' => array(
			 $this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'index',)),
			$this->Html->link(__('Edit', true), array('controller' => 'blog_posts', 'action' => 'edit', $blogPost['BlogPost']['id']), array('class' => 'edit')),
			)
		)
	))); ?>
