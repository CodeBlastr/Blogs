<div class="row">
	<?php echo $this->Form->create('BlogPost', array('type' => 'file', 'novalidate'));?>
	<div id="blogPosts-add" class="blogPosts col-md-8 add form">
	    <?php echo $this->Form->hidden('BlogPost.blog_id', array('value' => $blogId)); ?>
		<?php echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true))); ?>
		<?php echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext')); ?>
		<?php echo $this->Form->submit('Add');?>
	</div>
	<div class="col-md-4">
		<?php echo $this->Element('forms/alias', array('formId' => '#BlogPostAddForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/', 'dataDisplay' => '[for=BlogPostTitle]')); // must have the alias behavior attached to work  ?>
		<?php echo $this->Form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Featured Image')); ?>
		<fieldset>
			<legend class="toggleClick"><?php echo __('Publish Settings'); ?></legend>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.published', array('type' => 'datetimepicker', 'label' => 'Publish Date', 'default' => date('Y-m-d h:i:s'))); ?>
		</fieldset>
	    <?php if (in_array('Categories', CakePlugin::loaded())) : ?>	
		<fieldset>
	        <legend class="toggleClick"><?php echo __('Categories');?></legend>
			<?php echo $this->Form->input('Category', array('multiple' => 'checkbox', 'label' => false)); ?>
	    </fieldset>
	    <?php endif; ?>
	    <?php if (in_array('Tags', CakePlugin::loaded())) : ?>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Tags');?></legend>
				<?php echo $this->Form->input('tags', array('label' => 'Enter comma separated tags ('.$this->Html->link('view tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')).' ).')); ?>
		</fieldset>
	    <?php endif; ?>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Discussion');?></legend>
			<?php echo $this->Form->input('allow_comments'); ?>
		</fieldset>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Author');?></legend>
				<?php echo $this->Form->input('BlogPost.author_id', array('label' => false, 'value' => $this->Session->read('Auth.User.id'))); ?>
		</fieldset>
	</div>
	<?php echo $this->Form->end();?>
</div>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			 $this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'view', $blogId)),
			 )
		)
	)));