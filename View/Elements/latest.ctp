<?php
// element options defaults
$moduleTitle = isset($moduleTitle) ? $moduleTitle : 'Latest Posts';
$numberOfPosts = !empty($numberOfPosts) ? $numberOfPosts : 5;
$blogId = !empty($blogID) ? $blogID : $blogId; // deprecated variable name 2013-08 RK
$blogId = !empty($blogId) ? $blogId : 1;
$latestPosts = $this->requestAction('/blogs/blog_posts/latest/blog_id:'.$blogId.'/limit:'.$numberOfPosts); ?>

<div id="ELEMENT_BLOGS_LATEST_<?php echo $instance ?>" class="blogs latest element">
	<h3 class="module title">
		<?php echo $moduleTitle ?>
	</h3>
	<ul>
    	<?php foreach ($latestPosts as $post) : ?>
		<li>
			<?php echo $this->Html->link($post['BlogPost']['title'], array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $post['BlogPost']['id'])); ?>
			<small>
				<?php echo $post['BlogPost']['text']; ?>
			</small>
		</li>
		<?php endforeach; ?>
    </ul>
</div>
