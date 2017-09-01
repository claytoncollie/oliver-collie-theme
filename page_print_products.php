<?php
/**
 * Template Name: Print Products
 *
 * @author Clayton Collie
 * @package Oliver Collie
 */

//* Add landing body class to the head
add_filter( 'body_class', 'olivercollie_add_body_class' );
function olivercollie_add_body_class( $classes ) {
	$classes[] = 'print';
	return $classes;
}

// Remove header
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove cart icon
remove_filter( 'genesis_header', 'olivercollie_woocommerce_menu_item_show_cart', 12);

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove navigation
remove_action( 'genesis_header', 'genesis_do_nav', 11 );

// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add the page title
add_action( 'genesis_loop', 'olivercollie_header', 6 );
function olivercollie_header() {
	printf('<div class="header"><div class="left"><img src="%s"></div><div class="right"><h3 class="entry-title">%s</h3></div></div>',
		get_header_image(),
		get_the_title()
	);
}

// Remove newsletter
remove_action('genesis_before_footer', 'olivercollie_newsletter_signup', 8);

// Remove footer
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove the footer
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Add disclaimer from content area
add_action( 'genesis_footer', 'genesis_do_post_content', 5 );

// Add custom loop
add_action('genesis_loop', 'olivercollie_print_products');
function olivercollie_print_products() {
	
	global $query_args;

	$args = array(
		'post_type' 		=> 'product',
		'posts_per_page' 	=> '-1'
	);

	$products = new WP_Query($args);

	if( $products->have_posts() ) {

		echo '<article class="entry">';

			echo '<table id="wwof_product_listing_table">';
		        
		        printf('
		        	<thead>
			        	<tr>
				        	<th class="product_img_col">%s</th>
				        	<th class="product_title_col">%s</th>
				        	<th class="product_color_col">%s</th>
				            <th class="product_price_col">%s</th>
				            <th class="product_subtotal_col">%s</th>
			        	</tr>
		        	</thead>',
		        	esc_html__('Product'),
		        	esc_html__(''),
		        	esc_html__('Quantity'),
		        	esc_html__('Price'),
		        	esc_html__('Subtotal')
		        );

		       

	        	echo '<tbody>';

				while ( $products->have_posts() ) : $products->the_post();

					$product = wc_get_product( get_the_ID() );

		            echo '<tr>';

		                printf('<td class="product_img_col"><a class="product_link" href="%s">%s</a></td>',
			                $product->get_permalink(),
			                $product->get_image('medium')
			            );

			            printf('<td class="product_title_col">%s</td>',
			            	$product->get_title()
			            );

			            echo '<td class="product_color_col">';

				            if( $product->is_type('variable') ) {

				            	$product_v = new WC_Product_Variable( get_the_ID() );

					            $variations = $product_v->get_available_variations();

						        foreach( $variations as $key => $value ) {

						            printf('<span class="product_color">%s</span>',
						            	esc_html( $value['attributes']['attribute_pa_color'] )
						            );
						        }

						    }else{

					        	printf('<span class="product_color">%s</span>',
					            	esc_html__( 'As Pictured' )
					            );

					        }
			            
				        echo '</td>';

		                printf('<td class="product_price_col"><div class="variable_price"><span class="price"><span class="woocommerce-Price-amount amount">%s</span></span></div>
			                </td>',
			                $product->get_price_html()
		                );

		                printf('<td class="product_subtotal_col"></td>');

		            echo '</tr>'; 

				endwhile;

				echo '</tbody>';

			echo '</table>';

			echo '<table class="checkout">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Subtotal</th>';
						echo '<th>&nbsp;</th>';
						echo '<th>&nbsp;</th>';
						echo '<th>&nbsp;</th>';
						echo '<th>&nbsp;</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
					echo '<tr><td>Shipping</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
					echo '<tr><td>Tax (8.25% TX)</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
					echo '<tr><td><strong>Total</strong></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
					echo '<tr style="text-transform:uppercase;font-size:12px;"><td>&nbsp;</td><td>Invoice</td><td>Card</td><td>Cash</td><td>Check</td>';
					echo '</tr>';
				echo '</tbody>';
			echo '</table>';

		echo '</article>';

	}

	wp_reset_postdata();

}




add_action('genesis_loop', 'olivercollie_payment_information', 8);
function olivercollie_payment_information() {

	echo '<article class="entry">';

	printf('
	<table>
		<thead>
			<tr>
				<th>Company Name</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>

		</thead>

		<tbody>
			<tr>
				<td>TaxID/ASID/Reseller</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Customer Name</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Extension</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Billing Address</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Suite</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>City</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>State</td>
				<td>&nbsp;</td>
				<td>ZIP</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	');

	echo '</article>';
}

//* Run the Genesis loop
genesis();