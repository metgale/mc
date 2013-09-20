<div class="user-index">

	<?php foreach ($albums as $album): ?>
		<div class="media">
			<a class="pull-left" href="#">
				<img class ="media-object" src="<?php echo $album['Album']['cover'] ?>">
			</a>
			<div class="media-body">
				<div class="media-heading">
					<h3><?php echo $album['Album']['title'] ?><small> by <?php echo $album['Album']['Artist']['title'] ?></small><small> | Year: <?php echo $album['Album']['year'] ?></small></h3>
					<p><?php echo $album['Album']['about'] ?></p>
					<p><?php echo $this->Html->link('More info', array('controller' => 'albums', 'action' => 'view', $album['Album']['id']))?></small>			
				</div>
			</div>
		</div>
		<div class='border'></div>
	<?php endforeach; ?>
</div>