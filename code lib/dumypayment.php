<?php
/* Template Name: Paypal Payment*/ 


get_header();
?>
<style>
	.button_wrap{
		padding-top: 250px;
		text-align:center;
	}
</style>
<div class="paypal_from_wraper">
<div class="paypal_from">
<div class="tm-text-box contact-text style-01 tm-animation move-up animate" id="tm-text-box-641ad35c79c63">
			<h5 class="heading">PayPal Payment Form</h5>
			<div class="text">
			It’s our pleasure to co-operate with you.		</div>
	</div>
<div id="smart-button-container">
  <div >
    <label for="description">Full Name:</label>
    <input type="text" name="fullname" id="fullname" maxlength="127" value="" >
    </div>
    <p id="descriptionError" style="display: none; color:red;">Name Field Can't be Empty</p>
    <div >
    <label for="mobileno">Mobile No:</label>
    <input type="tel" name="mobileno" id="mobileno" max="10" min="10" value="" >
    </div>
    <p id="descriptionError" style="display: none; color:red;">Mobile Field Can't be Empty</p>
    <div>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" >
    </div>
    <p id="descriptionError" style="display: none; color:red;">Email Field Can't be Empty</p>
    <div  >
    <label for="description">Project Short Description:</label>
    <textarea name="descriptionInput" id="description"  rows="4" cols="50"></textarea>
    </div>
      <p id="descriptionError" style="display: none; color:red; text-align: center;">Product Descriptions Field Can't be Empty</p>
    <div  ><label for="amount">Amount: </label><input name="amountInput" type="number" id="amount" value="" ><span> USD</span></div>
      <p id="priceLabelError" style="display: none; color:red; text-align: center;">Please enter a price</p>
    <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value="" ></div>
      <p id="invoiceidError" style="display: none; color:red; text-align: center;">Please enter an Invoice ID</p>
    <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
  </div>
  </div>
</div>
  <script src="https://www.paypal.com/sdk/js?client-id=myclienyid_&enable-funding=venmo" data-sdk-integration-source="button-factory"></script>
  <script>
  function initPayPalButton() {
    var fullname = document.querySelector('#smart-button-container #description');
    var fullnameError = document.querySelector('#smart-button-container #description');
    var mobile = document.querySelector('#smart-button-container #description');
    var phoneError = document.querySelector('#smart-button-container #description');
    var email = document.querySelector('#smart-button-container #description');
    var emailError = document.querySelector('#smart-button-container #description');
    var description = document.querySelector('#smart-button-container #description');
    var description = document.querySelector('#smart-button-container #description');
    var amount = document.querySelector('#smart-button-container #amount');
    var descriptionError = document.querySelector('#smart-button-container #descriptionError');
    var priceError = document.querySelector('#smart-button-container #priceLabelError');
    var invoiceid = document.querySelector('#smart-button-container #invoiceid');
    var invoiceidError = document.querySelector('#smart-button-container #invoiceidError');
    var invoiceidDiv = document.querySelector('#smart-button-container #invoiceidDiv');

    var elArr = [description, amount];

    if (invoiceidDiv.firstChild.innerHTML.length > 1) {
      invoiceidDiv.style.display = "block";
    }

    var purchase_units = [];
    purchase_units[0] = {};
    purchase_units[0].amount = {};

    function validate(event) {
      return event.value.length > 0;
    }

    paypal.Buttons({
      style: {
        color: 'gold',
        shape: 'rect',
        label: 'paypal',
        layout: 'vertical',
        
      },

      onInit: function (data, actions) {
        actions.disable();

        if(invoiceidDiv.style.display === "block") {
          elArr.push(invoiceid);
        }

        elArr.forEach(function (item) {
          item.addEventListener('keyup', function (event) {
            var result = elArr.every(validate);
            if (result) {
              actions.enable();
            } else {
              actions.disable();
            }
          });
        });
      },

      onClick: function () {
        if (description.value == '') {
          descriptionError.style.visibility = "block";
        } else {
          descriptionError.style.visibility = "none";
        }

        if (amount.value.length < 1) {
          priceError.style.display = "block";
        } else {
          priceError.style.display = "none";
        }

        if (invoiceid.value.length < 1 && invoiceidDiv.style.display === "block") {
          invoiceidError.style.display = "block";
        } else {
          invoiceidError.style.display = "none";
        }

        purchase_units[0].description = description.value;
        purchase_units[0].amount.value = amount.value;

        if(invoiceid.value !== '') {
          purchase_units[0].invoice_id = invoiceid.value;
        }
      },

      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: purchase_units,
        });
      },

      onApprove: function (data, actions) {
        return actions.order.capture().then(function (orderData) {

          // Full available details
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

          // Show a success message within this page, e.g.
          const element = document.getElementById('paypal-button-container');
          element.innerHTML = '';
          element.innerHTML = '<h3>Thank you for your payment!</h3>';

          // Or go to another URL:  actions.redirect('thank_you.html');
          
        });
      },

      onError: function (err) {
        console.log(err);
      }
    }).render('#paypal-button-container');
  }
  initPayPalButton();
  </script>



<?php get_footer();
