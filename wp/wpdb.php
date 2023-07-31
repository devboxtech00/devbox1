<?php

function create_tabale(){

	global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'mytable';
		
				$sql = "CREATE TABLE $table_name (
				id bigint(255) NOT NULL AUTO_INCREMENT,
                entrytime datetime NOT NULL,
				userid bigint(255) NOT NULL,
				object_id bigint(255) NOT NULL,
				itemno int(255) NOT NULL,
				statuas tinyint(1) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

	}
    add_action( 'init', 'create_tabale');


    global $wpdb;

	$tablename = $wpdb->prefix.'mytable';
	$data=array(
	'entrytime' => date('Y-m-d H:i:s'),
	'userid' => $authorID,
	'object_id' =>$list_id,
	'itemno' => $item_no,
	'timmer_start_time' => date('Y-m-d H:i:s'),
	'timmer_end_time' =>  $enddate,
	'target_type' => $targettype,
	'mailstatus' => 0,
	'timmer_type' => $timertype,
	'statuas' => 0
	);
	
	$wpdb->insert( $tablename, $data);

    global $wpdb;
	$userId = $_POST['userid'];
	
	$table_name =$wpdb->prefix.'mytable';
	$data_array = array('statuas' => '1');
	$data_where = array('userid' => $userId,
						'statuas' => '0');
  
	 $wpdb->update( $table_name, $data_array, $data_where );


global $wpdb;
	$db_id = $_POST['db_id'];
     $wpdb->query( "DELETE FROM mytable WHERE id = '$db_id'" );


    $target_id = $_POST['myid'];
     $wpdb->delete( $wpdb->prefix . 'mytable',['id' => $target_id],['%d']);

global $wpdb;
$data =$wpdb->get_results("SELECT * FROM mytable WHERE userid = '$authorID' ORDER BY entrytime DESC"); 

foreach ( $data as $print ) {
    $date = $print->date_modified;
    $oderid = $print->_object_id;
    $ammount = $print->amount_total;
    $curency = $print->currency;
    $email = $print->email;
    $customerid = $print->customer_id;
    $uuid = $print->uuid;
    $status = $print->status;
?> 

   <tr>
      <td scope="row"><?php echo $a; ?></td>
      <td><?php  echo $date;  ?></td>
      <td><?php echo  $oderid ; ?></td> 
      <td><?php echo  $curency." ".$ammount ; ?></td> 
      <td><?php echo  $email ; ?></td> 
      <td><?php echo  $customerid ; ?></td> 
      <td><?php echo  $uuid ; ?></td> 
      <td><?php echo  $status ; ?></td> 
     

   

        <?php  $a++; } 


global $wpdb;
$data =$wpdb->get_var("SELECT post_id FROM mytable WHERE userid = '$authorID' ORDER BY entrytime DESC"); 


//with pagination

			$i = 1;
			$items_per_page = 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$tablename=$wpdb->prefix.'mytable';
			$query = 'SELECT * FROM '.$tablename;
		
			// $loginHistory = $wpdb->get_results ( "SELECT * FROM $tablename  ORDER BY 'user_logintime' ASC" );
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );

			$loginHistory = $wpdb->get_results( $query.' ORDER BY user_logintime DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			// var_dump(array_reverse($loginHistory));
			foreach ( $loginHistory as $data ) {

				$user_id = $data->userid;
				$user_login = $data->userlogin;
				$logintime = $data->user_logintime;
				$usrmachineIP = $data->ipaddress;
				$browser =  $data->browser;
				$city =  $data->city;
				$region  =  $data->region;
				$country  =  $data->country;
				$continent  =  $data->continent;
            }



     
            echo paginate_links( array(
                                'base' => add_query_arg( 'cpage', '%#%' ),
                                'format' => '/page/%#%',
                                'prev_text' => __('&laquo;'),
                                'next_text' => __('&raquo;'),
                                'type' => 'list', 
                                'total' => ceil($total / $items_per_page),
                                'current' => $page
                            ));
        
                            ?>     


<!-- // custom wp db query -->
<?php
$sqlQ  = "SELECT 
posts.ID, 
posts.post_title,  
posts_meta_1.meta_value as m1,
posts_meta_2.meta_value as m2,
posts_meta_3.meta_value as m3,
posts_meta_4.meta_value as m4


FROM wp_posts AS posts
LEFT JOIN wp_postmeta AS posts_meta_1 ON posts_meta_1.post_id = posts.ID 
LEFT JOIN wp_postmeta AS posts_meta_2 ON posts_meta_2.post_id = posts.ID 
LEFT JOIN wp_postmeta AS posts_meta_3 ON posts_meta_3.post_id = posts.ID 
LEFT JOIN wp_postmeta AS posts_meta_4 ON posts_meta_4.post_id = posts.ID 



WHERE posts_meta_1.meta_key LIKE 'metakeyrow_%_metakeyfeild1'
AND posts_meta_2.meta_key LIKE 'metakeyrow_%_metakeyfeild2'
AND posts_meta_3.meta_key LIKE 'metakeyrow_%_metakeyfeild3'
AND posts_meta_4.meta_key LIKE 'metakeyrow_%_metakeyfeild4'



AND posts.post_type = 'post' 
AND posts_meta_1.meta_value >= '$currentdate_DB'  
AND posts.post_status = 'publish'

GROUP BY posts_meta_1.meta_value
ORDER BY posts_meta_1.meta_value ASC
LIMIT 10
";




//$TestiSql="select * from ".TABLEPREFIX."_customer where customer_id='".$customer_id."' ";
$TestiSqlQuery=mysqli_query($conn, $sqlQ) or mysqli_error($conn);
//$TestiFetch=mysqli_fetch_array($TestiSqlQuery, $conn);

if (!$TestiSqlQuery) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}else{
   while($TestiFetch = mysqli_fetch_array($TestiSqlQuery)){
    // your code here
   }
}

echo "<pre>";print_r($TestiFetch);