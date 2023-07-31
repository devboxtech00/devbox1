<?php $i=1;
       $params = array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'product_cat' => 'cake',
);
$wc_query = new WP_Query($params); 
?>
<?php if ($wc_query->have_posts()) :  ?>
<?php while ($wc_query->have_posts()) : 
                $wc_query->the_post();  ?>
<div id="accordion">

<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <div class="mb-0 product_accordin">
        <button class="btn btn-link collapsed acc_btn" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseThree">
          <h3><?php the_title(); ?></h3>
          <h5><?php echo $product->get_price_html(); ?></h5>
          <p><?php the_content(); ?></p>
        </button>
       </div>
    </div>
    <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion">
      <div class="card-body">
   
      <?php woocommerce_template_loop_add_to_cart(); ?>  
      </div>
    </div>
  </div>
</div>

<?php $i++;
endwhile; ?>
<?php wp_reset_postdata();  ?>
<?php else:  ?>
<p>
     <?php _e( 'No Products' );  ?>
</p>
<?php endif; ?>
</div>
</div>
<!--shop body -->

<?php

add_action( 'woocommerce_before_add_to_cart_button', 'addprice_before_add_to_cart_btn' );
function addprice_before_add_to_cart_btn(){
  global $product;
  echo '<div class="btn-price">'.$product->get_price_html().'</div>';
}


add_action( 'woocommerce_before_add_to_cart_button', 'woocommerce_total_product_price', 25 );
function woocommerce_total_product_price() {
    global $woocommerce, $product;
    // let's setup our divs
    echo sprintf('<div id="product_total_price" style="font-size: 16px; font-weight: 200;">%s %s</div>',__('Total Price (incl Tax):','woocommerce'),'<span class="price">'. get_woocommerce_currency_symbol() .' ' .$product->get_price().'</span>');
    ?>
        <script>
            jQuery(function($){
                var price = <?php echo $product->get_price(); ?>,
                    currency = '<?php echo get_woocommerce_currency_symbol(); ?>';

                $('[name=quantity]').change(function(){
                    if (!(this.value < 1)) {

                        var product_total = parseFloat(price * this.value);

                        $('#product_total_price .price').html( currency + product_total.toFixed(0));

                    }
                });
            });
        </script>
    <?php
}


// page link
// https://www.cloudways.com/blog/add-woocommerce-registration-form-fields/
// <!-- reg feilds -->


function wooc_extra_register_fields() {?>
       <p class="form-row form-row-wide">
       <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
       </p>
       <p class="form-row form-row-first">
       <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
       </p>
       <p class="form-row form-row-last">
       <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
       </p>
       <div class="clear"></div>
       <?php
 }
 add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );










$loop = new WP_Query( array(
    'post_type' => 'product',
    'posts_per_page' => 12,
) );

if ($loop->have_posts()) {
    while ($loop->have_posts()): $loop->the_post();
      $product = wc_get_product($loop->post->ID);
      ?>









<div class="package_slider">
                  <?php 
                  $params = array(
                  'posts_per_page' => -1,
                   'post_type' => 'product',
                   'product_cat' => 'packaging',
                    );
                    $wc_query = new WP_Query($params); 
                   if ($wc_query->have_posts()) :  
                   while ($wc_query->have_posts()) : $wc_query->the_post();  ?>
                   <div>
                   <div class="pch_slider_box">
                      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                      <h2><?php the_title(); ?></h2>
                      </div>
                       </div>
                       <?php endwhile; ?>
                  <?php wp_reset_postdata();  ?>
                  <?php else:  ?>
                  <p><?php _e( 'No Products' );  ?></p>
                  <?php endif; ?>
                       </div>
                     </div>






      
        <!-- tab product -->
        <li class="col-sx-12 col-sm-4">
          <div class="product-container">
            <div class="left-block">
              <a href="<?php echo get_permalink(); ?>" target="_blank">
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail');?>
                <img height="300px" width="300px" class="img-responsive" alt="product" src="<?php echo $image[0]; ?>">
              </a>
              <div class="quick-view">

              </div>
              <div class="add-to-cart "><?php
                echo sprintf( '<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( implode( ' ', array_filter( array(
                        'button', 'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                    ) ) ) ),
                    wc_implode_html_attributes( array(
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ) ),
                    esc_html( $product->add_to_cart_text() )
                );
              ?></div>
            </div>
            <div class="right-block">
              <h5 class="product-name">
                <a href="<?php echo get_permalink(); ?>" target="_blank" class="product-block-click">
                  <?php echo $product->get_title(); ?>
                </a>
              </h5>
              <div class="content_price">
                <span class="price product-price">
                  <i class="fa fa-inr" aria-hidden="true">
                  </i>
                  <?php echo $product->get_regular_price(); ?>
                </span>
                <span class="price old-price">
                  <i class="fa fa-inr" aria-hidden="true">
                  </i>
                  <?php echo $product->get_sale_price(); ?>
                </span>
                <span class="discount-block">50 % OFF
                </span>
              </div>
            </div>
          </div>
        </li>
      <?php
    endwhile;
}
echo "</ul>";
wp_reset_postdata();


add_filter( 'woocommerce_product_add_to_cart_text', 'bbloomer_archive_custom_cart_button_text' );
 
function bbloomer_archive_custom_cart_button_text() {
global $product;       
if ( has_term( 'category1', 'product_cat', $product->ID ) ) {           
return 'Category 1 Add Cart';
} else {
return 'Category 2 Buy Now';
}
}






