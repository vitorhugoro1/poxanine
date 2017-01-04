<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title() ?></title>
  <?php wp_head() ?>
</head>
<body>
	<div class="container">
		<div class="row">
			<header class="topo">
				<a href="<?php echo home_url() ?>"><?php bloginfo('title') ?></a>
			</header>
		</div>
