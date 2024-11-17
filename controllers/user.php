<?php

function wp_check_permission()
{
    return current_user_can('edit_posts');
}

function check_user_rol()
{
    $user = wp_get_current_user();
    $id_user = $user->id;
    $is_admin = in_array('administrator', (array) $user->roles);
    $is_employer = in_array('employer', (array) $user->roles);
    $is_company = in_array('company', (array) $user->roles);

    if ($is_admin) {
        return new WP_REST_Response(array('role' => 'admin', 'id_user' => $id_user ), 200);
    }

    if ($is_employer) {
        return new WP_REST_Response(array('role' => 'employer', 'id_user' => $id_user ), 200);
    }

    if ($is_company) {
        return new WP_REST_Response(array('role' => 'company', 'id_user' => $id_user ), 200);
    }

    return new WP_REST_Response(array('role' => 'subscriptor', 'id_user' => $id_user ), 200);
}
