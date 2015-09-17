<div class="row blogs blog-posts edit">
	<?php echo $this->Form->create('BlogPost', array('type' => 'file')); ?>
		<div class="form col-md-8">
		    <?php echo $this->Form->input('BlogPost.id'); ?>
			<?php echo $this->Form->hidden('BlogPost.blog_id'); ?>
			<?php echo $this->Form->input('BlogPost.title', array('label' => __('Post Title'))); ?>
			<?php echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext')); ?>
			<?php // Media is deprecated // echo CakePlugin::loaded('Media') ? __('<hr>%s<hr>', $this->Element('Media.selector', array('media' => $this->request->data['Media'], 'multiple' => true))): null; ?>
			<?php echo $this->Form->submit('Save Edits');?>
		</div>
		<div class="col-md-4">
			<?php echo $this->element('forms/alias', array('formId' => '#BlogPostAddForm', 'nameInput' => '#BlogPostTitle', 'prefix' => 'blog/', 'dataDisplay' => '[for=BlogPostTitle]')); // must have the alias behavior attached to work  ?>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingSix">
						<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix"> <?php echo __('Media');?> </a></h4>
					</div>
					<div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix">
						<div class="panel-body">
							<?php echo $this->Html->script('plugins/jquery.form.utility.min'); // duplicatable form elements ?>
							<?php $i=0; // must be up here ?>
							<?php if (!empty($this->request->data['FileStorage'])) : ?>
								<?php foreach ($this->request->data['FileStorage'] as $file) : ?>
							    	<div id="media<?php echo $file['id']; ?>" class="list-group media-selected">
							    	 	<div class="list-group-item clearfix">
							    	 		<div class="row">
							    	 			<div class="col-xs-3">
							    	 				<?php echo $this->Attachment->display($file); ?>
							    	 			</div>
							    	 			<div class="col-xs-9 text-right">
							    	 				<?php echo $this->Html->link('Delete', array('plugin' => 'file_storage', 'controller' => 'file_storage', 'action' => 'delete', $file['id']), array('class' => 'btn btn-xs btn-danger'), __('Permanently Delete "%s"?', $file['filename'])); ?>
							    	 			</div>
							    	 		</div>
							    	 	</div>
							    	</div>
							    <?php $i++; endforeach; ?>
							<?php endif; ?>
							<h5>Add Media</h5>
							<!-- duplicatable start -->
							<div class="clearfix duplicatable">
								<?php echo $this->Form->input('File.' . $i . '.file', array('type' => 'file', 'label' => false, 'class' => 'changer')); ?>
								<?php //echo $this->Form->input('File.' . $i . '.description', array('label' => 'Brief Description of Image <small class="text-muted">(ex. back of driver\'s license)</small>', 'type' => 'text', 'class' => 'changer')); ?>
							</div>
							<!-- duplicatable end -->
						</div>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <?php echo __('SEO Optimization');?> </a></h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<?php echo $this->Form->input('Alias.title', array('type' => 'text')); ?>
							<?php echo $this->Form->input('Alias.keywords', array('type' => 'text')); ?>
							<?php echo $this->Form->input('Alias.description', array('type' => 'textarea')); ?>
						</div>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <?php echo __('Publish Settings'); ?> </a></h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<?php echo $this->Form->input('BlogPost.status'); ?>
							<?php echo $this->Form->input('BlogPost.published', array('type' => 'datetimepicker', 'label' => 'Publish Date')); ?>
							<?php echo $this->Form->input('BlogPost.allow_comments'); ?>
						</div>
					</div>
				</div>
				<?php if (CakePlugin::loaded('Categories')) : ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <?php echo __('Categories');?> </a></h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								<?php foreach ($categories as $categoryId => $categoryName) : ?>
						        	<?php $checked = in_array($categoryId, $selectedCategories) ? 'checked' : false; ?>
						        	<?php echo $this->Form->input('', array('checked' => $checked, 'type' => 'checkbox', 'name' => 'data[Category][Category][]', 'value' => $categoryId, 'id' => 'Category' . $categoryId, 'label' => $categoryName)); ?>
								<?php endforeach; ?>
							</div>
						</div>
				    </div>
		    	<?php endif; ?>
				<?php if (CakePlugin::loaded('Tags')) : ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> <?php echo __('Tags');?> </a></h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
							<div class="panel-body">
								<?php echo $this->Form->input('tags', array('label' => 'Enter comma separated tags ('.$this->Html->link('view tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')).' ).')); ?>
							</div>
						</div>
				    </div>
		    	<?php endif; ?>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingFive">
						<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> <?php echo __('Author');?> </a></h4>
					</div>
					<div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
						<div class="panel-body">
							<?php echo $this->Form->input('BlogPost.author_id', array('label' => false)); ?>
						</div>
					</div>
			    </div>
			</div>
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
