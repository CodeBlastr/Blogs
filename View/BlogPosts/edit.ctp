<div id="blogPosts-add" class="blogPosts add form">
<div id="pageTitle">
	<h1 class="page-title"><?php echo $this->request->data['BlogPost']['title']; ?></h1>
</div>
<div class="clearfix"></div>

<?php echo $this->Form->create('BlogPost');?>
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
			<?php echo $this->Form->input('BlogPost.published', array('type' => 'text', 'class' => 'datetimepicker', 'value' => date('Y-m-d h:i:s'))); ?>
			<?php echo $this->Element('forms/alias', array('formId' => '#BlogPostEditForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/')); // must have the alias behavior attached to work ?>
	</fieldset>
	<?php /* move these fields to aliases table <fieldset>
 		<legend class="toggleClick"><?php echo __('Search Optimization Meta');?></legend>
			<?php echo $this->Form->input('BlogPost.seo_title'); ?>
			<?php echo $this->Form->input('BlogPost.seo_keywords'); ?>
			<?php echo $this->Form->input('BlogPost.seo_descriptions'); ?>
	</fieldset> */ ?>
	<fieldset>
 		<legend class="toggleClick"><?php echo __('Excerpt');?></legend>
			<?php echo $this->Form->input('BlogPost.introduction'); ?>
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
<?php echo $this->Form->end('Edit');?>
</div>

<style>
	.content-wrap h1 small {
		letter-spacing: normal;
	}
</style>

<script>
	$(function() {
		$('#BlogPostTitle').blur(function(e){
			var oldTitle = $('.pageTitle').html();
			var newTitle = $(this).val();
			
			if(oldTitle != newTitle) {
				$('.pageTitle').html(newTitle);
			}
		});
	});
</script>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'blogs', 'action' => 'index')),
			$this->Html->link(__('Add'), array('controller' => 'blog_posts', 'action' => 'add', $this->request->data['BlogPost']['blog_id'])),
            $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BlogPost.id')), null, __('Are you sure you want to delete %s?', $this->Form->value('BlogPost.title'))),
			)
		)
	))); ?>