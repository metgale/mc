
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Music Center</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
	<head>


		<?php
		echo $this->Html->css(array('bootstrap', 'bootstrap-responsive.min', 'mc'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		?>
	</head>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="/js/html5shiv.js"></script>
	<![endif]-->

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/ico/favicon.png">
</head>

<body>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="nav-collapse collapse">
					<ul class="nav pull-right">
						<li class="active"><a href="/users/collection/<?php echo AuthComponent::user('id') ?>">My Collection</a></li>
						<li class="active"><a href="/users/wishlist/<?php echo AuthComponent::user('id') ?>">My Wishlist</a></li>
						<li class="active"><a href="/users/facebook_logout/">Logout</a></li>
					</ul>
					<ul class="nav">
						<li class="active"><a href="/home">Home</a></li>
						<li class="active"><a href="/albums/index/">Albums</a></li>
						<li class="active"><a href="/artists/index/">Artists</a></li>
					</ul>
					<ul>
						<li id="form">
							<form action="/albums/search" method="get" class="form-search pull-right">
								<?php
								echo $this->Form->input('search', array(
									'label' => false,
									'div' => false,
									'name' => 'keyword',
									'type' => 'text',
									'class' => 'input-medium search-query'));
								?> 
								<button type="submit" class="btn">Search</button>
							</form>
						</li>
					</ul>

				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	


	<div class="container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div> <!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap-transition.js"></script>
	<script src="/js/bootstrap-alert.js"></script>
	<script src="/js/bootstrap-modal.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-scrollspy.js"></script>
	<script src="/js/bootstrap-tab.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-button.js"></script>
	<script src="/js/bootstrap-collapse.js"></script>
	<script src="/js/bootstrap-carousel.js"></script>
	<script src="/js/bootstrap-typeahead.js"></script>

</body>
</html>
