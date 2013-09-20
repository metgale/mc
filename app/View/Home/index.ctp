<?php echo $this->Facebook->html(); ?>
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
						<h2><?php echo $latestAlbum['Album']['title'] ?><small> by <?php echo $latestAlbum['Artist']['title'] ?></small><small> | Year: <?php echo $latestAlbum['Album']['year'] ?></small></h2>
						<p><?php echo $latestAlbum['Album']['about'] ?></p>

						<a href="/mc/albums/addToWishlist/<?php echo $latestAlbum['Album']['id'] ?>" class="btn btn-primary btn-small pull-right">Add to Wishlist</a>
						<a href="/mc/albums/addToCollection/<?php echo $latestAlbum['Album']['id'] ?>" class="btn btn-primary btn-small pull-right">Add to Collection</a>
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
			<a href="/mc/users/index/<?php echo $friend['uid'] ?>"class="btn btn-link"><?php echo $friend['name']; ?>
			</a>
		<?php endforeach; ?>
	</div>

</div>
<br>
<br>
<br>
<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream,read_friendlists')); ?>
<?php echo $this->Facebook->logout(array('redirect' => array('controller' => 'users', 'action' => 'logout'), 'img' => 'facebook-logout.png')); ?>
<?php echo $this->Facebook->init(); ?>
</html>











