<?php echo $this->Facebook->html(); ?>
<div>
	<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream')); ?>
</div>
<?php echo $this->Facebook->init(); ?>
</html>