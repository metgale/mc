<div class="user-index">
	<h1>Wishlist</h1>
	<?php foreach ($albums as $album): ?>
		<div class="media">
			<a class="pull-left" href="#">
				<img class ="media-object" src="<?php echo $album['Album']['cover'] ?>">
			</a>
			<div class="media-body">
				<div class="media-heading">
					<h3><p><?php echo $this->Html->link($album['Album']['title'], array('controller' => 'albums', 'action' => 'view', $album['Album']['id'])) ?></small>			
							<small> by <?php echo $this->Html->link($album['Album']['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $album['Album']['Artist']['id'])) ?></small><small> | Year: <?php echo $album['Album']['year'] ?></small></h3>
					<p><?php echo $album['Album']['about'] ?></p>
				</div>
			</div>
		</div>
		<div class='border'></div>
	<?php endforeach; ?>
</div>