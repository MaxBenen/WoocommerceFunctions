//email function
add_action('woocommerce_order_status_pending_to_cancelled', 'cancelled_send_an_email_notification', 10, 2 );
function cancelled_send_an_email_notification( $order_id, $order ){
    // Getting all WC_emails objects
    $email_notifications = WC()->mailer()->get_emails();

    // Sending the email
    $email_notifications['WC_Email_Cancelled_Order']->trigger( $order_id );
}


function add_dark_mode_meta_and_styles_to_emails() {
    echo '<meta name="color-scheme" content="only">';
    echo '<style type="text/css">
        /* Your CSS styles for handling dark mode here */
		#outer_wrapper {
		background-color: whitesmoke !important;
		}
		
		#template_header{
		background-color: #111111 !important; 
		}
		
		#body_content{
		background-color: white !important; 
		}
		
		h2{
		color: #111111 !important; 
		}
		
		#body_content_inner{
		color: #636363 !important; 
		}
    </style>';
}
add_action('woocommerce_email_header', 'add_dark_mode_meta_and_styles_to_emails');