<div class="blogPosts view" id="blogPost_<?php echo $blogPost['BlogPost']['id']; ?>">
	<h1>
		<?php echo $blogPost['BlogPost']['title']; ?>
	</h1>
	<div class="blog-post-sub-header well">
		<p>
			By <?php echo $blogPost['Author']['first_name']; ?> | Added <?php echo ZuhaInflector::datify($blogPost['BlogPost']['published']); ?>
		</p>
	</div>
	<div class="blog-post-body media">
		<?php echo $this->Element('Galleries.thumb', array('thumbClass' => 'pull-left', 'model' => 'BlogPost', 'foreignKey' => $blogPost['BlogPost']['id'], 'showEmpty' => false)); ?>
		<div class="media-body">
			<?php echo $blogPost['BlogPost']['text']; ?>
		</div>
	</div>
	
<?php
if ($blogPost['BlogPost']['allow_comments'] == 1 && in_array('Comments', CakePlugin::loaded())) :
	__('<a name="comments"></a><div id="post-comments">%s %s</div>', $this->CommentWidget->options(array('allowAnonymousComment' => false)), $this->CommentWidget->display());
endif; ?>

</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link($blogPost['Blog']['title'], '/blogs/blogs/view/' . $blogPost['Blog']['id']),
	$blogPost['BlogPost']['title'],
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog',
		'items' => array(
		    $this->Html->link(__('Add', true), array('controller' => 'blog_posts', 'action' => 'add', $blogPost['BlogPost']['blog_id']), array('class' => 'add')),
			$this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'index',)),
			$this->Html->link(__('Edit', true), array('controller' => 'blog_posts', 'action' => 'edit', $blogPost['BlogPost']['id']), array('class' => 'edit')),
			)
		)
	)));
