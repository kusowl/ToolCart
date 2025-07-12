$(document).ready(function () {
    function show_address_form() {
        $('#address-form').show();
    }
})

function load_address_form(id) {
    console.log('modal opened')
    // let id = $('#address_id').val()

    fetch('/ToolCart/handler/CheckoutHandler', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({id: id, action: 'getAddressData'})
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('country').value = data.country;
            document.getElementById('city').value = data.city;
            document.getElementById('pin').value = data.pin;
            document.getElementById('country_code').value = data.countryCode;
            document.getElementById('line-1').value = data.line1;
            document.getElementById('line-2').value = data.line2;
            document.getElementById('instructions').value = data.instructions;
            document.getElementById('phone_no').value = data.phNo;
            document.getElementById('address_id').value = data.id;
            document.getElementById('action').value = 'updateAddress';
            document.getElementById('submitBtn').innerHTML = 'Update Address';
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function submit_address_form() {
    $('#address-form').submit();
    console.log('Address form submit')
}

function deleteAddress() {
// address id
    let addressId = document.getElementById('address_id').value
    // AJAX request to handler
    let data = {
        'address_id': addressId,
        'action': 'deleteAddress'
    }
    let url = 'http://localhost/ToolCart/handler/CheckoutHandler'
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)

    }).then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();  // Parse JSON response
    })
        .then(result => {
            console.log('Success:', result);  // Handle the response data
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);  // Handle errors
            window.location.reload();
        });
}