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
		<?php /* galleries are deprecated, use media <fieldset>
			<?php echo $this->Element('forms/alias', array('inputOptions' => array('form' => 'BlogPostEditForm'), 'formId' => '#BlogPostAddForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/', 'dataDisplay' => '[for=BlogPostTitle]')); // must have the alias behavior attached to work  ?>
		
		    <?php echo $this->element('Galleries.thumb', array('form' => 'GalleryEditForm', 'resize' => false, 'model' => 'BlogPost', 'foreignKey' => $this->request->data['BlogPost']['id'])); ?>
					
			<?php echo $this->Form->input('GalleryImage.is_thumb', array('form' => 'GalleryEditForm', 'type' => 'hidden', 'value' => 1)); ?>
			<?php echo $this->Form->input('GalleryImage.filename', array('form' => 'GalleryEditForm', 'label' => 'Choose image', 'type' => 'file')); ?>
			<?php echo $this->Form->input('Gallery.model', array('form' => 'GalleryEditForm', 'type' => 'hidden', 'value' => 'BlogPost')); ?>
			<?php echo $this->Form->input('Gallery.foreign_key', array('form' => 'GalleryEditForm', 'type' => 'hidden', 'value' => $this->request->data['BlogPost']['id'])); ?>
			<?php echo $this->Form->submit('Change Featured Image', array('form' => 'GalleryEditForm'));?>
		</fieldset> */  ?>
		<fieldset>
			<legend class="toggleClick"><?php echo __('Publish Settings'); ?></legend>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.published', array('type' => 'datetimepicker', 'label' => 'Publish Date')); ?>
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
