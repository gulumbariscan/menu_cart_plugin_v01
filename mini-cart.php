<?php
/*
Plugin Name: Mini Cart Plugin
Description: Mini Cart Shortcode.
Version: 1.0
Author: Can Bacco
*/

function enqueue_custom_scripts()
{
    wp_enqueue_script(
        "custom-scripts",
        plugin_dir_url(__FILE__) . "assets/script.js"
    );
    wp_enqueue_style(
        "custom-styles",
        plugin_dir_url(__FILE__) . "assets/style.css"
    );
    wp_enqueue_script("jquery");
    wp_localize_script("custom-scripts", "myAjax", [
        "ajaxurl" => admin_url("admin-ajax.php"),
    ]);
}
add_action("wp_enqueue_scripts", "enqueue_custom_scripts");

function mini_cart_function()
{
    ob_start(); ?>
    
<div class="cart-container">
    <div class="mini-cart-container">
        <div class="mini-cart-head">Sepetim (<span class="mini-total-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)</div>
        <div class="mini-cart-products">
            <ul class="mini-cart-list">
                <?php foreach (
                    WC()->cart->get_cart()
                    as $cart_item_key => $cart_item
                ):

                    $_product = apply_filters(
                        "woocommerce_cart_item_product",
                        $cart_item["data"],
                        $cart_item,
                        $cart_item_key
                    );
                    $product_id = apply_filters(
                        "woocommerce_cart_item_product_id",
                        $cart_item["product_id"],
                        $cart_item,
                        $cart_item_key
                    );
                    ?>
                <li class="mini-cart-product">
                    <div class="product-delete">
                        <a href="#" class="delete-link" data-cart-item-key="<?php echo esc_attr(
                            $cart_item_key
                        ); ?>"
                            x
                        </a>
                    </div>
                    <a href="<?php echo esc_url(
                        $_product->get_permalink()
                    ); ?>" class="product-main">
                        <?php $thumbnail = $cart_item["data"]->get_image(); ?>
                        <img src=<?php echo $thumbnail; ?>
                        <div class="mini-product-inner">
                            <div class="mini-product-name"><?php echo $cart_item[
                                "data"
                            ]->get_title(); ?></div>
                            <div class="mini-product-prc-qty"><span class="qcy"><?php echo $cart_item[
                                "quantity"
                            ]; ?> </span>x <span class="prc"><?php echo wc_price(
     $cart_item["data"]->get_price()
 ); ?></span>₺</div>
                        </div>
                    </a>
                </li>
                <?php
                endforeach; ?>
            </ul>
        </div>
        <div class="mini-cart-subtotal">
            <div class="subtotal-text">
                Ara toplam:
            </div>
            <div class="subtotal-amount">
                <?php echo WC()->cart->get_cart_total(); ?>
            </div>
        </div>
        <div class="mini-cart-buttons">
            <a href="<?php echo wc_get_cart_url(); ?>" class="cart-buttons go-to-cart">
                Sepete Git
            </a>
            <a href="<?php echo wc_get_checkout_url(); ?>" class="cart-buttons go-to-checkout">
                Alışverişi Tamamla
            </a>
        </div>
    </div>
    <button href="" id="shoppingButton">
        <div class="icon-area" id="openMobileCart">
            <img src="<?php echo plugin_dir_url(
                __DIR__
            ); ?>/mini-cart-plugin-v01/icons/shopping-cart-icon.svg" alt="Cart Icon" />
            <span class="mini-cart-count" id="cartCount"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </div>
    </button>
    <!--Desktop / Mobile -->
    <div class="mobile-cart-container" id="mobileCart">
        <div class="mobile-cart-head">
            Sepetim (<span class="mobile-total-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)
            <button id="closeMobileCart" class="close-mobile-cart">X</button>
        </div>
        <div class="mini-cart-products">
            <ul class="mobile-cart-list">
                <?php foreach (
                    WC()->cart->get_cart()
                    as $cart_item_key => $cart_item
                ):
                    $_product = apply_filters(
                        "woocommerce_cart_item_product",
                        $cart_item["data"],
                        $cart_item,
                        $cart_item_key
                    ); ?>
                <li class="mini-cart-product mobile-cart-product">
                    <div class="product-delete">
                        <a href="<?php echo esc_url(
                            wc_get_cart_remove_url($cart_item_key)
                        ); ?>">
                            x
                        </a>
                    </div>
                    <div class="product-main">
                        <a href="<?php echo esc_url(
                            $_product->get_permalink()
                        ); ?>">
                        <?php $thumbnail = $cart_item["data"]->get_image(); ?>
                            <img class="mobile-cart-image" src="<?php echo $thumbnail; ?>  
                        </a>
                        <div class="mobile-product-inner">
                            <div class="mobile-product-inner-left">
                                <a href="<?php echo esc_url(
                                    $_product->get_permalink()
                                ); ?>">
                                    <div class="mini-product-name">
                                        <?php echo $cart_item[
                                            "data"
                                        ]->get_title(); ?>
                                    </div>
                                </a>
                                <div class="mobile-cart-counter">
                                    <span class="mobile-cart-counter-minus">
                                        <a href="youtube.com">-</a>
                                    </span>
                                    <span class="mobile-cart-counter-count">
                                        <?php echo $cart_item["quantity"]; ?> 
                                    </span>
                                    <span class="mobile-cart-counter-plus">
                                        <a href="google.com">+</a>
                                    </span>
                                </div>
                            </div>
                            <div class="mini-product-prc-qty mobile-product-inner-right">
                                <a href="<?php echo esc_url(
                                    $_product->get_permalink()
                                ); ?>"> <span class="prc"><?php echo wc_price(
    $cart_item["data"]->get_price()
); ?></span>₺ </a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
                endforeach; ?>
            </ul>
        </div>
        <div class="mini-cart-subtotal mobile-cart-subtotal">
            <div class="subtotal-text">
                Ara toplam:
            </div>
            <div class="subtotal-amount">
                <?php echo WC()->cart->get_cart_total(); ?>
            </div>
        </div>
        <div class="mobile-cart-buttons">
            <a href="<?php echo wc_get_checkout_url(); ?>" class="cart-buttons">
                Alışverişi Tamamla
            </a>
            <button id="continueShopping" class="cart-buttons continue-shopping">Alışverişe devam et</button>
        </div>
    </div>
</div>

    
    <?php return ob_get_clean();
}
add_shortcode("mini_cart", "mini_cart_function");

add_action("wp_ajax_update_cart_item", "update_cart_item_callback");
add_action("wp_ajax_nopriv_update_cart_item", "update_cart_item_callback");

function update_cart_item_callback()
{
    // Get the cart item key and quantity from the AJAX request
    $cart_item_key = wc_clean($_POST["cart_item_key"]); // Use wc_clean to sanitize the input
    $quantity = wc_clean($_POST["quantity"]); // Use wc_clean to sanitize the input

    // Remove the cart item
    WC()->cart->remove_cart_item($cart_item_key);
    // Explicitly set cart totals

    // Calculate cart totals
    WC()->cart->calculate_totals();

    $total_amount = wc_price(WC()->cart->get_cart_total(), [
        "currency" => get_woocommerce_currency(),
    ]);

    // Return updated cart total and count
    echo json_encode([
        "total_count" => WC()->cart->get_cart_contents_count(),
        "total_amount" => wp_kses_post($total_amount),
    ]);

    die();
}

/*
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), '', true);

    // Define the variable ajaxurl in your script.js
    wp_localize_script('custom-scripts', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');*/
