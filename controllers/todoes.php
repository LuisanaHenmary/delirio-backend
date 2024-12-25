<?php


function wp_get_all_status()
{
    global $wpdb;
    $table_status = $wpdb->prefix . "status";

    $results = $wpdb->get_results("SELECT * FROM $table_status");

    return $results;
}

function wp_get_all_types()
{
    global $wpdb;
    $table_to_do_types = $wpdb->prefix . "to_do_types";

    $results = $wpdb->get_results("SELECT * FROM $table_to_do_types");

    return $results;
}

function wp_get_all_todoes()
{
    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $results = $wpdb->get_results("SELECT * FROM $table_todoes");

    return $results;
}

function wp_get_todoes_per_id_user_employer($request)
{
    global $wpdb;
    $table_employers = $wpdb->prefix . "employers";
    $table_todoes = $wpdb->prefix . "todoes";
    $id = $request['id'];

    $result = $wpdb->get_results("SELECT * FROM $table_employers WHERE id_user=$id");

    $id_employer = $result[0]->id_employer;

    $todoes = $wpdb->get_results("SELECT * FROM $table_todoes WHERE id_employer=$id_employer");

    return $todoes;
}

function wp_get_todoes_per_id_user_company($request)
{
    global $wpdb;
    $table_companies = $wpdb->prefix . "companies";
    $table_todoes = $wpdb->prefix . "todoes";
    $id = $request['id'];

    $result = $wpdb->get_results("SELECT * FROM $table_companies WHERE id_user=$id");

    $id_company = $result[0]->id_company;

    $todoes = $wpdb->get_results("SELECT * FROM $table_todoes WHERE id_company=$id_company");

    return $todoes;
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
        'id_type' => $request['id_type'],
        'by_instragram' => $request['by_instragram'],
        'by_facebook' => $request['by_facebook'],
        'by_tiktok' => $request['by_tiktok'],
        'assignment_date' => $request['assignment_date'],
        'delivery_date' => $request['delivery_date'],
        'description_todo' => $request['description_todo'],
        'content_todo' => $request['content_todo'],
        'material_link' => $request['material_link'],
        'copy_text' => $request['copy_text'],
    );

    $wpdb->insert(
        $table_todoes,
        $info
    );

    $id_todo = $wpdb->insert_id;

    return new WP_REST_Response(array('to-do' => $info, "id" => $id_todo), 200);
}

function wp_update_todo_admin($request)
{

    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $id = $request['id'];

    $info = array(
        'title' => $request['title'],
        'id_employer' => $request['id_employer'],
        'assignment_date' => $request['assignment_date'],
        'delivery_date' => $request['delivery_date'],
        'material_link' => $request['material_link'],
        'description_todo' => $request['description_todo'],
        'copy_text' => $request['copy_text'],
        'by_instragram' => $request['by_instragram'],
        'by_facebook' => $request['by_facebook'],
        'by_tiktok' => $request['by_tiktok'],
    );

    
    $wpdb->update(
        $table_todoes,
        $info,
        array('id_todo' => $id),
        array(
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',

        ),
        array('%d')
    );

    return new WP_REST_Response(array('response' => "La informacio se actualizo con exito"), 200);
}

function wp_update_todo_employer($request)
{

    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    if (current_user_can('edit_wp_todos')) {
        $id = $request['id'];

        $wpdb->update(
            $table_todoes,
            array(
                'id_status' => $request['id_status'],
                'copy_text' => $request['copy_text'],
                'content_todo' => $request['content_todo'],
            ),
            array('id_todo' => $id),
            array(
                '%d',
                '%s',
                '%s',
            ),
            array('%d')
        );


        return new WP_REST_Response(array('response' => 'Actaulizacion realizada'), 200);
    } else {
        return new WP_REST_Response(array('response' => 'No tienes permiso'), 400);
    }
}

function wp_delete_todo($request)
{

    global $wpdb;
    $table_todoes = $wpdb->prefix . "todoes";

    $id = intval($request['id']);

    $deleted = $wpdb->delete($table_todoes, array('id_todo' => $id), array('%d'));

    if ($deleted === false) {
        return new WP_Error('delete_failed', 'No se pudo borrar la fila.', array('status' => 500));
    }

    return rest_ensure_response(array(
        'success' => true,
        'message' => 'Fila eliminada correctamente.'
    ));
}