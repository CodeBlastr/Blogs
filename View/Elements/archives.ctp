<?php $BlogPostHelper = $this->Helpers->load('Blogs.BlogPost', $___dataForView); ?>
<?php $blogPosts = $BlogPostHelper->find('all', array('fields' => array('blog_id', 'published'), 'group' => array('MONTH(published)'), 'callbacks' => false)); ?>
<?php if (!empty($blogPosts)) : ?>
 	<ul class="unstyled">
	<?php foreach ($blogPosts as $blogPost) : ?>
		<li><?php echo $this->Html->link(ZuhaInflector::datify($blogPost['BlogPost']['published'], array('format' => 'F')), array('plugin' => 'blogs','controller' => 'blogs', 'action' => 'view', $blogPost['BlogPost']['blog_id'], 'range' => 'published:' . ZuhaInflector::datify($blogPost['BlogPost']['published'], array('format' => 'Y-m-01')))); ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>