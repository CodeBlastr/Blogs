<div class="row blogs dashboard clearfix">
	<?php foreach ($blogs as $blog) : ?>
	<div class="col-md-12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>
						<?php echo $blog['Blog']['title']; ?> 
						<?php echo empty($blogId) ? $this->Html->link('<span class="glyphicon glyphicon-hand-right">&nbsp;</span>', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'dashboard', $blog['Blog']['id']), array('escape' => false)) : null; ?>
						<?php echo $this->Html->link('Create Post', array('admin' => true, 'plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'add', $blog['Blog']['id']), array('class' => 'btn btn-xs btn-success')); ?>
					</th>
					<th class="text-center">
						Publish Date
					</th>
					<th class="text-center">
						Alias
					</th>
					<th class="text-center">
						Actions
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($blog['BlogPost'] as $post) : ?>
				<tr>
					<td>
						<?php echo $this->Html->link($this->Text->truncate($post['title'], 30), array('admin' => false, 'plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'view', $post['id'])); ?>
						<small class="muted"><?php echo $this->Text->truncate(strip_tags($post['text']), 25); ?></small>
					</td>
					<td class="text-center">
						<span class="label <?php echo $post['published'] < date('Y-m-d H:i:s') ? 'label-success' : 'label-warning'; ?>"><?php echo ZuhaInflector::datify($post['published']); ?></span>
					</td>
					<td class="text-center">
						<?php echo !empty($post['Alias']['name']) ? $this->Html->link(__('<span class="label label-primary">%s</span>', $this->Text->truncate($post['Alias']['name'], 20)), '/' . $post['Alias']['name'], array('escape' => false)) : null; ?>
					</td>
					<td class="text-center">
						<?php echo $this->Html->link('<span class="label label-default">Edit</span>', array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'edit', $post['id']), array('escape' => false)); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php endforeach; ?>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	!empty($blogId) ? $this->Html->link('Blogs Dashboard', array('action' => 'dashboard')) : 'Blogs Dashboard',
	!empty($blogId) ? $blogs[0]['Blog']['title'] . ' Dashboard' : null,
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array('heading' => 'Blogs',
		'items' => array(
			 $this->Html->link(__('Add', true), array('controller' => 'blogs', 'action' => 'add'), array('class' => 'add')),
			 )
		)
	)));
