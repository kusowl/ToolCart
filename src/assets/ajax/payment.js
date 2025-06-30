$(document).ready(function() {
    // Handle form submission
    $('#orderForm').submit(function(e) {
        e.preventDefault();

        // Show loading
        $('#loading').show();
        $('#submitBtn').prop('disabled', true);

        // Collect form data
        const formData = {
            address_id: $('input[name="address_id"]:checked').map(function() {
                return $(this).val();
            }).get(),
            payment_method: $('input[name="payment_method"]:checked').map(function() {
                return $(this).val();
            }).get(),
            action: 'placeOrder'
        };

        // Create order via AJAX
        $.ajax({
            url: 'src/handler/CheckoutHandler.php',
            method: 'POST',
            contentType : 'application/json',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(response) {
                $('#loading').hide();
                if (response.success) {
                    console.log(response.order)
                    initializeRazorpay(response.order);
                } else {
                    alert('Error creating order: ' + response.message);
                    $('#submitBtn').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                $('#loading').hide();
                alert('Error: ' + error);
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

    function initializeRazorpay(orderData) {
        const options = {
            key: orderData.razorpay_key,
            amount: orderData.amount,
            currency: orderData.currency,
            order_id: orderData.id,
            name: "ToolCart",
            description: "Order Payment",
            // image: "https://your-website.com/logo.png",
            handler: function(response) {
                console.log(response)
                verifyPayment(response, orderData);
            },
            theme: {
                color: "#0074EA"
            },
            modal: {
                ondismiss: function() {
                    // Payment cancelled
                    alert('Payment cancelled');
                    $('#submitBtn').prop('disabled', false);
                }
            }
        };

        const razorpay = new Razorpay(options);
        razorpay.open();
    }

    function verifyPayment(paymentResponse, orderData) {
        // Show loading
        $('#loading').show();

        $.ajax({
            url: 'src/handler/CheckoutHandler.php',
            method: 'POST',
            contentType : 'application/json',
            data: {
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_signature: paymentResponse.razorpay_signature,
                order_id: orderData.id,
                'action' : 'verifyOrder'
            },
            dataType: 'json',
            success: function(response) {
                $('#loading').hide();

                if (response.success) {
                    // Payment verified successfully
                    alert('Payment successful! Order ID: ' + response.order_id);
                    window.location.href = 'success.php?order_id=' + response.order_id;
                } else {
                    alert('Payment verification failed: ' + response.message);
                    $('#submitBtn').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                $('#loading').hide();
                alert('Verification error: ' + error);
                $('#submitBtn').prop('disabled', false);
            }
        });
    }
});