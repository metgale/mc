<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Album', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Edit %s', __('Album')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('artist_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('title', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('year', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('about', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->hidden('id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Album.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Album.id'))); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Artists')), array('controller' => 'artists', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Artist')), array('controller' => 'artists', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Collections')), array('controller' => 'collections', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Collection')), array('controller' => 'collections', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Wishlists')), array('controller' => 'wishlists', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Wishlist')), array('controller' => 'wishlists', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>