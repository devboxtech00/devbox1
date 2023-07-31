<?php

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
	 	// $redirect_url = wc_get_checkout_url();
	 }
     
    
}else{
  $redirect_url = wc_get_checkout_url();
 }
return $redirect_url;
}