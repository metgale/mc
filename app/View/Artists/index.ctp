<div class="user-index">
	<h1>Albums</h1>
	<?php echo $this->Paginator->sort('title', 'Sort by artist title'); ?>
	<a class="pull-right" href="/artists/add">Add Artist</a></li>
<?php foreach ($artists as $artist): ?>
	<div class="media">
		<a class="pull-left" href="#">
			<img class ="media-object" src="<?php echo $artist['Artist']['cover'] ?>">
		</a>
		<div class="media-body">
			<div class="media-heading">
				<h3><?php echo $this->Html->link($artist['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $artist['Artist']['id'])) ?></h3>
				<p><?php echo $artist['Artist']['about'] ?></p>	</div>
		</div>
	</div>
	<div class='border'></div>
<?php endforeach; ?>
</div>