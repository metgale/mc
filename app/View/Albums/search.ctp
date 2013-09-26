<div class="user-index">
	<h1>Search results</h1>

	<?php if ($albums): ?>
		<h2>Albums</h2>
		<?php foreach ($albums as $album): ?>
			<div class="media">
				<a class="pull-left" href="#">
					<img class ="media-object" src="<?php echo $album['Album']['cover'] ?>">
				</a>
				<div class="media-body">
					<div class="media-heading">
						<h3><?php echo $this->Html->link($album['Album']['title'], array('controller' => 'albums', 'action' => 'view', $album['Album']['id'])) ?><small> by <?php echo $this->Html->link($album['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $album['Artist']['id'])) ?></small><small> | Year: <?php echo $album['Album']['year'] ?></small></h3>
						<p><?php echo $album['Album']['about'] ?></p>
					</div>
				</div>
			</div>
			<div class='border'></div>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ($artists): ?> 
		<h2>Artists</h2>
		<?php foreach ($artists as $artist): ?>
			<div class="media">
				<a class="pull-left" href="#">
					<img class ="media-object" src="<?php echo $artist['Artist']['cover'] ?>">
				</a>
				<div class="media-body">
					<div class="media-heading">
						<h3><?php echo $this->Html->link($artist['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $artist['Artist']['id'])) ?></h3>
						<p><?php echo $artist['Artist']['about'] ?></p>
					</div>
				</div>
			</div>
			<div class='border'></div>
		<?php endforeach; ?>
	<?php endif; ?>
			

</div>