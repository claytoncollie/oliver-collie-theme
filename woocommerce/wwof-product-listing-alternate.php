<?php
/**
 * The template for displaying product listing
 *
 * Override this template by copying it to yourtheme/woocommerce/wwof-product-listing.php
 *
 * @author 		Rymera Web Co
 * @package 	WooCommerceWholeSaleOrderForm/Templates
 * @version     1.3.0
 */

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// NOTE: Don't Remove any ID or Classes inside this template when overriding it.
// Some JS Files Depend on it. You are free to add ID and Classes without any problem. ?>

<div id="wwof_product_listing_table_container" style="position: relative;">
    <table id="wwof_product_listing_table">
        <thead>
        <tr>
            <th><?php _e( 'Product' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th class="<?php echo $product_listing->wwof_get_product_sku_visibility_class(); ?>"><?php _e( 'SKU' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th><?php _e( 'Price' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th class="<?php echo $product_listing->wwof_get_product_stock_quantity_visibility_class(); ?>"><?php _e( 'Stock Quantity' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th><?php _e( 'Quantity' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th><?php _e( 'Product' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th class="<?php echo $product_listing->wwof_get_product_sku_visibility_class(); ?>"><?php _e( 'SKU' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th><?php _e( 'Price' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th class="<?php echo $product_listing->wwof_get_product_stock_quantity_visibility_class(); ?>"><?php _e( 'Stock Quantity' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th><?php _e( 'Quantity' , 'woocommerce-wholesale-order-form' ); ?></th>
            <th></th>
        </tr>
        </tfoot>
        <tbody><?php

        $_REQUEST[ 'tab_index_counter' ] = 1;
        $thumbnailSize = $product_listing->wwof_get_product_thumbnail_dimension();

        if ( $product_loop->have_posts() ) {

            while ( $product_loop->have_posts() ) { $product_loop->the_post();
                
                $post_id = get_the_ID();
                $product = wc_get_product( $post_id ); 

                if( WWOF_Functions::wwof_get_product_type( $product ) == 'grouped' )
                    continue;
                else{ ?>

                    <tr>
                        <td class="product_meta_col" style="display: none !important;">
                            <?php echo $product_listing->wwof_get_product_meta( $product ); ?>
                        </td>
                        <td class="product_title_col">
                            <?php echo $product_listing->wwof_get_product_image( $product , get_the_permalink( $post_id ) , $thumbnailSize ); ?>
                            <?php echo $product_listing->wwof_get_product_title( $product , get_the_permalink( $post_id ) ); ?>
                            <?php echo $product_listing->wwof_get_product_variation_field( $product ); ?>
                            <?php echo $product_listing->wwof_get_product_addons( $product ); ?>
                        </td>
                        <td class="product_sku_col <?php echo $product_listing->wwof_get_product_sku_visibility_class(); ?>">
                            <?php echo $product_listing->wwof_get_product_sku( $product ); ?>
                        </td>
                        <td class="product_price_col">
                            <?php echo $wholesale_prices->wwof_get_product_price( $product ); ?>
                        </td>
                        <td class="product_stock_quantity_col <?php echo $product_listing->wwof_get_product_stock_quantity_visibility_class(); ?>">
                            <?php echo $product_listing->wwof_get_product_stock_quantity( $product ); ?>
                        </td>
                        <td class="product_quantity_col">
                            <?php echo $wholesale_prices->wwof_get_product_quantity_field( $product ); ?>
                        </td>
                        <td class="product_row_action">
                            <?php echo $product_listing->wwof_get_product_row_action_fields( $product , true ); ?>
                        </td>
                    </tr><?php

                }
                
                $_REQUEST[ 'tab_index_counter' ] += 1;
                
            }// End while loop

        } else { ?>

            <tr class="no-products">
                <td colspan="4">
                    <span><?php _e( 'No Products Found' , 'woocommerce-wholesale-order-form' ); ?></span>
                </td>
            </tr><?php 

        } ?>

        </tbody>
    </table><!--#wwof_product_listing_table-->
</div><!--#wwof_product_listing_table_container-->

<div id="wwof_product_listing_pagination">

    <div class="bottom_list_actions">

        <input type="button" id="wwof_bulk_add_to_cart_button" class="btn btn-primary button alt" value="<?php _e( 'Add Selected Products To Cart' , 'woocommerce-wholesale-order-form' ); ?>"/>
        <span class="spinner"></span>

        <div class="products_added">
            <p><b></b><?php _e( ' Product/s Added' , 'woocommerce-wholesale-order-form' ); ?></p>
        </div>

        <div class="view_cart">
            <a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php _e( 'View Cart &rarr;' , 'woocommerce-wholesale-order-form' ); ?></a>
        </div>

    </div>

    <?php echo $product_listing->wwof_get_cart_subtotal(); ?>

    <?php
	if( strpos($product_listing->wwof_get_cart_subtotal(), 'Cart Empty') == false ){
	    ?>
	    <div class="wwof_cart_sub_total view-cart">
	    	<a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php _e( 'View Cart &rarr;' , 'woocommerce-wholesale-order-form' ); ?></a>
	    </div>
	    <?php
	}
	?>

    <div class="total_products_container">
        <span class="total_products"><?php
            echo sprintf( __( '%1$s Product/s Found' , 'woocommerce-wholesale-order-form' ) , $product_loop->found_posts ); ?>
        </span>
    </div>

    <?php echo $product_listing->wwof_get_gallery_listing_pagination( $paged , $product_loop->max_num_pages , $search , $cat_filter ); ?>

</div><!--#wwof_product_listing_pagination-->