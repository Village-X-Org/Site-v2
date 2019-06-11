<script src="https://checkout.stripe.com/checkout.js" ></script>
<script>
// Stripe
var handler = StripeCheckout.configure({
  key: '<?php print (isset($_SESSION['test']) && $_SESSION['test'] ? STRIPE_TEST_API_KEY : STRIPE_API_KEY); ?>',
  image: 'https://villagex.org/images/logox.jpg',
  locale: 'auto',
  token: function(token) {
	  form = document.getElementById('donateForm');
	  form.stripeToken.value = token.id;
	  form.stripeAmount.value = donationAmount;
	  form.gcAmount.value = donationGCAmount;
	  form.isSubscription.value = donationIsSubscription;
	  form.firstName.value = donationFirstName;
	  form.lastName.value = donationLastName;
	  form.stripeEmail.value = donationEmail;
	  form.projectId.value = donationProjectId;
	  form.honoreeId.value = donationHonoreeId;
	  form.honoreeMessage.value = donationHonoreeMessage;
	  form.fundraiserId.value = donationFundraiserId;
	  form.fundraiserMessage.value = donationFundraiserMessage;
	  
	  form.submit();
  }
});

//Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});

function donateWithStripe(subscribe, amount, title, projectId, firstName, lastName, email, anonymous, honoreeId, honoreeMessage, gcAmount, fundraiserId, fundraiserMessage) {
 	if (<?php print ((isset($_SESSION['offline']) && $_SESSION['offline'] == 1) ? "true" : "false"); ?>
 		|| amount == 0) {
 	  form = document.getElementById('donateForm');
	  form.stripeToken.value = amount == 0 ? 'gcOnly' : 'offline';
	  form.stripeEmail.value = email;
	  form.stripeAmount.value = amount;
	  form.gcAmount.value = gcAmount * 100;
	  form.isSubscription.value = subscribe;
	  form.firstName.value = firstName;
	  form.lastName.value = lastName;
	  form.projectId.value = projectId;
	  form.honoreeId.value = honoreeId;
  	  form.honoreeMessage.value = honoreeMessage;
  	  form.fundraiserId.value = fundraiserId;
  	  form.fundraiserMessage.value = fundraiserMessage;
    	  
      form.submit();		
 	} else {
	  donationIsSubscription = subscribe;
	  donationFirstName = firstName;
	  donationLastName = lastName;
	  donationEmail = email;
	  donationProjectId = projectId;
	  donationAmount = amount;
	  donationGCAmount = gcAmount * 100;
	  donationHonoreeId = honoreeId;
	  donationHonoreeMessage = honoreeMessage;
	  donationFundraiserId = fundraiserId;
	  donationFundraiserMessage = fundraiserMessage;
	  handler.open({
	    name: 'Village X Org',
	    description: (subscribe ? 'Monthly Subscription' : title),
	    amount: amount,
	    email: email
	  });
	}
}

// End Stripe

</script>
