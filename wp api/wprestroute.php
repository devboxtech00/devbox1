<?php
//API of User Login
function wl_user_login($data) {
    $email = $data['email'];
    $username = $data['username'];
    $pass = $data['pass'];
    try {                   
        
        if (isset($data['email'])) {
          if(empty($data['email'])) {
            $data = [
                'status_code' => 400,
                'message'     => 'Please provide email address',
                'data'        => [],
               ];
              }
        
        else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data = [
                'status_code' => 400,
                'message'     => 'Please provide proper email address',
                'data'        => [],
               ];
        }
    }
     
       if (isset($data['username'])) {
          if(empty($data['username'])) {
            $data = [
                'status_code' => 400,
                'message'     => 'Please provide a username',
                'data'        => [],
              ];
              }
        }
      if (!isset($data['pass']) || empty($data['pass'])) {
            $data = [
                'status_code' => 400,
                'message'     => 'Please provide password',
                'data'        => [],
               ];
        }
    else{
		
$userdata = get_user_by('email', $email);
$userdata2 = get_user_by('login', $username);
		
if(!empty($userdata)) {

$result = wp_check_password($pass, $userdata->user_pass, $userdata->ID);
          if($result!=''){
          $user_login = $data['email']; 
          $user = get_user_by('email', $user_login);
          $user_id = $user->ID; 
          wp_set_current_user( $user_id, $user->user_login );
          wp_set_auth_cookie( $user_id );
          do_action( 'wp_login', $user->user_login, $user);
          $current_user = wp_get_current_user();  

          
            $userDetails = [
            'user_id'        => $current_user->ID,       
            'user_name' => $current_user->user_login,
            'user_email' => $current_user->user_email,
            'user_firstname' => $current_user->user_firstname,
            'user_lastname' => $current_user->user_lastname,
            'user_phone_prefix' => get_user_meta($current_user->ID,'phone_no_prefix',true),
            'user_phone' => get_user_meta($current_user->ID,'user_phone',true),
            'display_name' => $current_user->display_name,
            'login_through' => 'email'
            ];
            
            $data = [
            'status_code' => 200,
            'message'     => 'Logged in successfully', 
            'data'        => [$userDetails]
            ];

          }else{
              
        $data = [
            'status_code' => 400,
            'message'     => 'Please, check your login credentials',
            'data'        => []
            ];  
          }
            
      } 
		
	else if(!empty($userdata2)) {

$result = wp_check_password($pass, $userdata2->user_pass, $userdata2->ID);
          if($result!=''){
          $user_login = $data['username']; 
          $user = get_user_by('login', $user_login);
          $user_id = $user->ID; 
          wp_set_current_user( $user_id, $user->user_login );
          wp_set_auth_cookie( $user_id );
          do_action( 'wp_login', $user->user_login, $user);
          $current_user = wp_get_current_user(); 
			  
         
            $userDetails = [
            'user_id'        => $current_user->ID,       
            'user_name' => $current_user->user_login,
            'user_email' => $current_user->user_email,
            'user_firstname' => $current_user->user_firstname,
            'user_lastname' => $current_user->user_lastname,
            'user_phone_prefix' => get_user_meta($current_user->ID,'phone_no_prefix',true),
            'user_phone' => get_user_meta($current_user->ID,'user_phone',true),
            'display_name' => $current_user->display_name,
            'login_through' => 'username'
            ];
            
            $data = [
            'status_code' => 200,
            'message'     => 'Logged in successfully',  
            'data'        => [$userDetails]
            ];

          }else{
              
        $data = [
            'status_code' => 400,
            'message'     => 'Please, check your login credentials',
            'data'        => []
            ];  
          }
            
      }
   else {

 $data = [
            'status_code' => 400,
            'message'     => 'Please, check your login credentials',
            'data'        => []
            ];  

  }
  
   }     
        
    //$post_data = json_encode(array('data' => $data));
    $post_data = json_encode($data);
    return json_decode($post_data);
    
    } catch (Exeption $e) {
        //return json_encode($e);
        
        $post_data = json_encode(array('data' => $e));
        return json_decode($post_data);
    }


    //return json_encode($data);
    
    $post_data = json_encode(array('data' => $data));
    return json_decode($post_data);
}


add_action('rest_api_init', function() {

    register_rest_route('fcrauth/v1', 'user_login', [
        'methods' => 'POST',
        'callback' => 'wl_user_login',
    ]);

 });

// filter Api

add_action('rest_api_init', function() {

    register_rest_route('customapi/v1', 'filter_business/page/(?P<no>\d+)/', [
    'methods' => 'GET',
    'callback' => 'filter_business_cb',
    ]);
    
    });
    
  function filter_business_cb($data) {
    $allbuisnes = [];
    $businessType ="";
    $businessBadges =  "";
    $accreditedBusiness = "";
    $businessType = $_GET['businessType'] ? $_GET['businessType'] : "";
    $businessBadges = $_GET['businessBadges'] ? $_GET['businessBadges'] : "";
    $accreditedBusiness = $_GET['accreditedBusiness'] ? $_GET['accreditedBusiness'] : "";
    $mypage = $data['no'] ? $data['no'] : "1";

    $tax_query = array( 'relation' => 'AND' );
    $meta_query = array( 'relation' => 'AND' );

        //Business Badges
    if (isset($_GET['businessBadges']) && $businessBadges!=""){
      $tax_query[] = array(
      'taxonomy' => 'badges',
      'field'    => 'slug',
      'terms'    => explode(',', $businessBadges),
      );
    }

       //Business Types
    if (isset($_GET['businessType']) && $businessType!=""){
      $tax_query[] = array(
      'taxonomy' => 'business_types',
      'field'    => 'slug',
      'terms'    => explode(',', $businessType),
      );
    }
       //Business Types
       if (isset($_GET['accreditedBusiness']) && $accreditedBusiness!=""){
        $tax_query[] = array(
        'taxonomy' => 'accreditedbusiness',
        'field'    => 'slug',
        'terms'    => explode(',', $accreditedBusiness),
        );
      }
    // if (isset($_GET['accreditedBusiness']) && $accreditedBusiness!="") {
    //   $meta_query[] = array(
    //   'key' => 'accredited_business',
    //   'value' => $accreditedBusiness,
    //   'compare' => '='
    //   );}
      $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
      $business_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 10,
        'paged'         => $mypage,
        'order'          => 'post_id',
        'tax_query'      =>$tax_query,    
        // 'meta_query'     =>$meta_query,
        ]);
    
        while ($business_query->have_posts()) : $business_query->the_post();
          $buisnes['business_id'] = get_the_ID();
          $buisnes['business_title'] =get_the_title();
          $buisnes['business_url'] = get_the_permalink();
          $buisnes['business_address'] = get_field('address_busines');  
          $buisnes['business_descriptions'] = get_field('descriptions_biz');
          $buisnes['fcr_score'] = get_field('fair_commerce_reports_score_biz');
          $buisnes['img_url'] = get_the_post_thumbnail_url();
          $buisnes['rating_biz'] =(int)get_field('rating_biz'); 
          $buisnes['ia'] = get_field('accredited_business');
          $buisnes['badges'] = [];
          $getBages = get_the_terms(get_the_ID(), 'badges');
          if($getBages){
            foreach($getBages as $bages){
              array_push( $buisnes['badges'], $bages->name);
            }
          }
          array_push($allbuisnes, $buisnes);
      endwhile;

 
      $big = 999999999; // need an unlikely integer
      $pagination = paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url(get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
                      'type' => 'list', 
          'current' => max( 1, $mypage ),
          'total' =>  $business_query->max_num_pages
      ) );
     
      $post_data = array('data' => $allbuisnes, 'paged'=> $pagination);
      return $post_data;   
        

    //    $finalArr=[];
    //    $itemsPerPage = 10;
    //    // Calculate the total number of items in the array
    //    $totalItems = 0;
    //    foreach ($allbuisnes as $value) {
    //        $totalItems += 1;
    //    }

    //    // Calculate the total number of pages
    //    $totalPages = ceil($totalItems / $itemsPerPage);
    //    // Get the current page number from the query string
    //    if (isset($_GET['cpage'])) {
    //        $currentPage = $_GET['cpage'];
    //    } else {
    //        $currentPage = 1;
    //    }
    //    // Calculate the starting index and ending index of the items to display on the current page
    //    $startIndex = ($currentPage - 1) * $itemsPerPage;
    //    $endIndex = $startIndex + $itemsPerPage - 1;
       
    //    // Loop through the associative array
    //    $itemsDisplayed = 0;



       
    //     // If the current key's items haven't been fully displayed yet
    //      if ($startIndex < $itemsDisplayed + count($allbuisnes)) {
    //          // Calculate the starting and ending indices of the items to display for this key
    //          $start = max($startIndex - $itemsDisplayed, 0);
    //          $end = min($endIndex - $itemsDisplayed, count($allbuisnes) - 1);
    //          // Get the items to display for this key
    //          $items = array_slice($allbuisnes, $start, $end - $start + 1);
                 
    //              $finalArr = $items;
                        
    //          // Increase the number of items displayed so far
    //          $itemsDisplayed += count($allbuisnes);
     
    //          // If we've displayed all the items for the current page, break out of the loop
           
    //      } else {
    //          // If the current key's items have already been fully displayed, skip to the next key
    //          $itemsDisplayed += count($allbuisnes);;
    //      }
       
     
     


    //  $post_data = json_encode(array( 'total'=>$totalItems , 'totalpage'=>$totalPages, 'data' => $finalArr, 'currentPage'=>$_GET['cpage']?$_GET['cpage']:1));
    //  //$post_data = json_encode($data_array_list);
    //  return json_decode( $post_data );   
}

$first_day_month = date('Y/m/d',strtotime('first day of '.$month.' '.$year_slug));
$last_day_month  = date('Y/m/d',strtotime('last day of '.$month.' '.$year_slug));

$args=array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'orderby'   => 'meta_value_num',
    'order' => 'ASC',
    'tax_query' =>  $tax_query,
    'meta_query' => array( 
      'relation' => 'AND',
      array(
        'key'     => 'repetwerrow_$_repeterfeild',
        'value' => array($first_day_month, $last_day_month),
        'compare' => 'BETWEEN',
        'type' => 'DATE'
      ),
      $search_meta
    ),
  );
  if($customsorting == "title") {
    $args['orderby']='title';
    $args['order']='ASC';
    unset($args['meta_key']);
  }
  if($loop->have_posts()) : while ($loop->have_posts() ) : $loop->the_post(); 

endwhile; 
endif; 

wp_reset_query(); 
 // menue

 /** new functions **/ 
//custom fuction get wp menue with department menu API
function wp_get_menu_array($current_menu,$menu_id) {
    $get_menu = wp_get_nav_menu_items($current_menu);
    $menu = [];
    $l1_menu =[];
    $l2_menu =[];
        foreach ($get_menu as $m) {
            if (empty($m->menu_item_parent)) {
                // $menu[$m->ID]['ID']      =   $m->ID;
                $menu[$m->ID]['title']       =   $m->title;
                $menu[$m->ID]['url']         =   $m->url;
                $menu[$m->ID]['child_items']    =   [];

                $get_sub_menue = wp_get_nav_menu_items($menu_id,array(
                    'posts_per_page' => -1,
                    'meta_key' => '_menu_item_menu_item_parent',
                    'meta_value' => $m->ID // the currently displayed post
                    ));
                    
                    foreach ($get_sub_menue as $m2) {
                        // $l1_menu[$m2->ID]['ID']          =   $m2->ID;
                        $l1_menu[$m2->ID]['title']       =   $m2->title;
                        $l1_menu[$m2->ID] ['url']         =   $m2->url;
                        $l1_menu[$m2->ID]['child_items']    =   [];

                        if(!empty($m2->classes["2"]) && $m2->classes["2"] == "api_menu"){
                            $spl_menue = fetch_deparments_menu();
                            array_push($l1_menu[$m2->ID]['child_items'] , $spl_menue);


                        } else{

                        $get_sub_menue_l2 = wp_get_nav_menu_items($menu_id,array(
                            'posts_per_page' => -1,
                            'meta_key' => '_menu_item_menu_item_parent',
                            'meta_value' => $m2->ID // the currently displayed post
                        ));


                        foreach ($get_sub_menue_l2 as $m3) {
                            // $l2_menu[$m3->ID]['ID']          =   $m3->ID;
                            $l2_menu[$m3->ID]['title']       =   $m3->title;
                            $l2_menu[$m3->ID] ['url']         =   $m3->url;
                            array_push($l1_menu[$m2->ID]['child_items'] , $l2_menu[$m3->ID]); 
                    }
                
            }
                    array_push($menu[$m->ID]['child_items'] , $l1_menu[$m2->ID]);
                
            }

        }	 

}
		return $menu;
	}

    //callback fuction wp megamenu restroute

function wp_menu_megamenu($data){
	$locations = get_nav_menu_locations();
    $menu_id = $data['id'];
    $menuObject = wp_get_nav_menu_object($menu_id);
    $current_menu = $menuObject->slug;
    $array_menu = wp_get_nav_menu_items($current_menu);

    try {
    
    $post_data = json_encode(array('menu' => wp_get_menu_array($current_menu,$menu_id)));
        //$post_data = json_encode($data_array_list);
        return json_decode($post_data);   
    } 

    catch (Exeption $e) {
		//return json_encode($e);
		$post_data = json_encode(array('data' => $e));
		return json_decode($post_data);
		}	
	}
	register_rest_route( 'menus/v1', 'megamenu/(?P<id>[a-zA-Z0-9_-]+)', array(
		'methods'  => 'GET',
		'callback' => 'wp_menu_megamenu',
		'permission_callback' => '__return_true'
	) );
