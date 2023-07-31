<?php
function wpdocs_custom_excerpt_length( $length ) {
    return 10;
 }
 add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length' );

function wpdocs_excerpt_more( $more ) {
    return '..';
}
 add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

 	
function listsave_add_woocommerce_support() {
	add_theme_support( 'woocommerce');
  
  }
  add_action( 'after_setup_theme', 'listsave_add_woocommerce_support' );
  add_theme_support( 'wc-product-gallery-slider' );

  function my_post_time_ago_function() {
    return sprintf( esc_html__( '%s ago', 'textdomain' ), human_time_diff(get_the_modified_time ( 'U' ), current_time( 'timestamp' ) ) );
    }

    add_filter( 'the_modified_time', 'my_post_time_ago_function');

    if ( is_user_logged_in() ) :
        // add author on posturl
        global $wp_rewrite; 
    
        //Write the rule
        $wp_rewrite->set_permalink_structure('/%author%/%postname%/'); 
    
        //Set the option
        update_option( "rewrite_rules", FALSE ); 
    
        // add author on pageurls
    
            //Flush the rules and tell it to write htaccess
            $wp_rewrite->flush_rules( true );
      
        function custom_base_rules() {
            global $wp_rewrite;
            
            $user = get_user_by( 'id', get_current_user_id() ); 
            $wp_rewrite->page_structure = $wp_rewrite->root . $user->user_login.'/%pagename%/';
        }
    
        add_action( 'init', 'custom_base_rules' );
            // login_redirect
            add_filter( 'login_redirect', function( $url, $query, $user ) {
    
                return home_url($user->user_login);
            }, 10, 3 );
            
    
        endif;
        global $user_ID;

        $new_post = array(
            'post_name'  => $list_title,
            'post_title' => $list_title,
            'post_content' => $list_des,
            'post_status' => 'publish',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $user_ID,
            'post_type' => 'post',
            'meta_input' => array(
                'mypost_mete_key' =>'metavalue',
                'mypost_mete_key' =>'metavalue',
            )
     
            );
    
        wp_insert_post($new_post,$wp_error);

            $new_post = array(
            'ID'           => $_POST['list_id'],
            'post_title'   => $_POST['list_name'],
            //'post_content' => 'This is the updated content.',
        );
        wp_update_post( $new_post );


        
function custom_post_type() {
  
    //UI 
        $labels = array(
            'name'                => _x( 'myposts', 'Post Type General Name', 'textdomain' ),
            'singular_name'       => _x( 'mypost', 'Post Type Singular Name', 'textdomain' ),
            'menu_name'           => __( 'myposts', 'textdomain' ),
            'parent_item_colon'   => __( 'Parent mypost', 'textdomain' ),
            'all_items'           => __( 'All myposts', 'textdomain' ),
            'view_item'           => __( 'View mypost', 'textdomain' ),
            'add_new_item'        => __( 'Add New mypost', 'textdomain' ),
            'add_new'             => __( 'Add New', 'textdomain' ),
            'edit_item'           => __( 'Edit mypost', 'textdomain' ),
            'update_item'         => __( 'Update mypost', 'textdomain' ),
            'search_items'        => __( 'Search mypost', 'textdomain' ),
            'not_found'           => __( 'Not Found', 'textdomain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'textdomain' ),
        );
          
    // options 
          
        $args = array(
            'label'               => __( 'myposts', 'textdomain' ),
            'description'         => __( 'ALL mypost Details', 'textdomain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'taxonomies'          => array( 'genres' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-open-folder',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
            'rewrite' => array( 'slug' => 'training-mypost' ),
      
        );
          
        // Registering your Custom Post Type
        register_post_type( 'training-mypost', $args );
    }
    function create_custom_taxonomy() {
   
        $labels = array(
          'name' => _x( 'custom tax', 'cutextdomain' ),
          'singular_name' => _x( 'custom tax sin', 'cutextdomain' ),
          'search_items' =>  __( 'Search  custom tax' ),
          'all_items' => __( 'All  custom tax' ),
          'parent_item' => __( 'Parent custom tax sin' ),
          'parent_item_colon' => __( 'Parent custom tax sin:' ),
          'edit_item' => __( 'Edit custom tax sin' ), 
          'update_item' => __( 'Update custom tax sin' ),
          'add_new_item' => __( 'Add New custom tax sin' ),
          'new_item_name' => __( 'New custom tax sin Name' ),
          'menu_name' => __( ' custom tax' ),
        );    
       
      // Now register the taxonomy
        register_taxonomy('customtax',array('post_type'), array(
          'hierarchical' => true,
          'labels' => $labels,
          'show_ui' => true,
          'show_in_rest' => true,
          'show_admin_column' => true,
          'show_in_menu' => true,
          'query_var' => true,
          'rewrite' => array( 'slug' => 'customtax' ),
        ));
       
      }
      add_action( 'init', 'create_custom_taxonomy', 0 );

      add_shortcode('myshrotcode', 'shortcode_cb'); 
            
        function shortcode_cb($atts) {
            $default = array(
                'id' => "0",
                'name' => "steven"
            );
        }

        //output
     echo do_shortcode('[myshrotcode id="14" name="Ben"]'); 


add_action( 'wp_ajax_nopriv_actionname', 'cb_func' );
add_action( 'wp_ajax_actionname', 'cb_func' );


function cb_func(){
	

    die();
}
  

if ( isset( $_POST['emailfrom'] ) ){
$email = $_POST['email'];
}

// add tags on CPTUI
add_action( 'pre_get_posts', function ( $q )
{
    if (  !is_admin() // Only target front end queries
          && $q->is_main_query() // Only target the main query
          && $q->is_tag()        // Only target tag archives
    ) {
        $q->set( 'post_type', ['post', 'post_review'] ); // Change 'custom_post_type' to YOUR Custom Post Type
                                                              // You can add multiple CPT's separated by comma's
    }
});


// https://rudrastyh.com/wordpress/load-more-posts-ajax.html  (custom load more)


// https://stripe.com/docs/testing