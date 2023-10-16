// To change add to cart text on single product page
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');
function woocommerce_custom_single_add_to_cart_text()
{
    return __('Winkelwagen', 'woocommerce'); // Replace "Winkelwagen" text with your own text
}

// To change add to cart text on product archives(Collection) page
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text');
function woocommerce_custom_product_add_to_cart_text()
{
    return __('Winkelwagen', 'woocommerce'); // Replace "Winkelwagen" text with your own text
}

// To add styles to the add to cart button
add_action('wp_enqueue_scripts', 'add_custom_button_styles');
function add_custom_button_styles()

    ?>
    <style>
        /* Single product page button */
        .single_add_to_cart_button,
        .single_add_to_cart_button:before {
            background-color: #1270FF !important;
            color: #fff !important;
            border-radius: 50px !important;
            padding: 10px 50px !important;
            text-decoration: none !important;
        }

        /* Product archives page button */
        .button.product_type_simple.add_to_cart_button.ajax_add_to_cart {
            background-color: #1270FF !important;
            color: #fff !important;
            border-radius: 50px !important;
            padding: 10px 50px !important;
            text-decoration: none !important;
        }
    </style>
    <?php




/* Purchace button text  */

function my_custom_checkout_button_text() {
	return 'Bestelling plaatsen';
}
add_filter( 'woocommerce_order_button_text', 'my_custom_checkout_button_text' );
