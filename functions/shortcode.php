<?php


if ( function_exists( 'va_employees_display_employee' ) ) {
    function va_employees_shortcode( $atts ) {

        /**
         * Enque plugins styles and scripts in head if theme doesnt say it provides them
         */
        if ( !current_theme_supports('va-employees') ) {
            wp_enqueue_style( 'employees-styles', VA_EMPLOYEES_PLUGIN_URL . 'styles/employees-styles.css' );
        }

        ob_start();
     
        // define attributes and their defaults
        extract( shortcode_atts( array (
            'class' => '',
            'columns' => 1,
            'order' => 'asc',
            'orderby' => 'date',
            'posts' => -1,
            'ids' => array(),
        ), $atts ) );

        // Set columns_mobile variable
        if ( $columns < 3 ) {
            $columns_mobile = 1;
        } else {
            $columns_mobile = 2;
        }

        // Exlpode ids
        if ( $ids ) {
            $id_array = explode(',', $ids);
        } else {
            $id_array = '';
        }

        // define query parameters based on attributes
        $options = array(
            'post_type' => 'va-employees',
            'order' => $order,
            'orderby' => $orderby,
            'posts_per_page' => $posts,
            'post__in' => $id_array,
        );
        $query = new WP_Query( $options );

        // Loop
        if ( $query->have_posts() ) {
            echo '<div class="nested grid-' . $columns . '_md-' . $columns_mobile . '_sm-1">';

                while ( $query->have_posts() ) {

                    $query->the_post();

                    // file: functions/display-employee.php
                    va_employees_display_employee( $class );

                }

                wp_reset_postdata(); 

            echo '</div>';
        };

        $output = ob_get_clean();
        return $output;

    }
    add_shortcode( 'employees', 'va_employees_shortcode' );

}
