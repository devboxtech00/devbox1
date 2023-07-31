<?php
/**
* Plugin Name: Custom Dummy Forms
* Description: It's a Business Management Plguin
* Version: 1.0
* Requires at least: 5.0
* Requires PHP: 7.0
* Author: Custom Dummy Forms
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpc
* Domain Path: /languages
*/
/*
Custom Dummy Forms is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Custom Dummy Forms. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'Custom_Dummy_Forms' )){
    class Custom_Dummy_Forms {
        function __construct() {
			$this->define_constants(); 
			//$this->load_textdomain();
            require_once( Custom_Dummy_Forms_PATH . "functions/inner_function.php" );
            require_once( Custom_Dummy_Forms_PATH . 'modules/wpcMenu.php' );
            $Custom_Dummy_Forms_wpc_menu = new Custom_Dummy_Forms_wpc_menu();
            require_once( Custom_Dummy_Forms_PATH . 'modules/form-shortcode.php' );
            $Custom_Dummy_Forms_formshortcode = new Custom_Dummy_Forms_formshortcode();

            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts'));
        }

        public function define_constants(){
			define( 'Custom_Dummy_Forms_PATH', plugin_dir_path( __FILE__ ) );
			define( 'Custom_Dummy_Forms_URL', plugin_dir_url( __FILE__ ) );
			define( 'Custom_Dummy_Forms_VERSION', '1.0.0' );
		}

        public static function activate(){
            global $wpdb;
      
            $form_fields_table = $wpdb->prefix."wpc_fieldtype";
            $form_table = $wpdb->prefix."wpc_forms";
            $form_data = $wpdb->prefix."wpc_forms_data";
            $form_submission  = $wpdb->prefix."wpc_forms_submission";
            $wpc_db_version = '1.0.0';
            $charset_collate = $wpdb->get_charset_collate();
      
            /* Field Type */
            $wpc_form_field_type_sql = "CREATE TABLE $form_fields_table (
              id mediumint(11) NOT NULL AUTO_INCREMENT,
              created_on datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              field_type varchar(500) NOT NULL,
              field_label varchar(500) NOT NULL,
              UNIQUE KEY id (id)
          ) $charset_collate;";
      
              require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
              dbDelta($wpc_form_field_type_sql);

                $init_form_table = "CREATE TABLE $form_table (
                id mediumint(100) NOT NULL AUTO_INCREMENT,
                created_on datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                form_name varchar(500) NOT NULL,
                UNIQUE KEY id (id)
                ) $charset_collate;";
        
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($init_form_table);
            
                  $init_form_submission_table = "CREATE TABLE $form_submission (
                id mediumint(100) NOT NULL AUTO_INCREMENT,
                created_on datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                form_id mediumint(100) NOT NULL,
                form_name varchar(500) NOT NULL,
                form_data varchar(1000) NOT NULL,
                admin_status varchar(100) NOT NULL,
                UNIQUE KEY id (id)
                ) $charset_collate;";
        
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($init_form_submission_table);

                $init_form_data = "CREATE TABLE $form_data (
                    id bigint(100) NOT NULL AUTO_INCREMENT,
                    created_on datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                    form_id bigint(100) NOT NULL,
                    field_id varchar(100) NOT NULL,
                    field_name varchar(500) NOT NULL,
                    field_lablel varchar(500) NOT NULL,
                    field_placeholder varchar(500)  NULL,
                    field_type varchar(100) NOT NULL,
                    field_value varchar(255)  NULL,
                    field_score bigint(100)  NULL,
                    isrequired boolean  NULL,
                    islabel boolean  NULL,
                    isplaceholder boolean  NULL,
                    UNIQUE KEY id (id)
                    ) $charset_collate;";
            
                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($init_form_data);


                    
    

              
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        public function register_admin_scripts(){
            //style sheets
         
        //     // wp_enqueue_style( 'Custom_Dummy_Forms-bs5', Custom_Dummy_Forms_URL . 'assets/css/bootstrap.min.css', '1.0');
        //     wp_enqueue_style( 'Custom_Dummy_Forms-datatable', Custom_Dummy_Forms_URL . 'assets/css/dataTables.bootstrap4.min.css', '1.0');
        //     wp_enqueue_style( 'Custom_Dummy_Forms-datatbaleresposive', Custom_Dummy_Forms_URL . 'assets/css/responsive.bootstrap4.min', '1.0');
               wp_enqueue_style( 'Custom_Dummy_Forms-fontawsome', Custom_Dummy_Forms_URL . 'assets/css/all.min.css', '1.0');
            
            //scripts
            // wp_enqueue_script( 'Custom_Dummy_Forms-dtbs4', Custom_Dummy_Forms_URL . 'assets/js/dataTables.bootstrap4.min.js' ,'1.0');
            // wp_enqueue_script( 'Custom_Dummy_Forms-dtrs', Custom_Dummy_Forms_URL . 'assets/js/dataTables.responsive.min.js' ,'1.0');
            // wp_enqueue_script( 'Custom_Dummy_Forms-dt', Custom_Dummy_Forms_URL . 'assets/js/jquery.dataTables.min.js' ,'1.0');
            wp_enqueue_script( 'Custom_Dummy_Forms-customjs', Custom_Dummy_Forms_URL . 'assets/js/custom.js' ,time());
        }

    }   
}

if( class_exists( 'Custom_Dummy_Forms' ) ){
    register_activation_hook( __FILE__, array( 'Custom_Dummy_Forms', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'Custom_Dummy_Forms', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'Custom_Dummy_Forms', 'uninstall' ) );

    $Custom_Dummy_Forms = new Custom_Dummy_Forms();
}
