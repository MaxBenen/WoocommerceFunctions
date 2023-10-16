
function custom_review_form_shortcode($atts) 
    ob_start();
    ?>


    <form id="custom-review-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="custom_review_form_submission">
        <input type="hidden" name="custom_review_form_nonce" value="<?php echo wp_create_nonce('custom_review_form_nonce'); ?>" />

        <label for="product-select">Selecteer uw product*</label>
        <select name="product_id" id="product-select">
            <?php
            $products = get_posts(array('post_type' => 'product', 'posts_per_page' => -1));
            foreach ($products as $product) {
                echo '<option value="' . $product->ID . '">' . $product->post_title . '</option>';
            }
            ?>
        </select>
		
		<label for="rating">Hoeveel aantal sterren geeft u het product*</label>
        <select name="rating" id="rating" required>
            <option value="5">5 Sterren</option>
            <option value="4">4 Sterren</option>
            <option value="3">3 Sterren</option>
            <option value="2">2 Sterren</option>
            <option value="1">1 Ster</option>
        </select>

        <label for="name">Uw naam*</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Uw e-mailadres</label>
        <input type="email" name="email" id="email">

        <label for="comment">Schrijf uw ervaring met het aangekochte product*</label>
        <textarea name="comment" id="comment" required></textarea>

        <?php
        // Include the WooCommerce review form
        comments_template('woocommerce/single-product-reviews.php');
        ?>

        <input type="submit" value="VERSTUREN" onclick="showThankYouAlert()">
    </form>



	
    <script type="text/javascript">
        // Check for the 'success' parameter in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');

        // Show the alert if the 'success' parameter is present
        if (successParam === '1') {
            window.onload = function() {
                alert('Bedankt voor uw review');
            };
        }
    </script>



    <?php
    return ob_get_clean();


add_shortcode('custom_review_form', 'custom_review_form_shortcode');

// Form submission handling
add_action('admin_post_nopriv_custom_review_form_submission', 'handle_custom_review_form_submission');
add_action('admin_post_custom_review_form_submission', 'handle_custom_review_form_submission');

function handle_custom_review_form_submission() {
    // Verify nonce
    if (isset($_POST['custom_review_form_nonce']) && wp_verify_nonce($_POST['custom_review_form_nonce'], 'custom_review_form_nonce')) {
        // Get form data
        $product_id = $_POST['product_id'];
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $rating = intval($_POST['rating']);
        $comment = sanitize_text_field($_POST['comment']);

        // Prepare review data
        $review_data = array(
            'comment_post_ID' => $product_id,
            'comment_author' => $name,
            'comment_author_email' => $email,
            'comment_content' => $comment,
            'user_id' => 0, // Guest user
            'comment_approved' => 1, // Auto-approve the comment
        );

        // Insert the review into the database
        $comment_id = wp_insert_comment($review_data);

        // Set the rating for the review
        add_comment_meta($comment_id, 'rating', $rating);
		

		
        // Redirect users after form submission (change the URL as needed)
        wp_redirect(home_url('/review?success=1')); // Redirect to a thank you page
        exit;
    } else {
        // Nonce verification failed, handle the error appropriately (e.g., redirect to an error page)
        wp_redirect(home_url('/error')); // Redirect to an error page
        exit;
    }
}