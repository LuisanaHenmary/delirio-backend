<?php

function wp_get_all_plans()
{
    global $wpdb;
    $table_plans = $wpdb->prefix . "plans";

    $results = $wpdb->get_results("SELECT * FROM $table_plans");

    return $results;
}


function wp_get_all_companies()
{
    global $wpdb;
    $table_companies = $wpdb->prefix . "companies";
    $table_plans = $wpdb->prefix . "plans";

    $results = $wpdb->get_results("
        SELECT  *
        FROM {$table_plans} p
        INNER JOIN {$table_companies} c ON p.id_plan = c.id_plan");

    return $results;
}

function wp_add_company($request)
{
    global $wpdb;
    $table_companies = $wpdb->prefix . "companies";

    $info = array(
        'nit' => $request['nit'],
        'name_company' => $request['name'],
        'phone' => $request['phone'],
        'id_user' => $request['id_user'],
        'id_plan' => $request['id_plan']
    );

    $wpdb->insert(
        $table_companies,
        $info
    );


    return new WP_REST_Response(array('company' => $info), 200);
}


function get_plan($request)
{
    $id = $request['id_user'];
    global $wpdb;
    $table_plans = $wpdb->prefix . "plans";
    $table_companies = $wpdb->prefix . "companies";

    $results = $wpdb->get_results("
        SELECT  p.name_plan, p.level_plan
        FROM {$table_plans} p
        INNER JOIN {$table_companies} c ON p.id_plan = c.id_plan
        WHERE c.id_user = {$id}
        ");

    return rest_ensure_response($results);
}

function wp_delete_company($request)
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
