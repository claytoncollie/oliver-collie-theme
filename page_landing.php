<?php
/**
 * This file adds the Landing page template to Oliver Collie.
 *
 * @author Clayton Collie
 * @package Oliver Collie
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'olivercollie_add_body_class' );
function olivercollie_add_body_class( $classes ) {
	$classes[] = 'landing';
	return $classes;
}

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove navigation
remove_action( 'genesis_header', 'genesis_do_nav', 11 );

// Remove newsletter
remove_action('genesis_before_footer', 'olivercollie_newsletter_signup', 8);

// Remove footer
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Run the Genesis loop
genesis();