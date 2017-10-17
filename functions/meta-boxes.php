<?php

function va_employees_add_meta_box() {
    add_meta_box(
        'employee-details',                 // The HTML id attribute for the metabox section
        'Employee Details',                 // The title of metabox section
        'va_employees_meta_box_callback',   // The metabox callback function
        'va-employees',                     // Your custom post type slug
        'normal',                           // Position can be 'normal', 'side', and 'advanced'
        'default'                           // Priority can be 'high' or 'low'
    );
}
add_action( 'add_meta_boxes', 'va_employees_add_meta_box' );

function va_employees_meta_box_callback( $post ) {
    $post_id = get_post_custom( $post->ID );
    $client_name = isset( $post_id['client_name'] ) ? esc_attr( $post_id['client_name'][0] ) : "";
    $client_job = isset( $post_id['client_job'] ) ? esc_attr( $post_id['client_job'][0] ) : "";
    $company = isset( $post_id['company'] ) ? esc_attr( $post_id['company'][0] ) : "";
    $company_url = isset( $post_id['company_url'] ) ? esc_url( $post_id['company_url'][0] ) : "";
    wp_nonce_field( 'employee_details_nonce_action', 'employee_details_nonce' );
    echo '<label>Client Name</label><br/><input type="text" name="client_name" id="client_name" size="100" value="'. $client_name .'" /><br/>';
    echo '<label>Client Job</label><br/><input type="text" name="client_job" id="client_job" size="100" value="'. $client_job .'" /><br/>';
    echo '<label>Company</label><br/><input type="text" name="company" id="company" size="100" value="'. $company .'" /><br/>';
    echo '<label>Company URL</label><br/><input type="text" name="company_url" id="company_url" size="100" value="'. esc_url( $company_url ) .'" /><br/>';
}

function va_employees_save_meta_box( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['employee_details_nonce'] ) ) {
        return;
    }

    $nonce = $_POST['employee_details_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'employee_details_nonce_action' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
 
    if( isset( $_POST['client_name'] ) ) {
        update_post_meta( $post_id, 'client_name', $_POST['client_name']);
    }

    if( isset( $_POST['client_job'] ) ) {
        update_post_meta( $post_id, 'client_job', $_POST['client_job']);
    }
 
    if( isset( $_POST['company'] ) ) {
        update_post_meta( $post_id, 'company', $_POST['company']);
    }

    if( isset( $_POST['company_url'] ) ) {
        update_post_meta( $post_id, 'company_url', esc_url( $_POST['company_url'] ) );
    }

}
add_action( 'save_post', 'va_employees_save_meta_box' );
