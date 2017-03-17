<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title() ?></title>
  <?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<div class="container-topo">
		<div class="container">
			<div class="row">
				<?php /**
					 * Displays a navigation menu.
					 *
					 * @since 3.0.0
					 */
					$defaults =
					array(
						'theme_location' => '',
						'menu' => 'topo',
						'container' => 'nav',
						'container_class' => 'menu',
						'container_id' => '',
						'menu_class' => 'menu-topo',
						'menu_id' => '',
						'echo' => true,
						'fallback_cb' => 'wp_page_menu',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth' => 0,
						'walker' => ''
					);

					wp_nav_menu( $defaults );
				?>
				<div class="top-search">
					<form id="searchform" action="<?=home_url()?>" method="get">
						<input type="text" value="<?php the_search_query() ?>" placeholder="Digite e aperte enter..." name="s" id="s" />
						<i class="fa fa-search search-desktop"></i>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="container-logo">
		<div class="container">
			<div class="row">
				<header class="topo">
					<a href="<?php echo home_url() ?>">
						<?php echo '<img src="' .get_template_directory_uri() . '/img/logo.png' . '" class="logo-img">'; ?>
					</a>
				</header>
			</div>
		</div>
	</div>
