<div id="blogPosts-add" class="blogPosts add form">
<?php echo $this->Form->create('BlogPost', array('type' => 'file'));?>
	<fieldset>
    <?php
	echo $this->Form->hidden('BlogPost.blog_id', array('value' => $blogId));
	echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true)));
	echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext')); ?>
	</fieldset>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Publish Settings');?></legend>
			<?php 
			     //echo $this->Element('forms/alias', array('formId' => '#BlogPostAddForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/')); // must have the alias behavior attached to work 
			?>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.published', array('default' => date('Y-m-d h:i:s'))); ?>
	</fieldset>
	<?php /* move these fields to aliases table	<fieldset>
 		<legend class="toggleClick"><?php echo __('Search Optimization Meta');?></legend>
			<?php echo $this->Form->input('BlogPost.seo_title'); ?>
			<?php echo $this->Form->input('BlogPost.seo_keywords'); ?>
			<?php echo $this->Form->input('BlogPost.seo_descriptions'); ?>
	</fieldset> */ ?>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Excerpt');?></legend>
			<?php echo $this->Form->input('BlogPost.introduction'); ?>
	</fieldset>
	<fieldset>
		<legend class="toggleClick"><?php echo __('Featured Image'); ?></legend>
			<?php echo $this->Form->input('GalleryImage.filename', array('type' => 'file')); ?>
	</fieldset>
    <?php if (in_array('Categories', CakePlugin::loaded())) { ?>	
	<fieldset>
        <legend class="toggleClick"><?php echo __('Categories');?></legend>
            <?php echo $this->Form->input('Category', 
                            array('multiple' => 'checkbox', 
                                'label' => 'Which categories? ('.
                                $this->Js->link('add', 
                                    array('plugin' => 'categories', 
                                        'controller' => 'categories', 
                                        'action' => 'add',
                                    ),
                                     array('id' => 'addCategoryLink',
                                          'update' => '#site-modal', 
                                          'method' => 'post', 
                                          'data' => array('model' => 'BlogPost', 'modal' => true),
                                          'success' => '$("#site-modal").modal("show");',
                              )) . ')'));
                  
                  echo $this->Js->writeBuffer();
            ?>
    </fieldset>
    <?php } ?>
    <?php if (in_array('Tags', CakePlugin::loaded())) { ?>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Tags');?></legend>
			<?php echo $this->Form->input('tags', array('label' => 'Enter comma separated tags ('.$this->Html->link('view tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')).' ).')); ?>
	</fieldset>
    <?php } ?>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Discussion');?></legend>
			<?php echo $this->Form->input('allow_comments'); ?>
	</fieldset>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Author');?></legend>
			<?php echo $this->Form->input('BlogPost.author_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
	</fieldset>
<?php echo $this->Form->end('Add');?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			 $this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'view', $blogId)),
			 )
		)
	))); ?>