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




