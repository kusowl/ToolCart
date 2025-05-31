$(document).ready(function (){
    function updateQty(productId, cartQty, cartQtyElm, requestType){
        $.ajax({
                method: 'POST',
                url: 'src/handler/CartHandler.php',
                data : {
                    productId : productId,
                    requestType : requestType,
                    cartQty : cartQty
                },
                success: function () {
                    console.log('Cart updated successfully');
                    cartQtyElm.text(cartQty)
                    cartQtyElm.data('item-qty', cartQty)
                },
                error : function (){
                    console.log('Error in cart update')
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