<div class="row blogs blog-posts add">
	<div class="form col-md-8">
	<?php echo $this->Form->create('BlogPost'); ?>
    <?php echo $this->Form->input('BlogPost.id'); ?>
	<?php echo $this->Form->hidden('BlogPost.blog_id'); ?>
	<?php echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true))); ?>
	<?php echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext')); ?>
	<?php echo CakePlugin::loaded('Media') ? __('<hr>%s<hr>', $this->Element('Media.selector', array('media' => $this->request->data['Media'], 'multiple' => true))): null; ?>
	<?php echo $this->Form->submit('Edit');?>
	</div>
	<div class="col-md-4">
		<?php echo $this->element('forms/alias', array('formId' => '#BlogPostAddForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/', 'dataDisplay' => '[for=BlogPostTitle]')); // must have the alias behavior attached to work  ?>
		<fieldset>
	        <legend class="toggleClick"><?php echo __('SEO Optimization');?></legend>
			<?php echo $this->Form->input('Alias.title', array('type' => 'text')); ?>
			<?php echo $this->Form->input('Alias.keywords', array('type' => 'text')); ?>
			<?php echo $this->Form->input('Alias.description', array('type' => 'textarea')); ?>
	    </fieldset>
		<fieldset>
			<legend class="toggleClick"><?php echo __('Publish Settings'); ?></legend>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.published', array('type' => 'datetimepicker', 'label' => 'Publish Date')); ?>
			<?php echo $this->Form->input('BlogPost.allow_comments'); ?>
		</fieldset>
	    <?php if (CakePlugin::loaded('Categories')) : ?>	
		<fieldset>
	        <legend class="toggleClick"><?php echo __('Categories');?></legend>
	        <?php foreach ($categories as $categoryId => $categoryName) : ?>
	        	<?php $checked = in_array($categoryId, $selectedCategories) ? 'checked' : false; ?>
	        	<?php echo $this->Form->input('', array('checked' => $checked, 'type' => 'checkbox', 'name' => 'data[Category][Category][]', 'value' => $categoryId, 'id' => 'Category' . $categoryId, 'label' => $categoryName)); ?>
			<?php endforeach; ?>
	    </fieldset>
	    <?php endif; ?>
	    <?php if (CakePlugin::loaded('Tags')) : ?>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Tags');?></legend>
				<?php echo $this->Form->input('tags', array('label' => 'Enter comma separated tags ('.$this->Html->link('view tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')).' ).')); ?>
		</fieldset>
	    <?php endif; ?>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Author');?></legend>
				<?php echo $this->Form->input('BlogPost.author_id', array('label' => false)); ?>
		</fieldset>
	</div>
	<?php echo $this->Form->end();?>
</div>
<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('Blogs Dashboard'), '/admin/blogs/blogs/dashboard/' . $this->request->data['BlogPost']['blog_id']),
	$this->Html->link(__('%s Dashboard', $this->request->data['Blog']['title']), '/admin/blogs/blogs/dashboard/' . $this->request->data['BlogPost']['blog_id']),
	$page_title_for_layout,
)));
    
// set the contextual menu items
$this->set('context_menu', array('menus' => array(array(
	'heading' => 'Blog Posts',
	'items' => array(
		$this->Html->link(__('View'), array('admin' => false, 'plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $this->request->data['BlogPost']['id'])),
		$this->Html->link(__('List'), array('controller' => 'blogs', 'action' => 'index')),
		$this->Html->link(__('Add'), array('controller' => 'blog_posts', 'action' => 'add', $this->request->data['BlogPost']['blog_id'])),
		$this->Html->link(__('Delete'), array('controller' => 'blog_posts', 'action' => 'delete', $this->Form->value('BlogPost.id')), null, __('Are you sure you want to delete %s?', $this->Form->value('BlogPost.title')))
		)
	))));
