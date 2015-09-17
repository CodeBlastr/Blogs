<div class="row blogs blog-posts add">
	<?php echo $this->Form->create('BlogPost', array('type' => 'file')); ?>
		<div class="form col-md-8">
			<?php echo $this->Form->hidden('BlogPost.blog_id'); ?>
			<?php echo $this->Form->input('BlogPost.title', array('label' => __('Post Title'))); ?>
			<?php echo $this->Form->input('BlogPost.text', array('label' => '', 'type' => 'richtext')); ?>
			<?php echo $this->Form->submit('Add Blog Post');?>
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
						        	<?php echo $this->Form->input('', array('type' => 'checkbox', 'name' => 'data[Category][Category][]', 'value' => $categoryId, 'id' => 'Category' . $categoryId, 'label' => $categoryName)); ?>
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
	$this->Html->link(__('Blogs Dashboard'), '/admin/blogs/blogs/dashboard'),
	$page_title_for_layout,
)));
    
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Blog Posts',
		'items' => array(
			 $this->Html->link(__('List'), array('controller' => 'blogs', 'action' => 'view', $blogId)),
			 )
		)
	)));