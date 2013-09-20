<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Artist');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($artist['Artist']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Title'); ?></dt>
			<dd>
				<?php echo h($artist['Artist']['title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('About'); ?></dt>
			<dd>
				<?php echo h($artist['Artist']['about']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($artist['Artist']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($artist['Artist']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Artist')), array('action' => 'edit', $artist['Artist']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Artist')), array('action' => 'delete', $artist['Artist']['id']), null, __('Are you sure you want to delete # %s?', $artist['Artist']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Artists')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Artist')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('controller' => 'albums', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Albums')); ?></h3>
	<?php if (!empty($artist['Album'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Artist Id'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Year'); ?></th>
				<th><?php echo __('About'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($artist['Album'] as $album): ?>
			<tr>
				<td><?php echo $album['id'];?></td>
				<td><?php echo $album['artist_id'];?></td>
				<td><?php echo $album['title'];?></td>
				<td><?php echo $album['year'];?></td>
				<td><?php echo $album['about'];?></td>
				<td><?php echo $album['created'];?></td>
				<td><?php echo $album['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'albums', 'action' => 'view', $album['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'albums', 'action' => 'edit', $album['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'albums', 'action' => 'delete', $album['id']), null, __('Are you sure you want to delete # %s?', $album['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
