
<!-- add product -->
<?php
$product = new WC_Product_Simple();
          $product->set_name( $title ); // product title
          $product->set_slug( $title );
          $product->set_regular_price($price); // in current shop currency
          $product->set_short_description($description);
          $product->set_image_id(29);
          $product->save();


          wp_redirect($your_post_url . '&submitform=1');
          exit;
        //   Then you can just test if "submitform" is defined to display what you want :
          
          // test submitform url setting :
          if (isset($_GET['submitform'])) :
              echo '<div class="successmessage"><p>' . __('Your Success message.') . '</p></div>';
          endif;
          
          
          
          
          // confrim psswoard feilds
          
          // ----- validate password match on the registration page
          function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
              global $woocommerce;
              extract( $_POST );
              if ( strcmp( $password, $password2 ) !== 0 ) {
                  return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
              }
              return $reg_errors;
          }
          add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
          
          // ----- add a confirm password fields match on the registration page
          function wc_register_form_password_repeat() {
              ?>
              <p class="form-row form-row-wide">
                  <label for="reg_password2"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                  <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
              </p>
              <?php
          }
          add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
          
          // ----- Validate confirm password field match to the checkout page
          function lit_woocommerce_confirm_password_validation( $posted ) {
              $checkout = WC()->checkout;
              if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
                  if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
                      wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' ); 
                  }
              }
          }
          add_action( 'woocommerce_after_checkout_validation', 'lit_woocommerce_confirm_password_validation', 10, 2 );
          
          // ----- Add a confirm password field to the checkout page
          function lit_woocommerce_confirm_password_checkout( $checkout ) {
              if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {
          
                  $fields = $checkout->get_checkout_fields();
          
                  $fields['account']['account_confirm_password'] = array(
                      'type'              => 'password',
                      'label'             => __( 'Confirm password', 'woocommerce' ),
                      'required'          => true,
                      'placeholder'       => _x( 'Confirm Password', 'placeholder', 'woocommerce' )
                  );
          
                  $checkout->__set( 'checkout_fields', $fields );
              }
          }
          add_action( 'woocommerce_checkout_init', 'lit_woocommerce_confirm_password_checkout', 10, 1 );
          
          add_action('woocommerce_before_customer_login_form','load_registration_form', 2);
          function load_registration_form(){
              if(isset($_GET['action'])=='register'){
                  woocommerce_get_template( 'myaccount/form-registration.php' );
              }
          }
          
          
           //add additional feilds on regeistration form
          // add feilds 
          function wooc_extra_register_fields() {?>
          
              <p class="form-row form-row-first">
              <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
              <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
              </p>
              <p class="form-row form-row-last">
              <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
              <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
              </p>
              <div class="clear"></div>
              <?php
          }
          add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
          
          
          // validate feilds
          /**
          * register fields Validating.
          */
          function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
              if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
                     $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
              }
              if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
                     $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
              }
                 return $validation_errors;
          }
          add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
          
          // add to data base
          
          
          /**
          * Below code save extra fields.
          */
          function wooc_save_extra_register_fields( $customer_id ) {
              if ( isset( $_POST['billing_phone'] ) ) {
                           // Phone input filed which is used in WooCommerce
                           update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
                    }
                if ( isset( $_POST['billing_first_name'] ) ) {
                       //First name field which is by default
                       update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
                       // First name field which is used in WooCommerce
                       update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
                }
                if ( isset( $_POST['billing_last_name'] ) ) {
                       // Last name field which is by default
                       update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
                       // Last name field which is used in WooCommerce
                       update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
                }
          
          }
          add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
          
          
          