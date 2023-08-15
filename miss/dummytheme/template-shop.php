<?php
/*
 * Template Name: Shop
 */
get_header();
?>
	<!-- feature-product-shop-page -->
	<div class="shop-product common-gap">
		<div class="container">
			<div class="shop-all">
				<div class="row">
					<div class="col-lg-3">
						<div class="shop-catgr">
							<ul>
								<li class="title-ctgr"><p class="ctg-tx">Categories</p></li>
							
								<?php
			    wp_nav_menu(
				      array(
				        'container'            => '',
                        'container_class'      => '',
                        'container_id'         => '',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s ">%3$s</ul>',
                        'theme_location' => 'menu-3',
				          )); ?>
								
							</ul>
						</div>
					</div>
					<div class="col-lg-9">
						<h4 class="ftr-ttl"><?php echo get_field('shop_title_kpf'); ?></h4>
						<div class="row">
						<?php $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
                               $params = array('posts_per_page' => 9,
                                               'post_type' => 'product',
                                                'paged' => $paged );
                               $wc_query = new WP_Query($params); ?>
         
		              <?php if ($wc_query->have_posts()) : while ($wc_query->have_posts()) : $wc_query->the_post();  ?>
							<div class="col-md-4">
								<div class="featured-info ex-mg-ctg">
									<div class="ftr-img">
										<a href="<?php the_permalink(); ?>"><figure><img alt=" " src="<?php echo get_the_post_thumbnail_url(); ?>"></figure></a>
									</div>
									<div class="ftr-dtls">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<p class="ftr-price"><?php echo $product->get_price_html(); ?></p>
										<?php woocommerce_template_loop_add_to_cart(); ?>  
									</div>
								</div>
							</div>
							<?php endwhile;  wp_reset_postdata();  ?>
                            <?php else:  ?>
                            <p> <?php _e( 'No Products' );  ?> </p>
                            <?php endif; ?>
						
						</div>
						<div class="pagination">
						<?php wp_pagenavi(array( 'query' => $wc_query));?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <?php get_footer(); ?>