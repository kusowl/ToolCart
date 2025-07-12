$(document).ready(function () {
    // Handle form submission
    $('#orderForm').submit(function (e) {
        e.preventDefault();

        // Show loading
        $('#loading').show();
        $('#submitBtn').prop('disabled', true);

        // Collect form data
        const formData = {
            address_id: $('input[name="address_id"]:checked').map(function () {
                return $(this).val();
            }).get(),
            payment_method: $('input[name="payment_method"]:checked').map(function () {
                return $(this).val();
            }).get(),
            action: 'placeOrder'
        };
        // Create order via AJAX
        fetch('/ToolCart/handler/CheckoutHandler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(response => {
                // document.getElementById('loading').style.display = 'none';

                if (response.success) {
                    console.log(response.order);

                    if (response.order.pay_method === 'razorpay') {
                        initializeRazorpay(response.order);
                    } else {
                        alert('POD Order Success');
                        window.location.href = 'order.php?order_id=' + response.order_id;
                    }
                } else {
                    console.log(response);
                    alert('Error creating order: ' + response.message);
                    document.getElementById('submitBtn').disabled = false;
                }
            })
            .catch(error => {
                // document.getElementById('loading').style.display = 'none';
                alert('Error: ' + error.message);
                document.getElementById('submitBtn').disabled = false;
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
            handler: function (response) {
                console.log(response)
                verifyPayment(response, orderData);
            },
            theme: {
                color: "#0074EA"
            },
            modal: {
                ondismiss: function () {
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
        // $('#loading').show();
        const data = {
            razorpay_order_id: paymentResponse.razorpay_order_id,
            razorpay_payment_id: paymentResponse.razorpay_payment_id,
            razorpay_signature: paymentResponse.razorpay_signature,
            order_id: orderData.id,
            payment_method: orderData.pay_method,
            action: 'verifyOrder'
        }
        fetch('/ToolCart/handler/CheckoutHandler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(response => {
                // document.getElementById('loading').style.display = 'none';

                if (response.success) {
                    alert('Payment successful! Order ID: ' + response.order_id);
                    window.location.href = 'order.php?order_id=' + response.order_id;
                } else {
                    alert('Payment verification failed: ' + response.message);
                    document.getElementById('submitBtn').disabled = false;
                }
            })
            .catch(error => {
                // document.getElementById('loading').style.display = 'none';
                alert('Verification error: ' + error.message);
                document.getElementById('submitBtn').disabled = false;
            });

    }
});