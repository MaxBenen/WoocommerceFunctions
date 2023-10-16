function custom_hide_widget_if_cart_empty($content) {
    // Check if WooCommerce is active and if we are on the cart page
    if ( class_exists('WooCommerce') && is_cart() && WC()->cart->is_empty() ) {
        // Add a script and CSS to hide the widget container by setting its display to "none"
        $content .= '<style>
            @media screen and (max-width: 767px) {
                #wagen-icons {
                    display: none !important;
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var widgetToHide = document.getElementById("wagen-icons");
                if (widgetToHide) {
                    widgetToHide.style.display = "none";
                }
            });
        </script>';
    }
    return $content;
}

add_filter('the_content', 'custom_hide_widget_if_cart_empty');
