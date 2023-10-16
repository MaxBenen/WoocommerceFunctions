
//Order failed code 
add_filter( 'woocommerce_email_recipient_failed_order', 'wc_failed_order_email_to_customer', 10, 2 );
function wc_failed_order_email_to_customer( $recipient, $order ){
     if( ! is_a( $order, 'WC_Order' ) ) 
         return $recipient;

     if( $billing_email = $order->get_billing_email() ) 
         $recipient = $billing_email;
     return $recipient;
}

// Send customer invoice email when order status is 'failed'
function send_customer_invoice_on_order_failed( $order_id ) {
    // Get the order object
    $order = wc_get_order( $order_id );

    // Check if the order has failed status
    if ( $order->get_status() === 'failed' ) {
        // Load the customer invoice email class
        $customer_invoice_email = WC()->mailer()->emails['WC_Email_Customer_Invoice'];

        // Send the email
        $customer_invoice_email->trigger( $order_id );
    }
}
add_action( 'woocommerce_order_status_failed', 'send_customer_invoice_on_order_failed' );
