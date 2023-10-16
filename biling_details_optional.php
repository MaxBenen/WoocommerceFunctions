//Making phone optional on billing page 

add_filter( 'woocommerce_billing_fields', 'ts_unrequire_wc_phone_field');
function ts_unrequire_wc_phone_field( $fields ) {
$fields['billing_phone']['required'] = false;
return $fields;
}