<?php

/**
 * Widget to display objects from custom post type - product
 * 
 * @author     Clayton Collie
 * @link       http://www.olivercollie.com
 *
 */

add_action( 'widgets_init', 'olivercollie_register_masonry_widget');
function olivercollie_register_masonry_widget() {
    register_widget('olivercollie_Widget_product');
}

class olivercollie_Widget_product extends WP_Widget {

    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @since 1.0.0
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    function __construct() {

        // widget defaults
        $this->defaults = array(
            'title'          => '',
        );

        // Widget Slug
        $widget_slug = 'olivercollie-widget-product';

        // widget basics
        $widget_ops = array(
            'classname'   => $widget_slug,
            'description' => 'Widget to display objects from custom post type - product'
        );

        // widget controls
        $control_ops = array(
            'id_base' => $widget_slug,
            'width'   => '400',
        );

        // load widget
        parent::__construct( $widget_slug, 'WooCommerce Masonry Products Grid (10)', $widget_ops, $control_ops );

    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @since 1.0.0
     * @param array $instance An array of the current settings for this widget
     */
    function form( $instance ) {

        // Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>
        <?php
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @since 1.0.0
     * @param array $new_instance An array of new settings as submitted by the admin
     * @param array $old_instance An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        
        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @since 1.0.0
     * @param array $args An array of standard parameters for widgets in this theme
     * @param array $instance An array of settings for this widget instance
     */
    function widget( $args, $instance ) {

        extract( $args );

        $instance = wp_parse_args( (array) $instance, $this->defaults );

        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        echo $before_widget;

        olivercollie_masonry_products();

        echo $after_widget;

    }

}