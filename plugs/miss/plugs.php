<?php
/**
* Plugin Name: My Plguin
* Plugin URI: https://www.google.com
* Description: It's a Live Chat Plguin
* Version: 2.0
* Requires at least: 6.0
* Requires PHP: 7.0
* Author: Webdev
* Author URI: * Plugin Name: My Plguin
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: textdomain
* Domain Path: /languages
*/
/*
My Plguin is a  It's a Live Chat Plguin.
My Plguin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with My Plguin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'My_Plguin' )){
    class My_Plguin {
       function __construct() {
          $this->define_constants(); 
          $this->load_textdomain();
          require_once( My_Plguin_PATH . "functions/functions.php" );
          require_once( My_Plguin_PATH . "functions/apiloginv2.php" );
          require_once( My_Plguin_PATH . "/addons/reviews/functions.php");

          require_once( My_Plguin_PATH . 'usermeta/class.pc-usermeta.php' );
          $My_Plguin_usermeta = new My_Plguin_usermeta();
          require_once( My_Plguin_PATH . 'shortcodes/userstatus_sc.php' );
          $My_Plguin_userstatus_shortcode = new My_Plguin_userstatus_shortcode();


          add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );
          add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts') );
         }

      public function load_textdomain(){
          load_plugin_textdomain(
              'textdomain',
              false,
              dirname( plugin_basename( __FILE__ ) ) . '/languages/'
          );
      }
      public function define_constants(){
          define( 'My_Plguin_PATH', plugin_dir_path( __FILE__ ) );
          define( 'My_Plguin_URL', plugin_dir_url( __FILE__ ) );
          define( 'My_Plguin_VERSION', '1.0.0' );
      }
      public static function activate(){
      update_option( 'rewrite_rules', '' );
      add_role(
              'customer', //  System name of the role.
              __( 'Customer',' textdomain'  ), // Display name of the role.
              array(
                  'read'  => true,
                  'delete_posts'  => true,
                  'delete_published_posts' => true,
                  'edit_posts'   => true,
                  'publish_posts' => true,
                  'upload_files'  => true,
                  'edit_pages'  => true,
                  'edit_published_pages'  =>  true,
                  'publish_pages'  => true,
                  'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
              )
          );

      global $wpdb;
      $charset_collate = $wpdb->get_charset_collate();
      $table_name = $wpdb->prefix . 'userinfo';
           $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            applicationtime datetime  NOT NULL,
            fullname1 varchar(30) NOT NULL,
            emailadrss1 varchar(30) NOT NULL,
            ipadress LONGTEXT NOT NULL,
            useruniqueid varchar(500) NOT NULL,
            customername varchar(30) NOT NULL,
            customerid varchar(30) NOT NULL,
            customerrole varchar(30) NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
       $charset_collate = $wpdb->get_charset_collate();
      $table_name = $wpdb->prefix . 'usermessage';

           $sql_msg = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            applicationtime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            incomingid varchar(500) NOT NULL,
            outgoingid varchar(500) NOT NULL,
            messages varchar(10000) NOT NULL,
            imageurl LONGTEXT NOT NULL,
            customerid varchar(30) NOT NULL,
            customername varchar(30) NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_msg );

        if( $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'user_paymentsucess'" ) === null ){
          $current_user = wp_get_current_user();
          $page = array(
              'post_title'    => __('Page 2', ' textdomain' ),
              'post_name' => 'page2',
              'post_status'   => 'publish',
              'post_author'   => $current_user->ID,
              'post_type' => 'page',
              'post_content'  => '<!-- wp:shortcode -->[myshortcode]<!-- /wp:shortcode -->'
          );
          wp_insert_post( $page );
      }

      if( $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'user_default'" ) === null ){
          $current_user = wp_get_current_user();
          $page = array(
              'post_title'    => __('Page 1', ' textdomain' ),
              'post_name' => 'page1',
              'post_status'   => 'publish',
              'post_author'   => $current_user->ID,
              'post_type' => 'page',
              'post_content'  => '<!-- wp:shortcode -->[myshortcode]<!-- /wp:shortcode -->'
          );
          wp_insert_post( $page );
      }

  }
     public static function deactivate(){
          flush_rewrite_rules();
      }

      public static function uninstall(){}

          public function register_admin_scripts(){
              global $typenow;
                 
          }
          public function register_scripts(){
              

          }
      }
  }



if( class_exists( 'My_Plguin' ) ){
  register_activation_hook( __FILE__, array( 'My_Plguin', 'activate' ) );
  register_deactivation_hook( __FILE__, array( 'My_Plguin', 'deactivate' ) );
  register_uninstall_hook( __FILE__, array( 'My_Plguin', 'uninstall' ) );

  $My_Plguin = new My_Plguin();

 // vendor scripts
  require_once( My_Plguin_PATH . 'vendor/file/dcript.php' );
}



      

