<div id="blogPosts-add" class="blogPosts add form">
<?php echo $this->Form->create('BlogPost');?>
      <h2><?php echo $page_title_for_layout; ?></h2>
	<fieldset>
    <?php
	echo $this->Form->input('BlogPost.id');
	echo $this->Form->hidden('BlogPost.blog_id');
	echo $this->Form->input('BlogPost.title', array('label' => __('Post Title', true)));
	echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline', 'Format', 'FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight', '-', 'Link','Unlink', '-', 'Image', '-', 'Source')))); ?>
	</fieldset>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Publish Settings');?></legend>
			<?php echo $this->Form->input('BlogPost.status'); ?>
			<?php echo $this->Form->input('BlogPost.publish_date', array('value' => date('Y-m-d h:i'))); ?>
	</fieldset>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Search Optimization Meta');?></legend>
			<?php echo $this->Form->input('BlogPost.seo_title'); ?>
			<?php echo $this->Form->input('BlogPost.seo_keywords'); ?>
			<?php echo $this->Form->input('BlogPost.seo_descriptions'); ?>
	</fieldset>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Excerpt');?></legend>
			<?php echo $this->Form->input('BlogPost.introduction'); ?>
	</fieldset>
    <?php if (in_array('Categories', CakePlugin::loaded())) { ?>		
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Categories');?></legend>
			<?php echo $this->Form->input('Category', array('multiple' => 'checkbox', 'label' => 'Which categories? ('.$this->Html->link('add', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'tree', 'model' => 'BlogPost')).' / '.$this->Html->link('edit', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'tree', 'model' => 'BlogPost')).' categories)')); ?>
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
<?php echo $this->Form->end('Edit');?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			 $this->Html->link(__('List', true), array('controller' => 'blogs', 'action' => 'index')),
			 $this->Html->link(__('Add', true), array('controller' => 'blog_posts', 'action' => 'add', $this->request->data['BlogPost']['blog_id']), array('class' => 'add')),
			 )
		)
	))); ?>