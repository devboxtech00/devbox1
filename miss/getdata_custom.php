
<?php 
@session_start();
	error_reporting(0);


  $conn = mysqli_connect("localhost","user","psw!","db");
  $conn->set_charset("utf8mb4");

	// Check connection
	if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
	}
	
	// define('TABLEPREFIX','user_system');
	

get_header();
?>



<div class="container const_sec">
<div class="userGrid">
<div id="user_row" class="row  justify-content-center">
<?php 
$sql_get_site_url = "SELECT * FROM `wp_options` WHERE `option_name` = 'siteurl'  ";
$query_get_site_url = mysqli_query( $conn, $sql_get_site_url);
$siteurl_fetch = mysqli_fetch_array($query_get_site_url);
$siteurl= $siteurl_fetch['option_value'];

function getDomainName($url){
  $url = trim($url, '/');
  if (!preg_match('#^http(s)?://#',$url)) {
     $url = 'http://' . $url;
  }
  $urlParts = parse_url($url);
  $domain_name = preg_replace('/^www\./', '', $urlParts['host']);
  return $domain_name;
  }

 
$sql = "SELECT * FROM `wp_usermeta` WHERE `meta_key` = 'wp_capabilities' AND `meta_value` LIKE '%UserType%' ORDER BY `meta_key` ASC ";
$query = mysqli_query( $conn, $sql);


if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_array($query)){

    // getname 
   $sql_name = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'first_name'";
   $query_name = mysqli_query( $conn, $sql_name); 
   $user_First_Name = mysqli_fetch_array($query_name);
    $first_name =  $user_First_Name['meta_value'];

    // get  is chat user
    $sql_ischat = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'user_widget'";
    $query_ischat = mysqli_query( $conn, $sql_ischat); 
    $user_Is_Chat = mysqli_fetch_array($query_ischat);
    $isChatuser = $user_Is_Chat['meta_value'];

   // get is online
   $sql_isonline = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'user_status'";
   $query_isonline = mysqli_query( $conn, $sql_isonline); 
   $user_Is_online = mysqli_fetch_array($query_isonline);
   $get_current_value = $user_Is_online['meta_value'];

   // telephone user avability
   $sql_tel_avibility = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'user_avibility'";
   $query_tel_avibility = mysqli_query( $conn, $sql_tel_avibility); 
   $user_tel_avibility = mysqli_fetch_array($query_tel_avibility);
   $isAvaliable =  $user_tel_avibility['meta_value'];
   
  // get short descriptions 
   $sql_short_descriptions = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'short_descriptions_user'";
   $query_short_descriptions = mysqli_query( $conn, $sql_short_descriptions); 
   $user_short_descriptions = mysqli_fetch_array($query_short_descriptions);
   $short_descriptions = $user_short_descriptions['meta_value'];
   
   // get user ph number 
   $sql_user_phnumber = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'phone_number_user'";
   $query_user_phnumber = mysqli_query( $conn, $sql_user_phnumber); 
   $user_user_phnumber = mysqli_fetch_array($query_user_phnumber);
   $user_phnumber = $user_user_phnumber['meta_value'];
   $userPhLink = preg_replace('/[^\dxX]/', '', $user_user_phnumber);


    // is a dummy user
    $sql_is_a_dummy_user = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'is_a_dummy_user'";
    $query_is_a_dummy_user = mysqli_query( $conn, $sql_is_a_dummy_user); 
    $user_is_a_dummy_user = mysqli_fetch_array($query_is_a_dummy_user);
    $isDummyUser =  $user_is_a_dummy_user['meta_value'];

   // find attchment
   $sql_user_getimage_pid = "SELECT * FROM `wp_usermeta` WHERE `user_id` = ".$row['user_id']." AND `meta_key` = 'wp_metronet_image_id'";
   $query_user_getimage_pid = mysqli_query( $conn, $sql_user_getimage_pid); 
   $user_getimage_pid = mysqli_fetch_array($query_user_getimage_pid);
   $user_image_pid = $user_getimage_pid['meta_value'];

   $sql_user_getimage_path = "SELECT * FROM `wp_postmeta` WHERE `post_id` = ".$user_getimage_pid['meta_value']." AND `meta_key` = '_wp_attached_file'";
   $query_user_getimage_path = mysqli_query( $conn, $sql_user_getimage_path); 
   $user_getimage_path = mysqli_fetch_array($query_user_getimage_path);
   $user_img_url =$siteurl."wp-content/uploads/".$user_getimage_path['meta_value'];

   //crete user url
   $sql_user_login = "SELECT * FROM `wp_users` WHERE `ID` = ".$row['user_id']." ";
   $query_user_login = mysqli_query( $conn, $sql_user_login); 
   $user_user_login = mysqli_fetch_array($query_user_login);
   $user_slug = $user_user_login ["user_login"];
   $user_slug = strtolower($user_slug);
  //  $domain_name = getDomainName($siteurl);
  //  $user_permalink =  "https://".$domain_name."/author/".$user_slug;

  $user_permalink = $siteurl."author/".$user_slug;
// var_dump( $user_user_login);
}
}

//  views
?>

         



<script>
    jQuery(document).ready(function ($) {
      
        
        $(".red_chat").prependTo('#user_row');
        $(".red").prependTo('#user_row');
        // $('.yelw_chat').prependTo('#user_row');
        $('.green_chat').prependTo('#user_row');
        $('.green').prependTo('#user_row');
        console.log("hello");

    });
</script>

