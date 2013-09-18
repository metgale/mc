<div class="albums index">
	<h2><?php echo __('Albums'); ?></h2>
	<table cellpadding="0" cellspacing="0">

	<?php foreach ($albums as $album): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($album['Artist']['title'] , array('controller' => 'artists', 'action' => 'view', $album['Artist']['id'])); ?>
		</td>
		<td><?php echo h($album['Album']['title']); ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $album['Album']['id'])); ?>	
			<?php echo $this->Html->link(__('Add To Collection'), array('controller' => 'Albums', 'action' => 'addToCollection', $album['Album']['id'])); ?>	
			<?php echo $this->Html->link(__('Add To Wishlist'), array('controller' => 'Albums', 'action' => 'addToWishlist', $album['Album']['id'])); ?>	

		</td>
	</tr>
<?php endforeach; ?>
	</table>

	
</div>

