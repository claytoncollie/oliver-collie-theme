<?php
/*
* Woo Commerce speciifc functions
*/

// Wholesale plugin
add_filter( 'wwlc_filter_registration_form_login_control', '__return_false' );
add_filter( 'wwlc_filter_registration_form_lost_password_control', '__return_false' );


// shop redirect
add_filter( 'woocommerce_return_to_shop_redirect', 'oc_return_to_shop_redirect' );
add_action( 'template_redirect', 'oc_redirect_wholesale_customer' );

// Remove sidebar from all woo commerce pages
add_filter( 'genesis_site_layout', 'olivercollie_woocommerce_layout' );

// Add cart totals to menu bar
add_filter( 'genesis_header', 'olivercollie_woocommerce_menu_item_show_cart', 12);

// Remove title
//add_filter('woocommerce_show_page_title','__return_false');

// Remove post count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove sorting select field
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// Remove SKU in single-product
add_filter( 'wc_product_sku_enabled', '__return_false' );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 25 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display', 15 );
add_action('woocommerce_after_single_product','woocommerce_upsell_display', 15 );

add_action('genesis_meta','olivercollie_cart');

add_filter( 'woocommerce_get_availability', 'olivercollie_custom_availability', 5, 2);

add_action( 'woocommerce_before_single_product_summary', 'oc_sale_banner_product_cat', 8 );

// Helpers
//=================================================================================


function oc_return_to_shop_redirect(){
    if( is_user_logged_in() && current_user_can('wholesale_customer' ) ){
		return site_url( '/wholesale-ordering/', 'https' );
    }else{
    	return site_url( '/shop/', 'https' );
    }
}

function oc_redirect_wholesale_customer() {
	if( ( is_page('wholesale') || is_page('wholesale-login') ) && is_user_logged_in() && current_user_can('wholesale_customer' ) ) {
		wp_redirect( site_url( '/wholesale-ordering/', 'https' ) );
		exit;
	}
}

function oc_sale_banner_product_cat() {

	$terms = get_the_terms( get_the_ID(), 'product_cat');

    if ( $terms && ! is_wp_error( $terms ) ) {
 
        $classes = array();
        $names = array();
 
        foreach ( $terms as $term ) {
            $classes[] = 'product_cat-'.$term->slug;
            $names[] = $term->name;
        }

        printf('<div class="sale-banner %s">%s</div>',
			implode(' ', $classes),
			implode(' ', $names)
		);

    }
    
}


function olivercollie_woocommerce_layout() {
    if( is_page ( array( 'cart', 'checkout' )) || is_shop() || 'product' == get_post_type() ) {
        return 'full-width-content';
    }
}

function olivercollie_woocommerce_menu_item_show_cart() {

	global $woocommerce;

	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
		return;

	$viewing_cart 			= __( 'View your shopping cart', CHILD_THEME_DOMAIN );
	$start_shopping 		= __( 'Start shopping', CHILD_THEME_DOMAIN );
	$cart_url 				= $woocommerce->cart->get_cart_url();
	$shop_page_url 			= get_permalink( woocommerce_get_page_id( 'shop' ) );
	$cart_contents_count 	= $woocommerce->cart->cart_contents_count;
	$cart_contents 			= sprintf(_n('<span class="cart-count">%d</span>', '<span class="cart-count">%d</span>', $cart_contents_count, CHILD_THEME_DOMAIN ), $cart_contents_count);

	if ($cart_contents_count == 0) {

		$menu_item = '<div class="cart"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';

	} else {

		$menu_item = '<div class="cart"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';

		$menu_item .= $cart_contents;

	}

	$menu_item .= '<i class="icon ion-ios-cart-outline"></i>';

	$menu_item .= '</a></div>';

	echo $menu_item;

}

function olivercollie_cart() {
	if( is_cart() || is_checkout() ) {
		remove_action( 'genesis_header', 'genesis_do_nav', 11 );
		remove_action('genesis_before_footer', 'olivercollie_newsletter_signup', 8);
		remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
		remove_action('genesis_footer','genesis_do_footer');
	}
}


function olivercollie_custom_availability( $availability, $_product ) {
	if ( !$_product->is_in_stock() ) {
		$availability['availability'] = __('This piece is currently sold out.', 'woocommerce');
	}
	return $availability;
}