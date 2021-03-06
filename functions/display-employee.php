<?php

function va_employees_display_employee( $post_id, $class ) {

    $employee_job = get_post_meta( $post_id, 'employee_job', true );
    $employee_email = get_post_meta( $post_id, 'employee_email', true );
    $employee_phone = get_post_meta( $post_id, 'employee_phone', true );
    $employee_website_url = esc_url( get_post_meta( $post_id, 'employee_website_url', true ) );
    $image = get_the_post_thumbnail_url( $post_id, 'medium' );
    $title = get_the_title($post_id);

    $output = '<div class="col">';

        $output .= '<div class="employee '. $class . '">';

            if ( $image ) {
                $output .= '<img src="' . $image . '" />';
            }

            $output .= '<div class="info">';
                $output .= '<h4>' . $title . '</h4>';

                if ( $employee_job ) {
                    $output .= '<div class="job">' . $employee_job . '</div>';
                }

                if ( $employee_email ) {
                    $output .= '<div class="email">' . antispambot($employee_email) . '</div>';
                }

                if ( $employee_phone ) {
                    $output .= '<div class="phone">' . $employee_phone . '</div>';
                }

                if ( $employee_website_url ) {
                    $output .= '<a href="' . $employee_website_url . '" target="_blank">' . $employee_website_url . '</a>';
                }
            $output .= '</div>'; // Close .info

        $output .= '</div>'; // Close .employee

    $output .= '</div>'; // Close .col

    return $output;

}
