<?php

function va_employees_display_employee() {

    $post_id = get_the_ID();
    $client_name = get_post_meta( $post_id, 'client_name', true );
    $client_job = get_post_meta( $post_id, 'client_job', true );
    $company = get_post_meta( $post_id, 'company', true );
    $company_url = esc_url( get_post_meta( $post_id, 'company_url', true ) );
    $image = get_the_post_thumbnail_url( $post_id, 'thumbnail' );

    $output = '';
    $output .= '<div class="col testimonial"><div class="bubble">' . get_the_content() . '</div><div class="person">';
    if ( $image ) {
        $output .= '<img class="small" src="' . $image . '" />';
    }
    $output .= '<div>';
    $output .= $client_name;
    if ( $client_job || $company || $company_url ) {
        $output .= '<br />';
        $output .= '<small>';
    }
    $output .= $client_job;
    if ( $client_job && ( $company || $company_url ) ) {
        $output .= ' - ';
    }
    if ( $company && $company_url ) {
        $output .= '<a href="' . $company_url . '" target="_blank">' . $company . '</a>';
    } else if ( $company_url ) {
        $output .= '<a href="' . $company_url . '" target="_blank">' . $company_url . '</a>';
    } else if ( $company ) {
        $output .= $company;
    }
    $output .= '</div>';
    if ( $client_job || $company || $company_url ) {
        $output .= '</small>';
    }
    $output .= '</div></div>';
    echo $output;

}
