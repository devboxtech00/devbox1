<?php
$subject =  $br_title;
    $to = $email;
    $replyadmin = get_option( "admin_email" ); 
    $from = get_option( "admin_email" ); 

    $replyadmin = get_option( "admin_email" ); 
    $subjet_admin = $br_title. " Of <".$email.">";

    $mail_attachment = array(WP_CONTENT_DIR ."/". $file_path );   

    $headers[] = "From: mysite  <" . trim($from) . ">";
    $headers[] = "Reply-To: <" . trim($from) . ">";
    $headers[] = "Content-Type: text/html; charset=UTF-8";
    $html_body = "<h2>heloo</h2>";

    wp_mail($to, $subject, $html_body, $headers);




    //php 

$fname = $_POST['first_name'];
  $lname = $_POST['last_name'];
  $subject = $_POST['subject']; 
  $message_text = $_POST['message'];

 $mailto = "s@gmail.com";  //My email address
 //getting customer data
//  $name = $_POST['email_from_name'];
//  $phone = $_POST['email_from_number']; 
//  $email = $_POST['email_from_email'];

 $fromEmail = "s@gmail.com";
 //Email body I will receive
 $message = "Name: " . $fname." ".$lname. "\n"
 . "Client Message: " .$message_text. "\n";
 $headers = "From: " . $fromEmail; // Client email, I will receive
 $result1 = mail($mailto, $subject, $message, $headers); // This email sent to My address
  //Checking if Mails sent successfully
  if ($result1) {
    echo "200";
  } else {
   echo "403";
  }