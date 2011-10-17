<h2><?php echo $blogPost['BlogPost']['title'] ?></h2>    
<div class="blogPosts view" id="blogPost_<?php $blogPost['BlogPost']['id']; ?>">
	<div class="blog-post-sub-header">By <?php echo $blogPost['User']['username']; ?>  | Last updated <?php echo $blogPost['BlogPost']['modified'] ?></div>
	<div class="blog-post-body"><?php echo $blogPost['BlogPost']['text']; ?></div>
	<a name="comments"></a>
	<div id="post-comments">
		<?php $commentWidget->options(array('allowAnonymousComment' => false));?>
		<?php echo $commentWidget->display();?>
	</div>
</div>
<?php 
$menu->setValue(array(
	array(
		'heading' => 'Blog',
		'items' => array(
			 $this->Html->link(__('Blogs Index', true), array('controller' => 'blogs', 'action' => 'index',)),
			$this->Html->link(__('Edit Post', true), array('controller' => 'blog_posts', 'action' => 'edit', $blogPost['BlogPost']['id'])),
			)
		)
	));
?>
