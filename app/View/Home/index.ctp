<?php echo $this->Facebook->html(); ?>
<div>
	<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream,read_friendlists')); ?>
	<?php echo $this->Facebook->logout(array('redirect' => array('controller' => 'users', 'action' => 'logout'), 'img' => 'facebook-logout.png')); ?>
</div>
<?php echo $this->Facebook->init(); ?>
</html>