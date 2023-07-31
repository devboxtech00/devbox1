<?php

/**

 * Checkout Form

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce\Templates

 * @version 3.5.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



//do_action( 'woocommerce_before_checkout_form', $checkout );



// If checkout registration is disabled and not logged in, the user cannot checkout.

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {

	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

	return;

}

// get thea data

        $reg_no =   $_COOKIE['regNo'];
        $plate_qty =   $_COOKIE['plateQty'];
		$vehicletype =  $_COOKIE['vehicleType'];
		$FrontSize =   $_COOKIE['frontSize'];
		$rearsize =  $_COOKIE['rearSize'];
		$templateborder =  $_COOKIE['borderType'];
		$bordercolour =  $_COOKIE['borderColor'];
        $templatebadge =  $_COOKIE['badge'];
		$templatelegal =  $_COOKIE['legal'];
		$price =  $_COOKIE['final_price'];
?>



<div class="progress-wrapper">
    <div id="progress-bar-container">
        <ul>
            <li class="step step01 active">
                <div class="step-inner">Shipping Cart</div>
            </li>

            <li class="step step02">
                <div class="step-inner">Customer</div>
            </li>

            <li class="step step03">
                <div class="step-inner">Delivery</div>
            </li>

            <li class="step step04">
                <div class="step-inner">Payment</div>
            </li>
        </ul>

        <div id="line">
            <div id="line-progress"></div>
        </div>
    </div>
</div>



<div id="progress-content-section"> 
    <!-- product details -->
    <div id="step1" class="section-content step1 active">
            <section class="innerBack" style="background: url(<?php echo get_template_directory_uri() ?>/assets/images/innerBack.jpg) no-repeat; background-size: cover; background-position: center;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="progressBar"></div>
                        </div>
                        <div class="col-lg-12">
                            <div class="innerCartWrapper">
                                <div class="cardHeading">
                                    <h1><?php echo get_the_title( '20' );?></h1>
                                    <div class="actionbtnSec">
                                    </div>
                                </div>
                                <div class="cardDescrib">
                                    <div class="leftPanel">
                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Registration</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="reg_no"><?php echo $reg_no; ?></h3>
                                            </div>
                                        </div>
                                               <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $reg_no = '<?php echo $reg_no; ?>'
                                                    $("#liensenumber").attr("value", $reg_no);

                                                 });
                                               </script>
                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2 >Size Front:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="front"><?php echo $FrontSize; ?></h3>
                                            </div>
                                        </div>
                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $FrontSize = '<?php echo $FrontSize; ?>'
                                                    $("#sizefront").attr("value", $FrontSize);
                                                    $("#frontqty").attr("value" ,'1');

                                                 });
                                               </script>
                                                <?php } }?>
                                                <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Size Rear:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="back"><?php echo $rearsize; ?></h3>
                                            </div>
                                        </div>
                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $rearsize = '<?php echo $rearsize; ?>'
                                                    $("#sizerear").attr("value", $rearsize);
                                                    $("#backqty").attr("value", '1');

                                                 });

                                               </script>
                                        <?php }} else if($vehicletype == 'Motorcycle') {?>

                                            <div class="carDetails">
                                                    <div class="name">
                                                        <h2>Size Rear:</h2>
                                                    </div>
                                                    <div class="desc">
                                                        <h3 id="back"><?php echo $rearsize; ?></h3>
                                                    </div>
                                                    </div>
                                                    <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $rearsize = "<?php echo $rearsize; ?>"
                                                    $("#sizerear").attr("value", $rearsize);
                                                    $("#backqty").attr("value", '1');

                                                 });
                                                 
                                               </script>

                                        <?php } ?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Font:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>UK Legal</h3>
                                            </div>
                                        </div>
                                    
                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Legal Details:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="legal"><?php echo $templatelegal; ?></h3>
                                            </div>
                                        </div>

                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Front Plates:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>1</h3>
                                            </div>
                                        </div>

                                        <?php }} ?>
                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Rear Plates:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>1</h3>
                                            </div>
                                        </div>
                                        <?php }} else if($vehicletype == 'Motorcycle') {?>

                                            <div class="carDetails">
                                                <div class="name">
                                                    <h2>Rear Plates:</h2>
                                                </div>
                                                <div class="desc">
                                                    <h3>1</h3>
                                                </div>
                                                </div>

                                                 <?php } ?>
                                        <?php if($templateborder != 'No Border') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Border Type:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3><?php echo $templateborder; ?></h3>
                                            </div>
                                        </div>

                                        <div class="carDetails">
                                            <div class="name">
                                            <h2>Border Color:</h2>
                                            </div>
                                            <div class="desc">
                                            <h3><?php echo $bordercolour; ?></h3>
                                            </div>
                                        </div>
                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $templateborder = "<?php echo $templateborder; ?>"
                                                    $bordercolour = "<?php echo $bordercolour; ?>"
                                                    $("#bordertype").attr("value", $templateborder);
                                                    $("#bordercolor").attr("value", $bordercolour);

                                                 });
                                                 
                                               </script>
                                         <?php } ?>

                                        <?php if($templatebadge != 'No Badge') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Badge:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3><?php echo $templatebadge; ?></h3>
                                            </div>
                                        </div>

                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                  
                                                    $templatebadge = "<?php echo $templatebadge; ?>"
                                              
                                                    $("#badge").attr("value", $templatebadge);
                                                   

                                                 });
                                                 
                                               </script>

                                        <?php } ?>

                                    </div>

                                    <div class="rightPanel">
                                        <div class="finalTotalWrap">
                                            <div class="innerHeading">
                                                <h2>total</h2>
                                            </div>
                                            <div class="totalInnerWrap">
                                                <div class="subTotal">
                                                    <div class="name">
                                                        <h2>Total</h2>
                                                    </div>
                                                    <div class="desc">
                                                        <h3>£<?php echo $price; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="productView">
                                <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                    <div id="plateOne" class="plateOne">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/b-1.png" alt="">
                                    </div>

                                             <script>
                                                 jQuery(document).ready(function ($) {
                                                    $fimg =  sessionStorage.getItem('front_img');
                                                    $("#frntimg").attr("value", $fimg);
                                                 });
                                               </script>

                                      <?php }} ?>

                                      <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                            <div id="plateTwo" class="plateTwo">
                                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/b--2.png" alt="">
                                            </div>
                                            
                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                    $fimg =  sessionStorage.getItem('back_img');
                                                    $("#backimg").attr("value", $fimg);
                                                 });
                                               </script>

                                    <?php }} else if($vehicletype == 'Motorcycle') {?>

                                        <div id="plateTwo" class="plateTwo">
                                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/b--2.png" alt="">
                                            </div>
                                      
                                        <script>
                                                 jQuery(document).ready(function ($) {
                                                    $fimg =  sessionStorage.getItem('back_img');
                                                    $("#backimg").attr("value", $fimg);
                                                 });
                                               </script>

                                    <?php } ?>

                                    </div>

                                <div class="cardActionBtnWrap">
                                    <a href="#progress-content-section" id="step1_btn" class="checkout">Next</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
</div>

        <!-- product details end-->

<!-- billing  -->
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
<div class="section-content step2">
    <section class="innerBack" style="background: url(<?php echo get_template_directory_uri() ?>/assets/images/innerBack.jpg) no-repeat; background-size: cover; background-position: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="progressBar"></div>
                </div>
                <div class="col-lg-12">
                    <div class="innerCartWrapper">
                        <div class="customerBillingWrap ">
                        <div class="heading">
                                        <h1>Billing Details:</h1>
                                    </div>
                                    <div class="customerDetails findadrss"> 
                        <!-- <form action="" method="post" name="findbyzipcode" class="findbyzip"/>
                        <div class="form-group">
                                <label>Find Addres By Postcode</label>
                                <input type="text" class="form-control" id="findbyzipcode" name="zipcodefeild">
                                <button type="submit" name="findbyzipcode" mclass="findaddress">Find Address <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                        </div>
                            </form> -->
                                    </div>
                         
                                <?php if ( $checkout->get_checkout_fields() ) : ?>

                                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                                      
                                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                                  
                                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                        </div>

                                        <div class="cardActionBtnWrap">
                                            <a href="#progress-content-section" id="back_to_first" class="addMore"><span><i class="fa fa-angle-left" aria-hidden="true"></i></span> back</a>
                                            <a href="#progress-content-section" id="go_to_shipping" class="checkout">continue <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>

<!-- billing end -->

<!-- shiping -->

<div class="section-content step3">
    <section class="innerBack" style="background: url(<?php echo get_template_directory_uri() ?>/assets/images/innerBack.jpg) no-repeat; background-size: cover; background-position: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="progressBar"></div>
                </div>
                <div class="col-lg-12">
                    <div class="innerCartWrapper">
                        <div class="cardHeading">
                            <h1>Please select a UK delivery option from either of the 3 below options...</h1>
                        </div>
                        <div class="customerBillingWrap customerdelivaryWrap">
                            <div class="radioSelectSec">
                                <div class="redioSecHeading">]
                                    <label for="test1" class="radio">
                                        <div class="innerRadio">
                                            <input type="radio" name="you_are" id="test1" class="radioInput" value="" checked>
                                            <div class="radio__radio"></div>
                                        </div>
                                        <small>Basic</small>
                                    </label>
                                </div>
                                <div class="deliveryDesc">
                                    <div class="leftSec">
                                        <ul>
                                            <li>
                                                <div class="wrap">
                                                    <div class="iconBx">
                                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/basic.svg" alt="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>5 - 6 Days</li>
                                            <li>£ 6.99</li>
                                        </ul>
                                    </div>

                                    <div class="calenderSec">
                                        <div class="dateSec">
                                            <div class="dates">
                                                <input type="text" class="form-control date_format" id="usr1" name="event_date" placeholder="DD-MM-YY" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="radioSelectSec">
                                <div class="redioSecHeading">
                                    <label for="test2" class="radio">
                                        <div class="innerRadio">
                                            <input type="radio" name="you_are" id="test2" class="radioInput" value="">
                                            <div class="radio__radio"></div>
                                        </div>
                                        <small>Standard</small>
                                    </label>
                                </div>

                                <div class="deliveryDesc">
                                    <div class="leftSec">
                                        <ul>
                                            <li>
                                                <div class="wrap">
                                                    <div class="iconBx">
                                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/star.svg" alt="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>5 - 6 Days</li>
                                            <li>£ 6.99</li>
                                        </ul>
                                    </div>
                                    <div class="calenderSec">
                                        <div class="dateSec">
                                            <div class="dates">
                                                <input type="text" class="form-control date_format" id="usr1" name="event_date" placeholder="DD-MM-YY" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="radioSelectSec">
                                <div class="redioSecHeading">
                                    <label for="test3" class="radio">
                                        <div class="innerRadio">
                                            <input type="radio" name="you_are" id="test3" class="radioInput" value="">
                                            <div class="radio__radio"></div>
                                        </div>
                                        <small>Premium</small>
                                    </label>
                                </div>
                                <div class="deliveryDesc">
                                    <div class="leftSec">
                                        <ul>
                                            <li>
                                                <div class="wrap">
                                                    <div class="iconBx">
                                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/dimond.svg" alt="">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>5 - 6 Days</li>
                                            <li>£ 6.99</li>
                                        </ul>
                                    </div>
                                    <div class="calenderSec">
                                        <div class="dateSec">
                                            <div class="dates">
                                                <input type="text" class="form-control date_format" id="usr1" name="event_date" placeholder="DD-MM-YY" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cardActionBtnWrap">
                            <a href="#progress-content-section" id="back_to_adrs" class="addMore"><span><i class="fa fa-angle-left" aria-hidden="true"></i></span> back</a>
                            <a href="#progress-content-section" id="to_payment" class="checkout">continue <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

        <!-- shiping end -->

        <!-- last sec -->


        <div class="section-content step4">
            <section class="innerBack" style="background: url(<?php echo get_template_directory_uri() ?>/assets/images/innerBack.jpg) no-repeat; background-size: cover; background-position: center;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="progressBar"></div>
                        </div>
                        <div class="col-lg-12">
                            <div class="innerCartWrapper summaryContainer">

                            <div class="summryWrapper">
                                    <div class="heading">
                                        <h1>Billing Address:</h1>
                                    </div>
                                    <div class="addressSummary">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="addressSummaryInner">
                                                    <div class="box">
                                                        <h2>Name:</h2>
                                                        <h3 id="bname1">Ushasri Chatterjee</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Company:</h2>
                                                        <h3 id="bcmpny1">abc</h3>
                                                    </div>
                                                    <div class="box addressBx">
                                                        <h2>Address:</h2>
                                                        <h3 id="baddrs1">3 Portway Close</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Town / City:</h2>
                                                        <h3 id="bcity1">READING</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Country:</h2>
                                                        <h3>United Kingdom</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Postcode:</h2>
                                                        <h3 id="zipcb1">RG1 6LB</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Mobile:</h2>
                                                        <h3 id="bmob1">0000111122</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Email:</h2>
                                                        <h3 id="bemail1">abc@email.com</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                            <div class="addressSummaryInner">
                                                    <div class="box">
                                                        <h2>Name:</h2>
                                                        <h3 id="bname2">Ushasri Chatterjee</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Company:</h2>
                                                        <h3 id="bcmpny2">abc</h3>
                                                    </div>
                                                    <div class="box addressBx">
                                                        <h2>Address:</h2>
                                                        <h3 id="baddrs2">3 Portway Close</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Town / City:</h2>
                                                        <h3 id="bcity2">READING</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Country:</h2>
                                                        <h3>United Kingdom</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Postcode:</h2>
                                                        <h3 id="zipcb2">RG1 6LB</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Mobile:</h2>
                                                        <h3 id="bmob2">0000111122</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Email:</h2>
                                                        <h3 id="bemail2">abc@email.com</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shipping_address">
                                        <div class="heading">
                                        <h1>Shipping Address:</h1>
                                    </div>
                                    <div class="addressSummary ">
                                        <div class="row">
                                            <div class="col-lg-6">
                                            <div class="addressSummaryInner">
                                                    <div class="box">
                                                        <h2>Name:</h2>
                                                        <h3 id="sname1">Ushasri Chatterjee</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Company:</h2>
                                                        <h3 id="scmpny1">abc</h3>
                                                    </div>
                                                    <div class="box addressBx">
                                                        <h2>Address:</h2>
                                                        <h3 id="saddrs1">3 Portway Close</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Town / City:</h2>
                                                        <h3 id="scity1">READING</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Country:</h2>
                                                        <h3>United Kingdom</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Postcode:</h2>
                                                        <h3 id="sipcb1">RG1 6LB</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                            <div class="addressSummaryInner">
                                                    <div class="box">
                                                        <h2>Name:</h2>
                                                        <h3 id="sname2">Ushasri Chatterjee</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Company:</h2>
                                                        <h3 id="scmpny2">abc</h3>
                                                    </div>
                                                    <div class="box addressBx">
                                                        <h2>Address:</h2>
                                                        <h3 id="saddrs2">3 Portway Close</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Town / City:</h2>
                                                        <h3 id="scity2">READING</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Country:</h2>
                                                        <h3>United Kingdom</h3>
                                                    </div>
                                                    <div class="box">
                                                        <h2>Postcode:</h2>
                                                        <h3 id="sipcb2">RG1 6LB</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="heading">
                                     <h1><?php echo get_the_title( '20' );?></h1>
                                    </div>
                                    <div class="cardDescrib">
                                             <div class="leftPanel">
                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Registration</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="reg_no"><?php echo $reg_no; ?></h3>
                                            </div>
                                        </div>
                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2 >Size Front:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="front"><?php echo $FrontSize; ?></h3>
                                            </div>
                                        </div>
                                                <?php } }?>
                                                <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Size Rear:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="back"><?php echo $rearsize; ?></h3>
                                            </div>
                                        </div>
                                        <?php }} else if($vehicletype == 'Motorcycle') {?>

                                            <div class="carDetails">
                                                    <div class="name">
                                                        <h2>Size Rear:</h2>
                                                    </div>
                                                    <div class="desc">
                                                        <h3 id="back"><?php echo $rearsize; ?></h3>
                                                    </div>
                                                    </div>
                                        <?php } ?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Font:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>UK Legal</h3>
                                            </div>
                                        </div>
                                    
                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Legal Details:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3 id="legal"><?php echo $templatelegal; ?></h3>
                                            </div>
                                        </div>

                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Front Plates:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>1</h3>
                                            </div>
                                        </div>

                                        <?php }} ?>
                                        <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Rear Plates:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3>1</h3>
                                            </div>
                                        </div>
                                        <?php }} else if($vehicletype == 'Motorcycle') {?>

                                            <div class="carDetails">
                                                <div class="name">
                                                    <h2>Rear Plates:</h2>
                                                </div>
                                                <div class="desc">
                                                    <h3>1</h3>
                                                </div>
                                                </div>

                                                 <?php } ?>
                                        <?php if($templateborder != 'No Border') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Border Type:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3><?php echo $templateborder; ?></h3>
                                            </div>
                                        </div>

                                        <div class="carDetails">
                                            <div class="name">
                                            <h2>Border Color:</h2>
                                            </div>
                                            <div class="desc">
                                            <h3><?php echo $bordercolour; ?></h3>
                                            </div>
                                        </div>
                                         <?php } ?>

                                        <?php if($templatebadge != 'No Badge') {?>

                                        <div class="carDetails">
                                            <div class="name">
                                                <h2>Badge:</h2>
                                            </div>
                                            <div class="desc">
                                                <h3><?php echo $templatebadge; ?></h3>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>

                                        <div class="rightPanel">
                                            <div class="finalTotalWrap">
                                                <?php //do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                                        <?php endif; ?>
                                        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                                        <div class="innerHeading">
                                        <h2 id="order_review_heading" class="mt-1"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h2>
                                        </div>
                                        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                                        <div id="order_review" class="woocommerce-checkout-review-order">
                                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                                        </div>
                                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="productView">
                                <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'front') {?>

                                    <div id="plateOnes" class="plateOne">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/b-1.png" alt="">
                                    </div>

                                      <?php }} ?>
                                      <?php if($vehicletype == 'Vehicle') {?>
                                            <?php if($plate_qty == 'both' || $plate_qty == 'rear') {?>

                                            <div id="plateTwos" class="plateTwo">
                                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/b--2.png" alt="">
                                            </div>
                                
                                    <?php }} else if($vehicletype == 'Motorcycle') {?>

                                        <div id="plateTwos" class="plateTwo">
                                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/b--2.png" alt="">
                                            </div>
                                      
                                    <?php } ?>

                                    </div>

                                <div class="cardActionBtnWrap">
                                    <a href="#progress-content-section" id="back_to_shiping" class="addMore"><span><i class="fa fa-angle-left" aria-hidden="true"></i></span> back</a>
                                </div>
         
                                </div>
                                </div>

                      

<?php //do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

            </div>
            </div>
    </div>
    </form>
    </div>
    </section>
    </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {

            $front_img = sessionStorage.getItem('front_img');
            $back_img = sessionStorage.getItem('back_img');

            $('#plateOne').html('<img src="'+ $front_img +'" alt="front-plate">');
            $('#plateTwo').html('<img src="'+ $back_img +'" alt="back-plate">');

            
            $('#plateOnes').html('<img src="'+ $front_img +'" alt="front-plate">');
            $('#plateTwos').html('<img src="'+ $back_img +'" alt="back-plate">');

            $linfo = '<?php echo $templatelegal; ?>'
            $vehicletype = '<?php echo $vehicletype; ?>'
            $font = 'UK Legal'
            $("#legalinfo").attr("value", $linfo);
            $("#vechiletype").attr("value", $vehicletype);
            $("#platefont").attr("value", $font);

            




        });
    </script>

