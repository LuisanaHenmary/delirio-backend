<?php

function wp_check_permission()
{
    return current_user_can('edit_posts');
}

function check_user_rol()
{
    $user = wp_get_current_user();
    $is_admin = in_array('administrator', (array) $user->roles);
    $is_employer = in_array('employer', (array) $user->roles);
    $is_company = in_array('company', (array) $user->roles);

    if ($is_admin) {
        return new WP_REST_Response(array('role' => 'admin'), 200);
    }

    if ($is_employer) {
        return new WP_REST_Response(array('role' => 'employer'), 200);
    }

    if ($is_company) {
        return new WP_REST_Response(array('role' => 'company'), 200);
    }

    return new WP_REST_Response(array('role' => 'subscriptor'), 200);
}
