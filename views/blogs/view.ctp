<h1><?php echo $blog['Blog']['title']; ?></h1>
<div id="blogs-blogs-view" class="blogs view">
	<div id="blog-posts">
		<?php
		if(count($blogPosts)) {
			foreach($blogPosts as $blogPost) {
		?>
		<div class="blogPost" id="post_<?php $blogPost['BlogPost']['id']; ?>">
			<h2><?php echo $this->Html->link($blogPost['BlogPost']['title'], array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $blogPost['BlogPost']['id'])); ?></h2>
			<div class="blog-post-sub-header">By <?php echo $blogPost['User']['username'] ?>  | Last updated <?php echo $blogPost['BlogPost']['modified'] ?></div>
			<div class="blog-post-body">
				<?php
				$blogPost['BlogPost']['text'] = explode('<!-- pagebreak -->',$blogPost['BlogPost']['text']);
				echo $text->truncate(strip_tags($blogPost['BlogPost']['text'][0]), 250, array('ending' => '...', 'html' => false));
				?>
			</div>
			<div class="blog-post-footer">
            <?php echo $this->Html->link(__('View Full Post', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $blogPost['BlogPost']['id'])); ?>
            </div>
		</div>
		<?php
			}
		} else {
		?>
		<div>There are currently no blog posts</div>
		<?php } ?>
	</div>
</div>
<?php
if($blog['Blog']['user_id'] == $this->Session->read('Auth.User.id')) {
$this->Menu->setValue(array(
	array('heading' => 'Blog',
		'items' => array(
			$this->Html->link(__('Add Blog Entry', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'add', 'blog_id' => $blog['Blog']['id']), array('checkPermissions' => true)),
			)
		)
	));
} ?>
