<div id="albums-view">
	<ul class="leftinfo span3">
		<img class = "media-object" src = "<?php echo $album['Album']['cover'] ?>"> 
	</ul>
	<div id='rightinfo' class="span7">
		<h2><?php echo $album['Album']['title'], $album['Album']['year']?></h2>
		<h3>Made by <?php echo $album['Artist']['title'] ?></h3>
		<blockquote> <?php echo $album['Album']['about']; ?> </blockquote>	

		<h4>Year: <?php echo $album['Album']['year']; ?></h4>


	</div>
	<div class="row">
		<?php if (!empty($comments)): ?>
			<div id="comments" class="span8 offset2">
				<h3>Komentari</h3>
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
				<?php echo $this->Form->create('Comment', array('class' => 'form-horizontal')); ?>
				<fieldset>
					<legend>Komentiraj</legend>
					<?php
					echo $this->Form->input('content', array(
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;',
						'class' => 'input-xxlarge',
						'rows' => '5',
					));
					?>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Pošalji komentar</button>
					</div>
				</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>












