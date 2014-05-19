<?php // used in tymtractor ?>
<?php $BlogPostHelper = $this->Helpers->load('Blogs.BlogPost'); ?>
<?php $posts = $BlogPostHelper->find('all', array('limit' => 3)); ?>
<div class="blog-posts-find">
<?php foreach ($posts as $post) : ?>
	<div class="media clearfix"> 
		<a class="pull-left" href="<?php echo $this->Html->url(array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $post['BlogPost']['id'])); ?>"> 
			<?php echo $this->Media->display($post['Media'][0]); ?>
		</a>
		<div class="media-body">
			
			<a href="<?php echo $this->Html->url(array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $post['BlogPost']['id'])); ?>"><h4 class="media-heading"><?php echo $post['BlogPost']['title']; ?></h4></a>
			<p>
				<?php echo $this->Text->truncate($post['BlogPost']['text'], '300', array('ellipsis' => '...', 'exact' => false)); ?>
			</p>
		</div>
	</div>
	<hr />
<?php endforeach; ?>
</div>
