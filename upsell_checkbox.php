
// Add checkbox product page
function add_smart_hub_checkbox() {
    global $product;

    if ($product->is_type('simple') && $product->get_id() === 123) {
        echo '<label for="smart_hub_checkbox" class="check_product"><input type="checkbox" id="smart_hub_checkbox" name="smart_hub_checkbox">Add text for upsell product</label>';
    }
}
add_action('woocommerce_after_add_to_cart_button', 'add_smart_hub_checkbox');

// Add product to cart if checkbox is checked
function add_smart_hub_to_cart() {
    if (isset($_POST['smart_hub_checkbox']) && $_POST['smart_hub_checkbox'] && isset($_POST['add-to-cart'])) {
        WC()->cart->add_to_cart(5080);
    }
}
add_action('wp_loaded', 'add_smart_hub_to_cart');

