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
		<fieldset>
			<legend class="toggleClick"><?php echo __('Publish Settings'); ?></legend>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.published', array('type' => 'datetimepicker', 'label' => 'Publish Date')); ?>
		</fieldset>
		<fieldset>
	        <legend class="toggleClick"><?php echo __('SEO Optimization');?></legend>
			<?php echo $this->Form->input('Alias.title', array('type' => 'text')); ?>
			<?php echo $this->Form->input('Alias.keywords', array('type' => 'text')); ?>
			<?php echo $this->Form->input('Alias.description', array('type' => 'textarea')); ?>
	    </fieldset>
	    <?php if (in_array('Categories', CakePlugin::loaded())) : ?>	
		<fieldset>
	        <legend class="toggleClick"><?php echo __('Categories');?></legend>
	        <?php foreach ($categories as $categoryId => $categoryName) : ?>
	        	<?php $checked = in_array($categoryId, $selectedCategories) ? 'checked' : false; ?>
	        	<?php echo $this->Form->input('', array('checked' => $checked, 'type' => 'checkbox', 'name' => 'data[Category][Category][]', 'value' => $categoryId, 'id' => 'Category' . $categoryId, 'label' => $categoryName)); ?>
			<?php endforeach; ?>
	    </fieldset>
	    <?php endif; ?>
	    <?php if (in_array('Tags', CakePlugin::loaded())) : ?>
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
$this->set('context_menu', array('menus' => array(array(
	'heading' => 'Blog Posts',
	'items' => array(
		$this->Html->link(__('List'), array('controller' => 'blogs', 'action' => 'index')),
		$this->Html->link(__('Add'), array('controller' => 'blog_posts', 'action' => 'add', $this->request->data['BlogPost']['blog_id'])),
		$this->Html->link(__('Delete'), array('controller' => 'blog_posts', 'action' => 'delete', $this->Form->value('BlogPost.id')), null, __('Are you sure you want to delete %s?', $this->Form->value('BlogPost.title')))
		)
	))));
