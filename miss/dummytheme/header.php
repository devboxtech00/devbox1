<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <!-- Required meta tags -->
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1, shrink-to-fit=no">
  <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>
  <!-- style sheets -->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


           <?php
			wp_nav_menu(
				array(
				'container'            => '',
          'container_class'      => '',
          'container_id'         => '',
          'items_wrap'     => '<ul id="%1$s" class="%2$s navbar-nav ml-auto mr-auto ">%3$s</ul>',
          'theme_location' => 'menu-1',
				)
			);
			?>
