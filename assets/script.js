window.onload = () => {
    var link = document.getElementById("shoppingButton");

    function redirectToCartPage() {
        link.onclick = function() {
            window.location.href = "/sepet";
        };
    }

    function removeOnClick() {
        link.onclick = null;
    }

    function changeHref() {


        if (window.innerWidth <= 600) {
            removeOnClick();
        } else {
            redirectToCartPage();
        }
    }
    changeHref();
    window.addEventListener("resize", changeHref);


};




document.addEventListener('DOMContentLoaded', function() {
    const openMobileCart = document.getElementById('openMobileCart');
    const mobileCart = document.getElementById('mobileCart');
    const closeMobileCart = document.getElementById('closeMobileCart');
    const continueShoppin = document.getElementById('continueShopping');

    openMobileCart.addEventListener('click', function() {
        mobileCart.classList.add('show');
    });

    closeMobileCart.addEventListener('click', function() {
        mobileCart.classList.remove('show');
    });

    continueShoppin.addEventListener('click', function() {
        mobileCart.classList.remove('show');
    });

    /** */
    document.querySelectorAll('.product-delete a').forEach(function(deleteLink) {
        deleteLink.addEventListener('click', function(event) {
            event.preventDefault();

            // Show loading spinner
            var spinner = document.createElement('div');
            spinner.className = 'loading-spinner';
            event.target.appendChild(spinner);

            // Get the cart item key
            var cartItemKey = event.target.getAttribute('data-cart-item-key');

            // Send AJAX request to update cart item
            var xhr = new XMLHttpRequest();
            xhr.open('POST', myAjax.ajaxurl, true); // Use myAjax.ajaxurl
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);

                    var subtotalAmount = document.querySelector('.subtotal-amount');
                    subtotalAmount.innerHTML = response.total_amount;
                    // Update cart count and total
                    document.querySelector('.mini-cart-count').textContent = response.total_count;
                    document.querySelector('.mini-total-count').textContent = response.total_count;

                    // Remove loading spinner
                    event.target.removeChild(spinner);

                    // Optionally, you can update other UI elements as needed
                    // You can force a page reload for testing purposes (remove this in production)
                    // window.location.reload();
                }
            };

            // Prepare data to send in the AJAX request
            var data = 'action=update_cart_item&cart_item_key=' + encodeURIComponent(cartItemKey) + '&quantity=0';
            xhr.send(data);
        });
    });
});