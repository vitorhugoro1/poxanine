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
				<div class="moduleAnimationShock">
			      <div class="hd"></div>
			      <div class="bd">		      
					<a href="<?php echo home_url() ?>">
						<?php echo '<img src="' .get_template_directory_uri() . '/img/logo.png' . '" class="logo">'; ?>
					</a>
			      </div>
			      <div class="ft"></div>
			    </div>
			</header>
		</div>
