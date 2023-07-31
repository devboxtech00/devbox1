<?php


if( !class_exists( 'Custom_Dummy_Forms_wpc_menu') ){

  class Custom_Dummy_Forms_wpc_menu {
      public function __construct(){
        add_action("admin_menu", array($this,"setup_theme_admin_menus"));
      }
  


      function setup_theme_admin_menus() {
        $menu_form = add_menu_page(
          __( 'wpc Forms', 'wpc' ),
          __( 'wpc Forms', 'wpc' ),
          'read', 
          'wpc_form_settings', 'add_form_menue_cb','dashicons-category',10
        );

        $edit_types = add_submenu_page('wpc_form_settings', 
        __( 'Edit Field Types', 'wpc' ),
        __( 'Edit Field Types', 'wpc' ),
          'read', 
        'edit_types', 'edit_types_cb'
        ); 

        
        $edit_forms = add_submenu_page('', 
        __( 'Edit Form Field', 'wpc' ),
        __( 'Edit Form Field', 'wpc' ),
          'read', 
        'edit_form_field', 'edit_form_field_cb'
        ); 

        $form_entries = add_submenu_page('wpc_form_settings', 
        __( 'Form Entries', 'wpc' ),
        __( 'Form Entries', 'wpc' ),
          'read', 
        'form_entries', 'form_entries_cb'
        ); 

        $form_entries_details = add_submenu_page('', 
        __( 'Form Entries Details', 'wpc' ),
        __( 'Form Entries Details', 'wpc' ),
          'read', 
        'form_entries_view', 'form_entries_details_cb'
        ); 
        
        function  add_form_menue_cb() {
          require( Custom_Dummy_Forms_PATH . 'views/wpc_form_list.php' );
         }
         function  edit_types_cb() {
          require( Custom_Dummy_Forms_PATH . 'views/wpc_edit_fields.php' );
          }
          function  edit_form_field_cb() {
            require( Custom_Dummy_Forms_PATH . 'views/edit_form_fields.php' );
          }
          function  form_entries_cb() {
              require( Custom_Dummy_Forms_PATH . 'views/form_entries_cb.php' );
          }
          function  form_entries_details_cb() {
            require( Custom_Dummy_Forms_PATH . 'views/form_entries_details_cb.php' );
        }
          add_action( 'admin_print_styles-' . $menu_form,  'admin_custom_css' );
          add_action( 'admin_print_styles-' . $menu_form,  'admin_custom_js' );
          add_action( 'admin_print_styles-' . $edit_types,  'admin_custom_css' );
          add_action( 'admin_print_styles-' . $edit_types,  'admin_custom_js' );
          add_action( 'admin_print_styles-' . $edit_forms,  'admin_custom_css' );
          add_action( 'admin_print_styles-' . $edit_forms,  'admin_custom_js' );
          add_action( 'admin_print_styles-' . $form_entries,  'admin_custom_css' );
          add_action( 'admin_print_styles-' . $form_entries,  'admin_custom_js' );
          add_action( 'admin_print_styles-' . $form_entries_details,  'admin_custom_css' );
          add_action( 'admin_print_styles-' . $form_entries_details,  'admin_custom_js' );

          function admin_custom_css(){
            wp_enqueue_style( 'Custom_Dummy_Forms-bs5', Custom_Dummy_Forms_URL . 'assets/css/bootstrap.min.css', '1.0');
            wp_enqueue_style( 'Custom_Dummy_Forms-datatable', Custom_Dummy_Forms_URL . 'assets/css/dataTables.bootstrap4.min.css', '1.0');
            wp_enqueue_style( 'Custom_Dummy_Forms-datatbaleresposive', Custom_Dummy_Forms_URL . 'assets/css/responsive.bootstrap4.min', '1.0');
            // wp_enqueue_style( 'Custom_Dummy_Forms-sleek', Custom_Dummy_Forms_URL . 'assets/css/sleek.min.css', '1.0');
            wp_enqueue_style( 'Custom_Dummy_Forms-admincss', Custom_Dummy_Forms_URL . 'assets/css/style.css', time());
         }
         function admin_custom_js(){
          wp_enqueue_script( 'Custom_Dummy_Forms-dtbs4', Custom_Dummy_Forms_URL . 'assets/js/dataTables.bootstrap4.min.js' ,'1.0');
          wp_enqueue_script( 'Custom_Dummy_Forms-dtrs', Custom_Dummy_Forms_URL . 'assets/js/dataTables.responsive.min.js' ,'1.0');
          wp_enqueue_script( 'Custom_Dummy_Forms-dt', Custom_Dummy_Forms_URL . 'assets/js/jquery.dataTables.min.js' ,'1.0');
         }
      }
      
      


    }
}