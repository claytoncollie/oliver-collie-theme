<?php
/**
 * This file adds the Front Page to Oliver Collie.
 *
 * @author Clayton Collie
 * @package Oliver Collie
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'olivercollie_front_page_genesis_meta' );
function olivercollie_front_page_genesis_meta() {

	//* Add front-page body class
	add_filter( 'body_class', 'olivercollie_body_class' );
	function olivercollie_body_class( $classes ) {
		$classes[] = 'front-page';
		return $classes;
	}

	//* Force full width content layout
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	//* Remove breadcrumbs
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

	//* Add widgets on front page
	add_action( 'genesis_after_header', 'olivercollie_front_page_widgets' );

	//* Remove the default Genesis loop
	remove_action( 'genesis_loop', 'genesis_do_loop' );

	//* Remove .site-inner
	add_filter( 'genesis_markup_site-inner', '__return_null' );
	add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
	add_filter( 'genesis_markup_content', '__return_null' );
	add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

}

//* Add widgets on front page
function olivercollie_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'olivercollie' ) . '</h2>';

	if( is_active_sidebar('front-page-1') ) {

		genesis_widget_area( 'front-page-1', array(
			'before' => '<div class="front-page-1"><div class="wrap"><div class="widget-area">',
			'after'  => '</div></div></div>',
		) );

	}

	if( is_active_sidebar('front-page-intro') ) {

		genesis_widget_area( 'front-page-intro', array(
			'before' => '<div class="front-page-intro"><div class="wrap">',
			'after'  => '</div></div>',
		) );

	}

	if( is_active_sidebar('front-page-2') ) {

		genesis_widget_area( 'front-page-2', array(
			'before' => '<div class="front-page-2 flexible-widget-area"><div class="wrap"><div class="flexible-widgets two-thirds only ' . olivercollie_widget_area_class( 'front-page-2' ) . '"">',
			'after'  => '</div></div></div>',
		) );

	}

	if( is_active_sidebar('front-page-3') ) {

		genesis_widget_area( 'front-page-3', array(
			'before' => '<div class="front-page-3"><div class="widget-area">',
			'after'  => '</div></div>',
		) );

	}

	if( is_active_sidebar('front-page-4') ) {

		genesis_widget_area( 'front-page-4', array(
			'before' => '<div class="front-page-4"><div class="wrap"><div class="widget-area">',
			'after'  => '</div></div></div>',
		) );

	}

}

//* Run the Genesis function
genesis();
