<div class="blogs index">
<h2><?php echo __('Blogs');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($blogs as $blog):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $blog['Blog']['title']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $blog['Blog']['id'], 'admin' => 0)); ?>
			<?php # echo $this->Html->link(__('Edit', true), array('action' => 'edit', $blog['Blog']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $blog['Blog']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $blog['Blog']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->Element('paging'); ?>
<?php
$this->set('context_menu', array('menus' => array(
	array('heading' => 'Blogs',
		'items' => array(
			 $this->Html->link(__('New Blog', true), array('controller' => 'blogs', 'action' => 'my', 'admin' => 0)),
			 )
		)
	)));
?>
