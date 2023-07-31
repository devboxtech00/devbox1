

<?php



$user_id = get_current_user_id();
$user_info = get_userdata($user_id);
  	
    $postTitle = $_POST['postTitle'];	
    $meta1 = $_POST['meta1'];	
    $meta12 = $_POST['meta12'];	
    $meta14 = $_POST['meta14'];	
    $meta16 = $_POST['meta16'];	
    $company_logo = $_FILES['company_logo'];
    $image_gallery = $_FILES['image_gallery'];
    $thumbnail = $_POST['thumbnail'];
   

    $post_type = 'postdata';	
    $front_post = array(  
    'post_type'     => $post_type, 
    'post_title'    => $postTitle,  
    'post_status'   => 'publish',     
    'post_author'   => $user_id,       
      
       );      
    $post_id = wp_insert_post($front_post);	
        if ($post_id) {

            wp_set_object_terms( $post_id, $meta1, 'type' );

        	update_post_meta($post_id, 'meta1', $meta1);
            update_post_meta($post_id, 'meta12', $meta12); 
            update_post_meta($post_id, 'meta14', $meta14);
            update_post_meta($post_id, 'meta16', $meta16); 
            //update_post_meta($post_id, 'company_logo', $company_logo);
       
            //update_post_meta($post_id, 'image_gallery', $image_gallery);
            update_post_meta($post_id, 'thumbnail', $thumbnail);            
            if(!empty($_FILES['thumbnail']['name'])){
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            $attachment_id = media_handle_upload( 'thumbnail', $thumbnail );
            set_post_thumbnail( $post_id, $attachment_id );
            }
			// WordPress environmet
require( dirname(__FILE__) . '/../../../wp-load.php' );

// it allows us to use wp_handle_upload() function
require_once( ABSPATH . 'wp-admin/includes/file.php' );

// you can add some kind of validation here
if( empty( $_FILES[ 'company_logo' ] ) ) {
	wp_die( 'No files selected.' );
}

$upload = wp_handle_upload( 
	$_FILES[ 'company_logo' ], 
	array( 'test_form' => false ) 
);

if( ! empty( $upload[ 'error' ] ) ) {
	wp_die( $upload[ 'error' ] );
}

// it is time to add our uploaded image into WordPress media library
$attachment_id = wp_insert_attachment(
	array(
		'guid'           => $upload[ 'url' ],
		'post_mime_type' => $upload[ 'type' ],
		'post_title'     => basename( $upload[ 'file' ] ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	),
	$upload[ 'file' ]
);
if (is_numeric($attachment_id)) {
     update_option('option_image', $attachment_id);
    update_post_meta($post_id, 'company_logo', $attachment_id);
	//update_post_meta($post_id, 'company_logo', $company_logo);
 }
if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
	wp_die( 'Upload error.' );
}

// update medatata, regenerate image sizes
require_once( ABSPATH . 'wp-admin/includes/image.php' );

wp_update_attachment_metadata(
	$attachment_id,
	wp_generate_attachment_metadata( $attachment_id, $upload[ 'file' ] )
);

if (!empty($_FILES['image_gallery']['name'][0])) {

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );


        $files = $_FILES['image_gallery'];
        $count = 0;
        $galleryImages = array();


        foreach ($files['name'] as $count => $value) {

            if ($files['name'][$count]) {

                $file = array(
                    'name'     => $files['name'][$count],
                    'type'     => $files['type'][$count],
                    'tmp_name' => $files['tmp_name'][$count],
                    'error'    => $files['error'][$count],
                    'size'     => $files['size'][$count]
                );

                $upload_overrides = array( 'test_form' => false );
                $upload = wp_handle_upload($file, $upload_overrides);


                // $filename should be the path to a file in the upload directory.
                $filename = $upload['file'];

                // The ID of the post this attachment is for.
                $parent_post_id = $post_id;

                // Check the type of tile. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype( basename( $filename ), null );

                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();

                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                array_push($galleryImages, $attach_id);

            }

            $count++;

            // add images to the gallery field
            update_field('image_gallery', $galleryImages, $post_id);

        }



    }






    } else {
        echo "error";
    }






    
   
?> 