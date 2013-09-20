<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Albums'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('artist_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('title');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('year');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('about');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($albums as $album): ?>
			<tr>
				<td><?php echo h($album['Album']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($album['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $album['Artist']['id'])); ?>
				</td>
				<td><?php echo h($album['Album']['title']); ?>&nbsp;</td>
				<td><?php echo h($album['Album']['year']); ?>&nbsp;</td>
				<td><?php echo h($album['Album']['about']); ?>&nbsp;</td>
				<td><?php echo h($album['Album']['created']); ?>&nbsp;</td>
				<td><?php echo h($album['Album']['modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $album['Album']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $album['Album']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $album['Album']['id']), null, __('Are you sure you want to delete # %s?', $album['Album']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Artists')), array('controller' => 'artists', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Artist')), array('controller' => 'artists', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Collections')), array('controller' => 'collections', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Collection')), array('controller' => 'collections', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Wishlists')), array('controller' => 'wishlists', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Wishlist')), array('controller' => 'wishlists', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>