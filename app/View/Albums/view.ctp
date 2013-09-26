<div id="albums-view">
	<div>
		<ul class="leftinfo span3">
			<img class = "media-object" src = "<?php echo $album['Album']['cover'] ?>"> 
		</ul>
		<a class="pull-right" href="/albums/edit/<?php echo $album['Album']['id']?>">Edit Album</a>
		<div id='rightinfo' class="span7">
			<h2><?php echo $album['Album']['title'] ?></h2>	
			<h4>Year: <?php echo $album['Album']['year']; ?></h4>

			<h3><?php echo $this->Html->link($album['Artist']['title'], array('controller' => 'artists', 'action' => 'view', $album['Artist']['id'])) ?></h3>
			<blockquote> <?php echo $album['Album']['about']; ?> </blockquote>
			<h4>Songs:</h4><?php echo nl2br($album['Album']['songs']) ?>

			<?php if (!$coll): ?> 
				<?php if (!$wish): ?>
					<a href="/albums/addToWishlist/<?php echo $album['Album']['id'] ?>" class="btn btn-primary btn-small pull-right">Add to Wishlist</a>
				<?php else: ?>
					<a href="/albums/deleteFromWishlist/<?php echo $album['Album']['id'] ?>" class="btn btn-warning btn-small pull-right">Remove from Wishlist</a>

				<?php endif; ?>
				<a href="/albums/addToCollection/<?php echo $album['Album']['id'] ?>" class="btn btn-primary btn-small pull-right">Add to Collection</a>
			<?php else: ?>
				<a href="/albums/deleteFromCollection/<?php echo $album['Album']['id'] ?>" class="btn btn-warning btn-small pull-right">Remove from Collection</a>
			<?php endif; ?>


		</div>

	</div>


	<div class="row">
		<?php if (!empty($comments)): ?>
			<div id="comments" class="span8 offset2">
				<h3>Comments</h3>
				<ol class="comments dl-horizontal">
					<?php foreach ($comments as $comment): ?>
						<li class="comment">
							<div class="metadata">
								<strong class="comment-username"><?php echo $comment['User']['name']; ?></strong>
								<span class="comment-created"><?php echo $comment['Comment']['created']; ?></span>
							</div>
							<p class="comment-content"><?php echo h($comment['Comment']['content']); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
				<?php echo $this->Paginator->pagination(); ?>
			</div>
		<?php endif; ?>
		<?php if (AuthComponent::user()): ?>
			<div class="span8 offset2">
				<?php echo $this->Form->create('Comment', array('class' => 'form')); ?>
				<fieldset>
					<legend>Leave a comment here</legend>
					<?php
					echo $this->Form->input('content', array(
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;',
						'class' => 'input-xxlarge',
						'rows' => '5',
					));
					?>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Post Comment</button>
					</div>
				</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
