$(document).ready(function (){
    function updateQty(productId, cartQty, cartQtyElm, request){
        $.ajax({
                method: 'POST',
                url: 'handler/CartHandler.php',
                data : {
                    productId : productId,
                    request : request,
                    cartQty : cartQty
                },
                success: function () {
                    console.log('Cart updated successfully');
                    cartQtyElm.text(cartQty)
                    cartQtyElm.data('item-qty', cartQty)
                    updateCartTotalCount()
                },
                error : function (){
                    console.log('Error in cart update')
                }
            }
        )
    }

    function updateCartTotalCount(){
        $.ajax(
            {
                method:'GET',
                url :'handler/CartHandler.php',
                data : {
                    q : 'totalCartQty'
                },
                success : function (response){
                    if(response.success){
                        $('#cartTotalItemCount').text(response.totalQty)
                    }
                    else{
                        console.log('Error in getting totoal Cart Count')
                    }
                }
            }
        )
    }
    $('.incrementCartBtn').on(
        'click',
        function (){
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.data('item-qty'))
            updateQty(productId, cartQty + 1,  cartQtyElm, 'incrementQty')
        }
    )
    $('.decrementCartBtn').on(
        'click',
        function (){
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.data('item-qty'))
            if(cartQty > 1){
            updateQty(productId, cartQty - 1,  cartQtyElm, 'decrementQty')
            }
            else{
                console.log('Cart item cannot be less than 1')
            }
        }
    )
})