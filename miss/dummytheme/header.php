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


                <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                  $count = WC()->cart->cart_contents_count;
                ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
                 if ( $count > 0 ) {
                 ?>
                
                 <span class="cart-item"><?php echo esc_html( $count ); ?></span>
                 <?php
                    }
                 ?></a>
               <?php } ?>



    <form role="search" method="get"  action="<?php echo home_url( '/' );?>">
              <div class="form-input">
                <input type="text" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" required>
                <input type="submit" value="SUBMIT"> 
              </div>
            </form>
