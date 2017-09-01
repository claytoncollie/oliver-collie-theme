<?php
/**
 * This file adds the Whoelsale page template to Oliver Collie.
 *
 * @author Clayton Collie
 * @package Oliver Collie
 */

/*
Template Name: Flexible
*/

//* Add landing body class to the head
add_filter( 'body_class', 'olivercollie_add_body_class' );
function olivercollie_add_body_class( $classes ) {
	$classes[] = 'flex';
	return $classes;
}

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove newsletter
remove_action('genesis_before_footer', 'olivercollie_newsletter_signup', 8);

// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom loop
add_action( 'genesis_after_header', 'oc_quick_links');
function oc_quick_links() {

	$register_text = get_field('oc_register_text');
	$register_page = get_field('oc_register_page');

	$login_text = get_field('oc_login_text');
	$login_page = get_field('oc_login_page');

	if( ($register_text && $register_page) || ($login_text && $login_page) ) {		
		echo '<section class="quick-links">';

			if( $register_text && $register_page) {
				printf('<article class="first one-half"><a href="%s" class="button">%s  %s</a></article>',
					get_the_permalink( $register_page ),
					'<i class="icon ion-person-add"></i>',
					wp_kses_post($register_text)
				);
			}

			if( $login_text && $login_page) {
				printf('<article class="one-half"><a href="%s" class="button">%s  %s</a></article>',
					get_the_permalink( $login_page ),
					'<i class="icon ion-log-in"></i>',
					wp_kses_post($login_text)
				);
			}

			echo '<div class="clearfix"></div>';
		echo '</section>';
	}
}

add_action( 'genesis_after_header', 'oc_flexible_content_layout' );
function oc_flexible_content_layout() {
	if( have_rows('oc_flexible_content') ):
	    while ( have_rows('oc_flexible_content') ) : the_row();

	        if( get_row_layout() == 'oc_flex_full_width_content' ):

	        	$full_wdith_content = get_sub_field('oc_flex_full_width_content_wysiwyg');

	        	if( $full_wdith_content ) {
	        		printf('<div class="flex-row full-width-content entry">%s</div>',
	        			wp_kses_post($full_wdith_content)
	        		);
	        	}

	       	endif;

	        if( get_row_layout() == 'oc_flex_narrow_content' ): 

	        	$narrow_content = get_sub_field('oc_flex_narrow_content_wysiwyg');

	        	if( $narrow_content ) {
	        		printf('<div class="flex-row narrow-content entry">%s</div>',
	        			wp_kses_post($narrow_content)
	        		);
	        	}

	        endif;

	        if( get_row_layout() == 'oc_flex_image_and_content' ): 

	        	$image_content_left = get_sub_field('oc_flex_image_content_left');
	        	$image_content_right = get_sub_field('oc_flex_image_content_right');

	        	if( $image_content_left && $image_content_right ) {	        		
	        		printf('<div class="flex-row image-content"><div class="first one-half">%s</div><div class="one-half entry">%s</div><div class="clearfix"></div></div>',
	        			wp_get_attachment_image( $image_content_left, 'olivercollie_archive' ),
	        			wp_kses_post($image_content_right)
	        		);
	        	}

	        endif;

	        if( get_row_layout() == 'oc_flex_content_and_image' ): 

	        	$content_image_left = get_sub_field('oc_flex_content_image_left');
	        	$content_image_right = get_sub_field('oc_flex_content_image_right');

	        	if( $content_image_left && $content_image_right ) {	        		
	        		printf('<div class="flex-row content-image"><div class="first one-half entry">%s</div><div class="one-half">%s</div><div class="clearfix"></div></div>',
	        			wp_kses_post($content_image_left),
	        			wp_get_attachment_image( $content_image_right, 'olivercollie_archive' )
	        		);
	        	}

	        endif;

	        if( get_row_layout() == 'oc_flex_full_width_image' ): 

	        	$full_width_image = get_sub_field('oc_flex_full_width_image_field');

	        	if( $full_width_image ) {
	        		printf('<div class="flex-row full-width-image">%s</div>',
	        			wp_get_attachment_image( $full_width_image, 'olivercollie_wide' )
	        		);
	        	}

	        endif;
	    endwhile;
	endif;
}


//* Run the Genesis loop
genesis();