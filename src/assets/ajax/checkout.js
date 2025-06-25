$(document).ready(function (){
  function show_address_form(){
      $('#address-form').show();
  }
})

function load_address_form(id){
    console.log('modal opened')
    // let id = $('#address_id').val()

    $.ajax({
        url: 'http://localhost/ToolCart/handler/CheckoutHandler',
        method: 'GET',
        contentType : 'application/json',
        data : JSON.stringify({id : id, action : 'getAddressData'}),
        dataType : "json",
        success : function (data){
            console.log(data)
            $('#name').val(data.name)
            $('#email').val(data.email)
            $('#country').val(data.country)
            $('#city').val(data.city)
            $('#pin').val(data.pin)
            $('#country_code').val(data.countryCode)
            $('#line-1').val(data.line1)
            $('#line-2').val(data.line2)
            $('#instructions').val(data.instructions)
            $('#phone_no').val(data.phNo)
            $('#address_id').val(data.id)
            $('#action').val('updateAddress')
            document.getElementById('submitBtn').innerHTML = 'Update Address'

        }
    })
}

function submit_address_form(){
    $('#address-form').submit();
    console.log('Address form submit')
}

function deleteAddress(){
// address id
    let addressId = document.getElementById('address_id').value
   // AJAX request to handler
    let data = {
        'address_id' : addressId,
        'action' : 'deleteAddress'
    }
    let url = 'http://localhost/ToolCart/handler/CheckoutHandler'
    fetch(url,{
        method : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        },
        body : JSON.stringify(data)

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