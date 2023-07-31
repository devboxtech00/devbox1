<?php
if( !class_exists( 'My_Plugin_usermeta') ){
    class My_Plugin_usermeta {

            function __construct(){

                add_action('show_user_profile', array($this, 'user_widgetForm')); // editing your own profile
                add_action('edit_user_profile', array($this,'user_widgetForm')); // editing another user
                do_action('user_new_form',  array($this,'user_widgetForm')); // creating a new user

                add_action('personal_options_update', array($this,'user_widgetSave'));
                add_action('edit_user_profile_update', array($this,'user_widgetSave'));
                //add_action('user_register', array($this,'user_widgetSave'));



                
            }

             function user_widgetForm(WP_User $user) {
                require_once( My_Plugin_PATH . 'views/user_metabox.php' );
            }
            public  function user_widgetSave($userId) {
                    if (!current_user_can('edit_user', $userId)) {
                        return;

                    }

            update_user_meta($userId, 'user_widget', $_REQUEST['user_widget_box']);
            update_user_meta($userId, 'user_avibility', $_REQUEST['user_avibility_box']);
            }


        
            }





    }














