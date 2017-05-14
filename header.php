<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
	<title><?php wp_title() ?></title>
    <?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<div class="container-topo">
			<div id="header-menu">
				<div class="container">
					<div class="row">
						<?php
						$defaults =
						array(
							'menu' => 'topo',
							'container' => 'nav',
							'container_class' => 'menu',
							'menu_class' => 'menu-topo',
							'fallback_cb' => 'wp_page_menu',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth' => 0,
						);

						wp_nav_menu( $defaults );
						?>
						<div class="top-search">
							<form id="searchform" action="<?=home_url()?>" method="get">
								<input type="text" value="<?php the_search_query() ?>" placeholder="Digite e aperte enter..." name="s" id="s" style="font-size:70%;"/>
								<i class="fa fa-search search-desktop"></i>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="mobile-menu">
				<div class="container action-menu">
					<div class="row">
						<a href="javascript:void(0);" class="menu-action">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</a>
						<a href="javascript:void(0);" class="search-action">
							<i class="fa fa-search search-desktop" aria-hidden="true"></i>
						</a>
					</div>
				</div>
						<?php
						$defaults =
						array(
							'menu' => 'topo',
							'container' => 'nav',
							'container_class' => 'mobile-menu u-max-full-width',
							'menu_class' => 'mobile-menu-topo',
							'fallback_cb' => 'wp_page_menu',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth' => 0,
						);

						wp_nav_menu( $defaults );
						?>
					<div class="top-search">
						<form id="searchform" action="<?=home_url()?>" method="get">
							<input type="text" value="<?php the_search_query() ?>" placeholder="Digite e aperte enter..." name="s" id="s" />
						</form>
					</div>
			</div>
	</div>
	<div id="container-logo">
		<div class="container">
			<div class="row">
				<header class="topo">
					<a href="<?php echo home_url() ?>">
						<?php echo '<img src="' .get_template_directory_uri() . '/assets/img/logo.png' . '" class="logo-img">'; ?>
					</a>
				</header>
			</div>
		</div>
	</div>
