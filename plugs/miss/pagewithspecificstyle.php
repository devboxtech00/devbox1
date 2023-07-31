<?php
if( !class_exists( 'myplhuin_views') ){

class myplhuin_views {
    public function __construct(){
      add_action("admin_menu", array($this,"setup_theme_admin_menus"));
    }

   function setup_theme_admin_menus() {
      $mypage = add_menu_page(
        __( 'Page 1', 'textdomaain' ),
        __( 'Page 1', 'textdomaain' ),
        'read', 
        'textdomaain_form_settings', 'add_form_menue_cb','dashicons-category',10
      );

      $mypage_subpage = add_submenu_page('textdomaain_form_settings', 
      __( 'Page 1 2', 'textdomaain' ),
      __( 'Page 1 2', 'textdomaain' ),
        'read', 
      'edit_types', 'mypage_subpage_cb'
      ); 

      
      $mypage_subpage_blank = add_submenu_page('', 
      __( 'Edit Form Field', 'textdomaain' ),
      __( 'Edit Form Field', 'textdomaain' ),
        'read', 
      'edit_form_field', 'blank_cb'
      ); 

    
      function  add_form_menue_cb() {
        require( MY_TESTPLGUGIN_PATH . 'views/textdomaain_form_list.php' );
       }
       function  mypage_subpage_cb() {
        require( MY_TESTPLGUGIN_PATH . 'views/textdomaain_edit_fields.php' );
        }
        function  blank_cb() {
          require( MY_TESTPLGUGIN_PATH . 'views/edit_form_fields.php' );
        }

        add_action( 'admin_print_styles-' . $menu_form,  'admin_custom_css' );
        add_action( 'admin_print_styles-' . $menu_form,  'admin_custom_js' );
        add_action( 'admin_print_styles-' . $mypage_subpage,  'admin_custom_css' );
        add_action( 'admin_print_styles-' . $mypage_subpage,  'admin_custom_js' );
        add_action( 'admin_print_styles-' . $mypage_subpage_blank,  'admin_custom_css' );
        add_action( 'admin_print_styles-' . $mypage_subpage_blank,  'admin_custom_js' );
       
        function admin_custom_css(){
          wp_enqueue_style( 'MY_TESTPLGUGIN-bs5', MY_TESTPLGUGIN_URL . 'assets/css/bootstrap.min.css', '1.0');
          wp_enqueue_style( 'MY_TESTPLGUGIN-datatable', MY_TESTPLGUGIN_URL . 'assets/css/dataTables.bootstrap4.min.css', '1.0');
          wp_enqueue_style( 'MY_TESTPLGUGIN-datatbaleresposive', MY_TESTPLGUGIN_URL . 'assets/css/responsive.bootstrap4.min', '1.0');
          // wp_enqueue_style( 'MY_TESTPLGUGIN-sleek', MY_TESTPLGUGIN_URL . 'assets/css/sleek.min.css', '1.0');
          wp_enqueue_style( 'MY_TESTPLGUGIN-admincss', MY_TESTPLGUGIN_URL . 'assets/css/style.css', time());
       }
       function admin_custom_js(){
        wp_enqueue_script( 'MY_TESTPLGUGIN-dtbs4', MY_TESTPLGUGIN_URL . 'assets/js/dataTables.bootstrap4.min.js' ,'1.0');
        wp_enqueue_script( 'MY_TESTPLGUGIN-dtrs', MY_TESTPLGUGIN_URL . 'assets/js/dataTables.responsive.min.js' ,'1.0');
        wp_enqueue_script( 'MY_TESTPLGUGIN-dt', MY_TESTPLGUGIN_URL . 'assets/js/jquery.dataTables.min.js' ,'1.0');
       }
    }
}
}