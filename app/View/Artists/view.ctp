<div id="albums-view">
	<ul class="leftinfo span3">
		<img class = "media-object" src = "<?php echo $artist['Artist']['cover'] ?>"> 
	</ul>
	<a class="pull-right" href="/artists/edit/<?php echo $artist['Artist']['id']?>">Edit Artist</a>
	<div id='rightinfo' class="span7">
		<h2><?php echo $artist['Artist']['title'] ?></h2>	
		<blockquote> <?php echo $artist['Artist']['about']; ?> </blockquote>
		<h4>Line up:</h4><?php echo nl2br($artist['Artist']['lineup']) ?>

		<h4>Albums on Music Center:</h4>

		<?php foreach ($albums as $album): ?>
			<?php
			echo $this->Html->link($album['Album']['title'], array(
				'controller' => 'albums', 'action' => 'view', $album['Album']['id']))
			?><br>
		<?php endforeach; ?>

	</div>
</div>












