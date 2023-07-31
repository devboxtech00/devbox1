<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/consultation/wp-content/themes/hello-elementor-child/functions.php');


//echo ($_SERVER['DOCUMENT_ROOT']);
  
// add_action('template_redirect', 'my_check_login');

// function my_check_login(){
   
// }

// global $wpdb;

// var_dump($_POST);
$getInputData = file_get_contents("php://input");
$makeLoginData = explode(",",$getInputData);

$rememberMe = 'false';
$userName = $makeLoginData[0];
$userPassword = $makeLoginData[1];
$did = $makeLoginData[2];



// echo $userName.$userPassword.$did;
// // var_dump();
// exit;
// $getrememberMe = $_POST['rememberMe'];
// if(!empty($_POST['rememberMe']) && $_POST['rememberMe'] !='' ){
//     $rememberMe = $_POST['rememberMe']; 
// }

// echo $userName . " </br>";
// echo $userPassword . " </br>";
// echo $rememberMe . " </br>";



$coder_login_user_data = get_user_by( 'login', $userName );

    if(!empty($coder_login_user_data)){
        $coder_login_user_id = $coder_login_user_data->ID;

        $result = wp_check_password($userPassword, $coder_login_user_data->user_pass, $coder_login_user_id->ID);

        if($result!=''){

            $coder_first_time_login = get_user_meta( $coder_login_user_id, 'coder_first_time_login', 'true' );
            $coder_last_active_time = get_user_meta( $coder_login_user_id, 'coder_last_active_time', 'true' );
            $coder_is_logout = get_user_meta( $coder_login_user_id, 'coder_is_logout', 'true' );
            $coder_current_time = current_time( 'timestamp');
    
            
            // $userDetails = [
            //     'user_id'   => $coder_login_user_data->ID,       
            //     'user_name' => $coder_login_user_data->user_login,
            //     'user_email' => $coder_login_user_data->user_email,
            //     'user_firstname' => $coder_login_user_data->user_firstname,
            //     'user_lastname' => $coder_login_user_data->user_lastname,
            //     'display_name' => $coder_login_user_data->display_name,
            //     'islogout' =>  $coder_is_logout,
            //     'deviceId' => $did
        
            //     ];
                $creds = array(
                    'user_login'    => $userName,
                    'user_password' => $pass,
                    'remember'      => $rememberMe
                    );
            

                if($coder_is_logout == "yes"){
                    update_user_meta( $coder_login_user_id, 'coder_first_time_login', 'no' );
                    update_user_meta( $coder_login_user_id, 'coder_is_logout', 'no' );
                    update_user_meta( $coder_login_user_id, 'coder_last_active_time', $coder_current_time );
                    setcookie("outgoingid", $coder_login_user_id, 0, "/");
                        wp_signon( $creds, false );
                        wp_set_auth_cookie($coder_login_user_id, false);
                        update_user_meta($coder_login_user_id, 'user_device_id', $did);
                        update_user_meta($coder_login_user_id, 'user_status', "online");
                        
        
                        echo "200"; 


                 } else{
                    echo "400"; 

                 }
                   
                
            

            } else {
            echo "401"; 
          }
         } else {
          echo "401"; 
       }


// insert data

require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once(PURPLEREADING_CONSULTATIONS_PATH .'inc/config.php');

global $wpdb; 

 
//   $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

//   $message = mysqli_real_escape_string($conn, $_POST['message']);

$msg = $_POST['text'];
$incomingid = $_POST['incomingID'];
$outgoingID = $_POST['outgoingID'];
$cstatus = $_POST['cstatus'];
$imgurl ="nodata" ;
if(!empty($_POST['imgurl'])) {
 $imgurl = $_POST['imgurl'];
 } 

 

//  $sql = "INSERT INTO wp_consultationmessage (incomingid, outgoingid, messages, consultationstatus, imageurl)
//   VALUES ('$incomingid', '$outgoingID', '$msg', '$cstatus', '$imgurl')";
//  $query = mysqli_query( $conn, $sql);
// if ($conn->query($sql) === TRUE) {
//   } else {
//   }

$tablename=$wpdb->prefix.'mymessages';



$data=array(

'applicationtime' => date('Y-m-d H:i:s'),
'outgoingid' => $outgoingID,
'incomingid' => $incomingid,
'messages' => $msg,
'userstatus' => $cstatus,
'imageurl' =>$imgurl,
);

$wpdb->insert( $tablename, $data);


// get data

require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once(PURPLEREADING_CONSULTATIONS_PATH .'/inc/config.php');


// $user_id =   $_COOKIE['myid'];
// $outgoingoid = "";
// $output ="";
// $messgae ="";
// $status="";
        $outgoing_id =  $_COOKIE['outgoingid'];
        $incoming_id =  $_COOKIE['incomingid'];
        $output = "";
        $sql = "SELECT * FROM wp_consultationmessage  WHERE (outgoingid = {$outgoing_id} AND incomingid = {$incoming_id} AND consultationstatus = 'onchat')
                OR (outgoingid = {$incoming_id} AND incomingid = {$outgoing_id} AND consultationstatus = 'onchat') ORDER BY applicationtime";

        $query = mysqli_query( $conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoingid'] === $outgoing_id){
                    if( $row['imageurl'] != "nodata"){
                         $output .= '<div class="chat outgoing">
                                    <div class="details">
                                    <img src="'. $row['imageurl']. '" alt="chat_image" class="img_outgoing">
                                    </div>
                                    </div>';
                                    } else {

                        $output .= '<div class="chat outgoing">
                                <div class="details">
                                <p>'. $row['messages'] .'</p>
                                </div>
                                </div>';
                                }

                                }  else if($row['outgoingid'] === $incoming_id)  {
                                    if($row['imageurl'] != "nodata"){
                                        $output .= '<div class="chat incoming">
                                                    <div class="details">
                                                        <img src="'. $row['imageurl']. '" alt="chat_image" class="img_incomming">
                                                    </div>
                                                    </div>';
                                         } else{

                                            $output .= '<div class="chat incoming">
                                                            <div class="details">
                                                                <p>'. $row['messages'] .'</p>
                                                            </div>
                                                            </div>';

                                       }

                                }

                            }

        }else{

            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';

        }

        echo $output;

?>
