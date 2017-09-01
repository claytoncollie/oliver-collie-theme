<?php
/**
 * Unregister certain genesis defaults
 * 
 * @author     Clayton Collie
 * @link       http://www.olivercollie.com
 *
 */

//Remove Genesis User meta fields
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );

 
//Remove genesis script support
remove_post_type_support( 'post', 'genesis-scripts' );	// Posts
remove_post_type_support( 'page', 'genesis-scripts' );	// Pages

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

//* Remove Genesis Layout Settings
remove_theme_support( 'genesis-inpost-layouts' );

//* Unregister content/sidebar layout setting
genesis_unregister_layout( 'content-sidebar' );

//* Unregister sidebar/content layout setting
genesis_unregister_layout( 'sidebar-content' );

//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );

//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister full-width content layout setting
//* genesis_unregister_layout( 'full-width-content' );

// Remove Genesis Page Templates
add_filter( 'theme_page_templates', 'olivercollie_remove_genesis_page_templates' );
function olivercollie_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

//* Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

//* Unregister primary sidebar
unregister_sidebar( 'sidebar' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'olivercollie_entry_meta_header' );
function olivercollie_entry_meta_header($post_info) {
    $post_info = '[post_date]';
    return $post_info;
}

// Reposition post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'olivercollie_content_limit_read_more_markup', 10, 3 );
function olivercollie_content_limit_read_more_markup( $output, $content, $link ) {
    $output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );
    return $output;
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'olivercollie_read_more_link' );
function olivercollie_read_more_link() {
    $output = sprintf('<a class="more-link" href="%s">%s</a>',
        get_permalink(),
        esc_html__('Continue Reading', 'olivercollie')
    );
    return $output;
}

// Remvoe entry meta
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

// Filter out the site footer credits
add_filter( 'genesis_footer_output', 'olivercollie_footer_creds_filter' );
function olivercollie_footer_creds_filter( $credits ) {    
    $credits = sprintf('<div class="credits"><span class="copyright">%s %s</span><span style="margin: 0 10px;">|</span><span class="title">%s</span><span style="margin: 0 10px;">|</span><span class="login">%s</span></div>',
        '[footer_copyright]',
        esc_html__('All Rights Reserved', 'olivercollie'),
        esc_html( get_bloginfo('name') ),
        do_shortcode( '[footer_loginout]' )
    );
    return  $credits;
}