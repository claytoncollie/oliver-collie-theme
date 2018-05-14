<?php
/* ==========================================================================
 * Theme Setup
 * ========================================================================== */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Widgets
require_once( get_stylesheet_directory() . '/lib/widget-products.php' );

//* Widgets
require_once( get_stylesheet_directory() . '/lib/masonry-products.php' );

//* Genesis Specific Functions
require_once( get_stylesheet_directory() . '/lib/functions-genesis.php' );

//* WooCommerce Specific Functions
//require_once( get_stylesheet_directory() . '/lib/functions-woocommerce.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Oliver Collie' );
define( 'CHILD_THEME_URL', 'http://www.olivercollie.com' );
define( 'CHILD_THEME_VERSION', '1.3.72' );
define( 'CHILD_THEME_DOMAIN', 'olivercollie' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'olivercollie_scripts_styles' );
function olivercollie_scripts_styles() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Martel:200,700,900|Roboto+Condensed:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'woocommerce', get_stylesheet_directory_uri() . '/style-woocommerce.css', array(), CHILD_THEME_VERSION );	
	wp_enqueue_script( 'masonry','', array( 'jquery' ), CHILD_THEME_VERSION, true );
  	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.min.js', array( 'jquery', 'masonry'), CHILD_THEME_VERSION, true );
}

//* Force full-width-content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

// Add structural wraps to sections
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// WooCommerce Support
add_theme_support( 'genesis-connect-woocommerce' );

//* Add support for 4-column footer widget
add_theme_support( 'genesis-footer-widgets', 4 );

/* ==========================================================================
 * Header
 * ========================================================================== */

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 244,
	'height'          => 80,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add Image Sizes
add_image_size( 'olivercollie_archive', 800, 525, TRUE );
add_image_size( 'olivercollie_wide', 1600, 350, TRUE );
add_image_size( 'olivercollie_large', 1600, 700, TRUE );
add_image_size( 'portfolio', 800, 600, TRUE );
add_image_size( 'masonry', 400, 0, FALSE );

// Add image size to drop down
add_filter( 'image_size_names_choose', 'olivercollie_image_size_names', 11, 1 );
function olivercollie_image_size_names( $sizes ) {
    $sizes['olivercollie_wide'] = _( 'Wide' );
    $sizes['olivercollie_wide'] = _( 'Very Large' );
    return $sizes;
}

/* ==========================================================================
 * Navigation
 * ========================================================================== */

//* Rename primary and secondary navigation menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'Header Menu', CHILD_THEME_DOMAIN ) ) );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

/* ==========================================================================
 * Widget Areas
 * ========================================================================== */

//* Setup widget counts
function olivercollie_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function olivercollie_widget_area_class( $id ) {

	$count = olivercollie_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves even';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

// Newsletter signup form
add_action('genesis_before_footer', 'olivercollie_newsletter_signup', 8 );
function olivercollie_newsletter_signup() {
	
	if( is_active_sidebar('before-newsletter') && !is_singular('product') ) {
		genesis_widget_area( 'before-newsletter', array(
			'before' => '<div class="before-newsletter"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	if( is_active_sidebar('before-footer') && !is_singular('product') ) {
		genesis_widget_area( 'before-footer', array(
			'before' => '<div class="before-footer"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	if( is_active_sidebar('after-newsletter') && !is_singular('product') ) {
		genesis_widget_area( 'after-newsletter', array(
			'before' => '<div class="after-newsletter"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}
}

/* ==========================================================================
 * Register Widget Areas
 * ========================================================================== */
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1: Slider', CHILD_THEME_DOMAIN )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-intro',
	'name'        => __( 'Front Page 1: Intro', CHILD_THEME_DOMAIN )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2: Flexible Widgets ', CHILD_THEME_DOMAIN ),
	'description' => __( 'Widgets have white background.', CHILD_THEME_DOMAIN )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3: Featured Products', CHILD_THEME_DOMAIN ),
	'description' => __( 'Masonry layout with custom widget.', CHILD_THEME_DOMAIN )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4: Upcoming Events', CHILD_THEME_DOMAIN )
) );
genesis_register_sidebar( array(
	'id'          => 'before-newsletter',
	'name'        => __( 'Before Newsletter', CHILD_THEME_DOMAIN ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', CHILD_THEME_DOMAIN ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-newsletter',
	'name'        => __( 'After Newsletter', CHILD_THEME_DOMAIN ),
) );

/* ==========================================================================
 * Plugin Filters
 * ========================================================================== */
//add_filter( 'wwlc_filter_registration_form_login_control', '__return_false' );
//add_filter( 'wwlc_filter_registration_form_lost_password_control', '__return_false' );

//add_filter( 'woocommerce_return_to_shop_redirect', 'oc_return_to_shop_redirect' );
function oc_return_to_shop_redirect(){
    if( is_user_logged_in() && current_user_can('wholesale_customer' ) ){
		return site_url( '/wholesale-ordering/', 'https' );
    }
}

//add_action( 'template_redirect', 'oc_redirect_wholesale_customer' );
function oc_redirect_wholesale_customer() {
	if( ( is_page('wholesale') || is_page('wholesale-login') ) && is_user_logged_in() && current_user_can('wholesale_customer' ) ) {
		wp_redirect( site_url( '/wholesale-ordering/', 'https' ) );
		exit;
	}
}