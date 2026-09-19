<script type="text/javascript">
    $(document).on('change', '.radio-input', function() {
        let paymentMethod = $(this).val();

        if (paymentMethod === 'Stripe') {
            $('#stripeOption').show();
            $('#stripe-pay-btn').show();
            $('#paypal-pay-btn').addClass('d-none');
        } else {
            $('#stripeOption').hide();
            $('#stripe-pay-btn').hide();
            $('#paypal-pay-btn').removeClass('d-none');
        }
    });





    var stripe = Stripe(`{{ Setting('stripe_key') }}`)
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        document.getElementById("stripe-pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {

            if (typeof result.error != 'undefined') {
                document.getElementById("stripe-pay-btn").disabled = false;
                alert(result.error.message);
            }

            /* creating token success */
            if (typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }
</script>
