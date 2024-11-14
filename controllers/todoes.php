<?php


function wp_get_all_status()
{
    global $wpdb;
    $table_status = $wpdb->prefix . "status";

    $results = $wpdb->get_results("SELECT * FROM $table_status");

    return $results;
}

function wp_get_all_todoes()
{
    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $results = $wpdb->get_results("SELECT * FROM $table_todoes");

    return $results;
}

function wp_add_todo($request)
{
    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $info = array(
        'title' => $request['title'],
        'id_status' => 1,
        'id_employer' => $request['id_employer'],
        'id_company' => $request['id_company'],
        'id_project' => $request['id_project'],
        'expired' => $request['expired']
    );

    $wpdb->insert(
        $table_todoes,
        $info
    );

    return new WP_REST_Response(array('to-do' => $info), 200);
}

function wp_update_todo_admin($request)
{

    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $id = $request['id'];
    $title = $request['title'];
    $id_employer = $request['id_employer'];
    $expired = $request['expired'];

    $wpdb->update(
        $table_todoes,
        array(
            'title' => $title,
            'id_employer' => $id_employer,
            'expired' => $expired
        ),
        array('id_todo' => $id),
        array(
            '%s',
            '%d'
        ),
        array('%d')
    );


    return new WP_REST_Response(array('response' => 'Actaulizacion realizada'), 200);
}

function wp_update_todo_employer($request)
{

    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    if (current_user_can('edit_wp_todos')) {
        $id = $request['id'];
        $id_status = $request['id_status'];

        $wpdb->update(
            $table_todoes,
            array(
                'id_status' => $id_status,
            ),
            array('id_todo' => $id),
            array(
                '%d'    // value2
            ),
            array('%d')
        );


        return new WP_REST_Response(array('response' => 'Actaulizacion realizada'), 200);
    } else {
        return new WP_REST_Response(array('response' => 'No tienes permiso'), 400);
    }
}
