<?php
// style sheet & scripts
function mytheme_enqueue(){
  $uri                =   get_theme_file_uri();

  $ver = 1.0;
  $vert = time();

    wp_register_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', [], '1.0');
    wp_register_style( 'google-fonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap', [], '1.0');
    wp_register_style( 'boostrap',  $uri. '/lib/css/bootstrap.css', [], $ver);

    wp_enqueue_style( 'google-fonts-roboto');
    wp_enqueue_style( 'font-awesome');
    wp_enqueue_style( 'boostrap');

    wp_register_script( 'boostrap', $uri . '/lib/js/bootstrap.min.js', [], $ver, true );
    wp_register_script( 'matchheight', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', [], $ver, true );
    wp_register_script( 'custom-js', $uri . '/lib/js/custom.js', [], $vert, true );

    wp_enqueue_script('jquery');
    wp_enqueue_script('boostrap');
    wp_enqueue_script('matchheight');
    wp_enqueue_script('custom-js');

}
     

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue' );


function  mytheme_admin_enqueue() {

	$uri =  get_theme_file_uri();
	$ver = time();

	wp_register_style( 'admin_custom_css', $uri . '/lib/css/admin/admin.css', [], $ver);
	wp_enqueue_style( 'admin_custom_css');
	wp_register_script( 'admin-custom-js',  $uri . '/lib/js/admin/admin.js', [], $ver, true );
    wp_enqueue_script('admin-custom-js');
}

add_action( 'admin_enqueue_scripts', 'mytheme_admin_enqueue' );


// register navs
register_nav_menus(
	array(
		'menu-1' => __( 'Primary', 'mytheme' ),
		'menu-2' => __( 'Footer First Menu', 'mytheme' ),
		'menu-3' => __( 'Footer Second Menu', 'mytheme' ),
		'menu-4' => __( 'Topbar', 'mytheme' ),
    )
);


// theme support
		function mytheme_setup_theme(){
			add_theme_support( 'custom-logo' );
		    add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
			}
		add_action( 'after_setup_theme', 'mytheme_setup_theme' );

		add_filter( 'get_custom_logo', 'change_logo_class' );

// logo class
	function change_logo_class( $logo ) {
	$logo = str_replace( 'custom-logo-link', 'navbar-brand', $logo );
	return $logo;
	}
add_filter( 'get_custom_logo', 'change_logo_class' );

//acf theme page

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> 'false'
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Additional Settings',
		'menu_title'	=> 'Additional',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
        'page_title'     => 'Extra Menue',
        'menu_title'    => 'Extra Menue',
        'parent_slug'    => 'edit.php?post_type=mypost',
    ));

	
	
}	

require get_template_directory() . '/inc/custom_functions.php';

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce');
  
  }
  add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
  
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
  
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

//* Add gallery thumbs to woocommerce shop page
add_action('woocommerce_shop_loop_item_title','wps_add_extra_product_thumbs', 5);
function wps_add_extra_product_thumbs() {

	if ( is_shop() ) {

		global $product;

		$attachment_ids = $product->get_gallery_attachment_ids();

		echo '<div class="p_gallery row justify-content-center">';

		foreach( array_slice( $attachment_ids, 0,3 ) as $attachment_id ) {

		  	$thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0];

		  	echo '<div class="col-md-3">
			  <img class="thumb" style=" height:65px; width:65px;"  src="' . $thumbnail_url . '"></div>';
 
		}

		echo '</div>';
	
	}

 }


 
		// add to cart on header
		function my_header_add_to_cart_fragment( $fragments ) {
 
			ob_start();
			$count = WC()->cart->cart_contents_count;
			?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
			if ( $count > 0 ) {
				?>
				<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
				<?php            
			}
				?></a><?php
		 
			$fragments['a.cart-contents'] = ob_get_clean();
			 
			return $fragments;
		}
		add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


		function add_unit_product_price_display( $price ) {
			$price .= '<span class="demo_price_txt">(Per Piece)</span>';
			return $price;
		}
		add_filter( 'woocommerce_get_price_html', 'add_unit_product_price_display' );
		add_filter( 'woocommerce_cart_item_price', 'add_unit_product_price_display' );


/*
** wooCommerce product details page custom add to cart redirect javacript
*/

function buy_now_submit_form() {
 ?>
  <script>
      jQuery(document).ready(function(){
          // listen if someone clicks 'Buy Now' button
          jQuery('#buy_now_button').click(function(){
              // set value to 1
              jQuery('#is_buy_now').val('1');
              //submit the form
              jQuery('form.cart').submit();
          });
      });
  </script>
 <?php
}
add_action('woocommerce_after_add_to_cart_form', 'buy_now_submit_form');


/*
** wooCommerce product details page custom add to cart redirect 
*/
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
  if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now'] && $_REQUEST['is_buy_now'] == 1) {
  	 $product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_REQUEST['add-to-cart'] ) );
  	 $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
	 $cat_id = (int)$term_list[0];
	 global $woocommerce;
	 if($cat_id == 15){
       $redirect_url = get_permalink( '268');
	 }else if($cat_id == 25){
       $redirect_url = get_permalink( '270 ');
	 }else{
	 	 $redirect_url = wc_get_checkout_url();
	 }
     
    
  }else{
  	$redirect_url = wc_get_checkout_url();
  }
  return $redirect_url;
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'qty_front_add_cart' );
 
function qty_front_add_cart() {
 echo '<div class="qty"> Quantity <span><a href="#" data-toggle="modal" data-target="#quntydis"><img class="woo_ico_sw" src="info.svg" alt=""></a></span> </div>'; 
}

function by_biehle_quantity_input_field_args( $args, $product ) {
	if ( ! $product->is_sold_individually() ) {
		$args['dropdown_steps'] = array( 1, 10, 25, 50, 75, 100, 150, 250 );
	}

	return $args;
}
add_filter( 'woocommerce_quantity_input_args', 'by_biehle_quantity_input_field_args', 10, 2 );



