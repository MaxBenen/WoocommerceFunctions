
function get_total_reviews_count(){
    return get_comments(array(
        'status'   => 'approve',
        'post_status' => 'publish',
        'post_type'   => 'product',
        'count' => true
    ));
}

function get_products_ratings(){
    global $wpdb;

    return $wpdb->get_results("
        SELECT t.slug, tt.count
        FROM {$wpdb->prefix}terms as t
        JOIN {$wpdb->prefix}term_taxonomy as tt ON tt.term_id = t.term_id
        WHERE t.slug LIKE 'rated-%' AND tt.taxonomy LIKE 'product_visibility'
        ORDER BY t.slug
    ");
}

function products_count_by_rating_html(){
    $star = 1;
    $html = '';
    foreach( get_products_ratings() as $values ){
        $star_text = '<strong>'.$star.' '._n('Star', 'Stars', $star, 'woocommerce').'<strong>: ';
        $html .= '<li class="'.$values->slug.'">'.$star_text.$values->count.'</li>';
        $star++;
    }
    return '<ul class="products-rating">'.$html.'</ul>';
}

function products_rating_average_html(){
    $stars = 1;
    $average = 0;
    $total_count = 0;
    if( sizeof(get_products_ratings()) > 0 ) :
        foreach( get_products_ratings() as $values ){
            $average += $stars * $values->count;
            $total_count += $values->count;
            $stars++;
        }
        return '<p class="rating-average">'.round($average * 2 / $total_count, 1).'</p>';
    else :
        return '<p class="rating-average">'. __('No reviews yet', 'woocommerce').'</p>';
    endif;
}		

function display_products_rating_average() {
    return products_rating_average_html();
}
add_shortcode('products_rating_average', 'display_products_rating_average');

