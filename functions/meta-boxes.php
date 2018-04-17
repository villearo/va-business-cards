<?php

function va_employees_add_meta_box() {
    add_meta_box(
        'employee-details',                         // The HTML id attribute for the metabox section
        __('Employee Details', 'va-employees'),   // The title of metabox section
        'va_employees_meta_box_callback',           // The metabox callback function
        'va-employees',                             // Your custom post type slug
        'normal',                                   // Position can be 'normal', 'side', and 'advanced'
        'default'                                   // Priority can be 'high' or 'low'
    );
}
add_action( 'add_meta_boxes', 'va_employees_add_meta_box' );

function va_employees_meta_box_callback( $post ) {
    $post_id = get_post_custom( $post->ID );
    $employee_job = isset( $post_id['employee_job'] ) ? esc_attr( $post_id['employee_job'][0] ) : "";
    $employee_email = isset( $post_id['employee_email'] ) ? esc_attr( $post_id['employee_email'][0] ) : "";
    $employee_phone = isset( $post_id['employee_phone'] ) ? esc_attr( $post_id['employee_phone'][0] ) : "";
    $employee_website_url = isset( $post_id['employee_website_url'] ) ? esc_url( $post_id['employee_website_url'][0] ) : "";
    wp_nonce_field( 'employee_details_nonce_action', 'employee_details_nonce' );
    echo '<label>' . __('Employee Job', 'va-employees') . '</label><br/><input type="text" name="employee_job" id="employee_job" size="100" value="'. $employee_job .'" /><br/>';
    echo '<label>' . __('Employee Email', 'va-employees') . '</label><br/><input type="text" name="employee_email" id="employee_email" size="100" value="'. $employee_email .'" /><br/>';
    echo '<label>' . __('Employee Phone', 'va-employees') . '</label><br/><input type="text" name="employee_phone" id="employee_phone" size="100" value="'. $employee_phone .'" /><br/>';
    echo '<label>' . __('Employee Website URL', 'va-employees') . '</label><br/><input type="text" name="employee_website_url" id="employee_website_url" size="100" value="'. esc_url( $employee_website_url ) .'" /><br/>';
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
 
    if( isset( $_POST['employee_job'] ) ) {
        update_post_meta( $post_id, 'employee_job', $_POST['employee_job']);
    }

    if( isset( $_POST['employee_email'] ) ) {
        update_post_meta( $post_id, 'employee_email', $_POST['employee_email']);
    }
 
    if( isset( $_POST['employee_phone'] ) ) {
        update_post_meta( $post_id, 'employee_phone', $_POST['employee_phone']);
    }

    if( isset( $_POST['employee_website_url'] ) ) {
        update_post_meta( $post_id, 'employee_website_url', esc_url( $_POST['employee_website_url'] ) );
    }

}
add_action( 'save_post', 'va_employees_save_meta_box' );
