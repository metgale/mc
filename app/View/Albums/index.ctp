<div class="user-index">
	<h1>Albums</h1>
	<span class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			Sort by
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Paginator->sort('title', 'Album title'); ?></li>
			<li><?php echo $this->Paginator->sort('artist_id', 'Artist'); ?></li>
			<li><?php echo $this->Paginator->sort('year', 'Year'); ?></li>
		</ul>
	</span>
	<a class="pull-right" href="/albums/add">Add Album</a></li>
<?php foreach ($albums as $album): ?>
	<div class="media">
		<a class="pull-left" href="#">
			<img class ="media-object" src="<?php echo $album['Album']['cover'] ?>">
		</a>
		<div class="media-body">
			<div class="media-heading">
				<h3><p><?php echo $this->Html->link($album['Album']['title'], array('controller' => 'albums', 'action' => 'view', $album['Album']['id'])) ?></small>			
						<small> by <?php echo $this->Html->link($album['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $album['Artist']['id'])) ?></small><small> | Year: <?php echo $album['Album']['year'] ?></small></h3>
				<p><?php echo $album['Album']['about'] ?></p>
			</div>
		</div>
	</div>
	<div class='border'></div>
<?php endforeach; ?>
</div>