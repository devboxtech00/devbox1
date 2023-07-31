<?php echo get_field(''); ?>
<img src="<?php echo get_field('') ['url']; ?>" alt="<?php echo get_field('')['alt']; ?>" title="<?php echo get_field('')['title']; ?>"> 
<?php while (have_rows('')): the_row(); ?>
<?php endwhile; ?>
<?php echo get_sub_field(''); ?>
<?php while (have_rows('')): the_row(); ?>
<img src="<?php echo get_sub_field('') ['url']; ?>" alt="<?php echo get_sub_field('')['alt']; ?>" title="<?php echo get_field('')['title']; ?>">              
<?php endwhile; ?>

<?php //acf with acrodin ?>



<?php 
$link = get_field('link');
if( $link ): 
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
    <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
<?php endif; ?>


<?php 

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
}	

?>


<!-- //for option page -->

<?php the_field( 'posted_of', 'option' ); ?>

	    <?php while( have_rows('repeater', 'option') ): the_row(); ?>

        <li><?php the_sub_field('title'); ?></li>

    <?php endwhile; ?>
	
	 <?php $logo = get_field( 'logo_ho', 'option' ); ?>
      <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">

<!--       post query -->

  <?php
            $terms = get_terms(
    array(
        'taxonomy'   => 'valve_croseover',
        'hide_empty' => false,
    )
);
// Check if any term exists
if ( ! empty( $terms ) && is_array( $terms ) ) {
    // Run a loop and print them all
    foreach ( $terms as $term ) { ?>
     <div class="col-md-6"> 
    
     <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
      <a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
            <?php echo $term->name; ?>
        </a></div><?php
    
     
     


       
    }
} 


// postloop

  $mypost =  get_sub_field("mypostacffrild");

    $myposttId = $mypost->ID;
    if($myposttId){
        $mypostPermalink = get_permalink($myposttId);
        $mypostTitle = get_the_title($myposttId);
        $mypostImage = wp_get_attachment_image_src( get_post_thumbnail_id($myposttId ), 'single-post-thumbnail' );
        $mypostmeta=get_field("mypostmeta",$myposttId);
    }
        


// acf curd

$product_row = array(
    'product_name_slsn'   => $title,
  'product_descriptions_slsn'   => $description,
  'product_image_slsn'   => $imageurl,
  'product_price_slsn'   => $price,
  'product_host_site_slsn'   => $hostname,
  'product_host_url_slsn'   => $hoisturl,
  'mark_as_purchased_listsave' => 'no',
  'timmer_satus_item' => false,
  'item_unique_id_ls' => uniqid()
);
add_row('save_products_slsn', $product_row, $postid);


$row = array(
    'product_name_slsn'   => $_POST['list_name'],
);
update_row('save_products_slsn', round($_POST['list_no']) , $row , round( $_POST['list_id']));
delete_row('save_products_slsn',round($_POST['list_no']), round( $_POST['list_id']));









           







?>
      


