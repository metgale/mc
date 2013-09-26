<?php //echo $this->Facebook->html();  ?>
<div class="home-index">
	<div class="frontAlbums">
		<h1>Latest albums</h1>
		<?php foreach ($latestAlbums as $latestAlbum): ?>
			<div class="media">
				<a class="pull-left" href="#">
					<img class ="media-object" src="<?php echo $latestAlbum['Album']['cover'] ?>">
				</a>
				<div class="media-body">
					<div class="media-heading">
						<h2><?php echo $this->Html->link($latestAlbum['Album']['title'], array('controller' => 'albums', 'action' => 'view', $latestAlbum['Album']['id'])) ?><small> by <?php echo $this->Html->link($latestAlbum['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $latestAlbum['Artist']['id'])) ?></small></h2>
						<p><?php echo $latestAlbum['Album']['about'] ?></p>

						<?php echo $this->Html->link('More info', array('controller' => 'albums', 'action' => 'view', $latestAlbum['Album']['id'])) ?>			
					</div>
				</div>
			</div>
			<div class='border'></div>
		<?php endforeach; ?>

	</div>
	<h1>Friends on Music Center</h1>
	<div class="usersApp">
		<?php foreach ($friends as $friend): ?>
			<?php echo $this->Html->image($friend['pic']); ?>
			<a href="/users/collection/<?php echo $friend['uid'] ?>"class="btn btn-link"><?php echo $friend['name']; ?>
			</a>
		<?php endforeach; ?>
	</div>

</div>
<br>
<br>
<br>
</html>


<?php ?>











