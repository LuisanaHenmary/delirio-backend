<?php

function wp_get_all_employers()
{
    global $wpdb;
    $table_employers = $wpdb->prefix . "employers";

    $results = $wpdb->get_results("SELECT * FROM $table_employers");

    return $results;
}



function wp_add_employer($request)
{
    global $wpdb;
    $table_employers = $wpdb->prefix . "employers";

    $info = array(
        'ci' => $request['ci'],
        'name_employer' => $request['name'],
        'phone' => $request['phone'],
        'address_employer' => $request['address'],
        'id_job' => $request['id_job'],
        'id_user' => $request['id_user']
    );

    $wpdb->insert(
        $table_employers,
        $info
    );


    return new WP_REST_Response(array('employer' => $info), 200);
}

function wp_get_all_jobs()
{
    global $wpdb;
    $table_jobs = $wpdb->prefix . "jobs";

    $results = $wpdb->get_results("SELECT * FROM $table_jobs");

    return $results;
}

function wp_delete_employer($request)
{

    global $wpdb;
    $table_users = $wpdb->users;

    $id = intval($request['id']);

    $deleted = $wpdb->delete($table_users, array('id' => $id), array('%d'));

    if ($deleted === false) {
        return new WP_Error('delete_failed', 'No se pudo borrar la fila.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'success' => true,
        'message' => 'Fila eliminada correctamente.'
    ));
}