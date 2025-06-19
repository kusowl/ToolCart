$(document).ready(function (){
  function show_address_form(){
      $('#address-form').show();
  }
})

function show_address_form(){
    $('#address-form').show();
    $('#address-grid').hide();
    $('#add-address-btn').attr('onclick', 'submit_address_form()').text('Save address')
}

function submit_address_form(){
    $('#address-form').submit();
    console.log('Address form submit')
}