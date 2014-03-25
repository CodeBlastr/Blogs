<?php $CategoryHelper = $this->Helpers->load('Categories.Category', $___dataForView); ?>
<?php $categories = $CategoryHelper->find('all', array('conditions' => array('Category.model' => 'BlogPost'))); ?>
<?php if ( !empty($categories) ) : ?>
 	<ul class="unstyled">
	<?php foreach ($categories as $category) : ?>
		<li><?php echo $this->Html->link($category['Category']['name'], array('plugin' => 'blogs','controller' => 'blogs', 'action' => 'categories', '?' => array('categories' => $category['Category']['name']))); ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>