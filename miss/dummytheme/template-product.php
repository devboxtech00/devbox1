<?php
/**
 * Template Name: Store
 */
get_header();
?>

     <!--Banner Section-->
  <div class="banner_section inner_banner_section" style="background-image: url(<?php bloginfo('template_directory')?>/images/inner_banner.jpg); background-repeat: no-repeat; background-position: center center; background-size: cover;">
    <div class="container-fluid">
      <div class="row inner_banner_row">
        <div class="col-lg-6 banner_txt_box_outr">
         <div class="inner_banner_txt_outr" data-aos="fade-right">
            <div class="banner_txt">
                <div class="banner_heading">
                  <h1><?php echo get_field('title_sb'); ?></h1>
                  <span><?php echo get_field('title_sb'); ?></span>  
                </div>
            </div>
            <div class="brdcumb_wrppr">
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo get_field('title_sb'); ?></li>
                    </ul>
                </nav>
            </div>
         </div>
        </div>
      </div>
    </div>
    <div class="shape13">
      <img src="<?php bloginfo('template_directory')?>/images/shape13.png" alt="" />
    </div>
    <div class="shape14">
        <img src="<?php bloginfo('template_directory')?>/images/shape14.png" alt="" />
    </div>
  </div>
<!--Banner Section-->
 <!--Listing Section-->
 <div class="lstng_section common_gap">
    <div class="container-fluid">
        <div class="prdct_fund_txt">
        <?php $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; ?>   
            <?php
        $args = array( 'post_type' => 'product', 'post_status' => 'publish', 
'posts_per_page' => 8, 'paged' => $paged);
$products = new WP_Query( $args );
$products->found_posts;
?>
            <p><span><?php echo $products->found_posts;  ?></span> products found..</p>
        </div>
      <div class="row prdct_dtls_row">
        <div class="col-lg-3 prdct_lstng_lft">
            <div class="prdct_lstng_lnk_wrppr" data-aos="fade-right">
                <div class="prdct_lstng_lnk_box">
                    <h5>Shop by Category</h5>
                    <?php
			        wp_nav_menu(
				         array(
					      'container'            => '',
                'container_class'      => '',
                 'container_id'         => '',
                'items_wrap'     => '<ul id="%1$s" class="%2$s ">%3$s</ul>',
              'theme_location' => 'menu-3',
                                     )); ?>
                </div>
                <div class="prdct_lstng_lnk_box">
                    <h5>Shop by Material</h5>
                    <?php
			        wp_nav_menu(
				         array(
					      'container'            => '',
                'container_class'      => '',
                 'container_id'         => '',
                'items_wrap'     => '<ul id="%1$s" class="%2$s ">%3$s</ul>',
              'theme_location' => 'menu-4',
                                     )); ?>
                </div>
            </div>      
        </div>
        <div class="col-lg-9 prdct_lstng_rght">
           <div class="prdct_lstng_rght_innr">
               <div class="row prdct_lstng_box_row">
            
               <?php $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; ?>  

<?php 
               $params = array(
               'posts_per_page' => 8,
               'post_type' => 'product',
               'paged' => $paged
            
            );
                $wc_query = new WP_Query($params); ?>
               <?php if ($wc_query->have_posts()) :  ?>
               <?php while ($wc_query->have_posts()) : 
                $wc_query->the_post();  ?>
                   <div class="col-xl-3 col-md-4 col-6 prdct_lstng_box">
                        <div class="bst_prdct_box" data-aos="fade-down">
                            <div class="bst_prdct_img">
                            <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" /></a>
                            </div>
                            <div class="bst_prdct_dscrptn">
                            <h6><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h6>
                            <p><?php the_excerpt(); ?></p>
                                <div class="prdct_prce_box">
                                <div class="prce_tag">
                                    <h3><?php echo $product->get_price_html(); ?></h3>
                                </div>
                                <div class="prdct_cart">
                                    <a href="<?php echo $product->add_to_cart_url(); ?>"><img src="<?php bloginfo('template_directory')?>/images/cart_icon.png" alt="" /></a>
                                </div>
                                </div>
                            </div>
                        </div>
                   </div>
                    
                   <?php endwhile;  wp_reset_postdata();  ?>
                  <?php else:  ?>
                    <p> <?php _e( 'No Products' );  ?> </p>
                    <?php endif; ?>
                
             
               <div class="pgntn_hldr">

               <?php wp_pagenavi(array( 'query' => $wc_query));?>
                <!-- <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                                <span aria-hidden="true">
                                    <img src="<?php //bloginfo('template_directory')?>/images/lArrow.png" alt="" />
                                </span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                        <li class="page-item "><a class="page-link" href="javascript:void(0);">2</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" aria-label="Next">
                                <span aria-hidden="true">
                                 <img src="<?php // bloginfo('template_directory')?>/images/rArrow.png" alt="" />
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav> -->
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>    
 <!--Listing Section-->

 <?php get_footer(); ?>