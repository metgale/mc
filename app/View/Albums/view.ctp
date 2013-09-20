<div id="albums-view">
	<ul class="leftinfo span3">
		<img class = "media-object" src = "<?php echo $album['Album']['cover'] ?>"> 
	</ul>
	<div id='rightinfo' class="span7">
		<h2><?php echo $album['Album']['title'] ?></h2>
		<h3>Made by <?php echo $album['Artist']['title'] ?></h3>
		<blockquote> <?php echo $album['Album']['about']; ?> </blockquote>	

		<h4>Year: <?php echo $album['Album']['year']; ?></h4>


	</div>	
</div>












