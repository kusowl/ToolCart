$(document).ready(function () {
    function updateQty(productId, cartQty, cartQtyElm, action) {
        $.ajax({
                method: 'POST',
                url: 'handler/CartHandler.php',
                data: {
                    productId: productId,
                    action: action,
                    cartQty: cartQty
                },
                success: function (response) {
                    if (response.success) {
                        $('#cartTotalItemCount').text(response.totalQty)
                        console.log('Cart updated successfully');
                        cartQtyElm.val(cartQty)
                        cartQtyElm.data('item-qty', cartQty)
                    }
                },
                error: function () {
                    console.log('Error in cart update')
                }
            }
        )
    }

    function removeCartItem(productId) {
        $.ajax(
            {
                url: 'handler/CartHandler.php',
                method: 'POST',
                data: {
                    productId: productId,
                    action: 'removeCartItem'
                },
                success: function (response) {
                    if (response.success) {
                        $('#cartTotalItemCount').text(response.totalQty)
                        $('#productId'.concat(productId)).hide('slow')
                        $('#cartProductId'.concat(productId)).hide('slow')
                        console.log('Item removed from the cart')
                    }
                },
                error: function () {
                    console.log('Error in deleteing item')
                }
            }
        )
    }

    $('.incrementCartBtn').on(
        'click',
        function () {
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.val())
            updateQty(productId, cartQty + 1, cartQtyElm, 'incrementQty')
        }
    )
    $('.decrementCartBtn').on(
        'click',
        function () {
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.val())
            console.log(cartQty)
            if (cartQty > 1) {
                updateQty(productId, cartQty - 1, cartQtyElm, 'decrementQty')
            } else {
                console.log('Cart item cannot be less than 1')
            }
        }
    )

    // Cart Page buttons
    $('.incrementCartPageBtn').on(
        'click',
        function () {
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.val())
            updateQty(productId, cartQty + 1, cartQtyElm, 'incrementQty')
            location.reload();
        }
    )
    $('.decrementCartPageBtn').on(
        'click',
        function () {
            let productId = $(this).data('product-id');
            let cartQtyElm = $(this).siblings('.cartQty');
            let cartQty = parseInt(cartQtyElm.val())
            console.log(cartQty)
            if (cartQty > 1) {
                updateQty(productId, cartQty - 1, cartQtyElm, 'decrementQty')
            } else {
                console.log('Cart item cannot be less than 1')
            }
            location.reload();
        }
    )

    $('.removeCartItemPageBtn').on(
        'click',
        function () {
            let productId = $(this).data('product-id')
            removeCartItem(productId)
            location.reload();
        }
    )
})