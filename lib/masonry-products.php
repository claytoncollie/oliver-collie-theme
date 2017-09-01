<?php
/*
* Loop for woo commerce products with masonry layout via jQuery
*/
function olivercollie_masonry_products() {

    $loop = new WP_Query( array(
        'posts_per_page' => 20,
        'post_type'      => 'product',
    ) );

    if( $loop->have_posts() ) {

        echo '<ul class="masonry-grid">';
        
        while( $loop->have_posts() ) {

            $loop->the_post(); 

            olivercollie_masonry_product();

        }

        echo '</ul>';

    }

    wp_reset_postdata();

}

function olivercollie_masonry_product() {

    global $product;

    $price = get_post_meta( get_the_ID(), '_regular_price', true);

    ?>

    <li class="masonry-item hovereffect">
        <a href="<?php the_permalink(); ?>" rel="bookmark">
            <?php if( has_post_thumbnail() ) {
                the_post_thumbnail( 'masonry', 
                    array(
                        'class' => 'post-image', 
                        'alt' => get_the_title() 
                    )
                );
            } ?>

            <div class="overlay">
                <h3 class="product-title"><?php the_title(); ?></h3>
                <p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
            </div>
        </a>
    </li>

    <?php

}