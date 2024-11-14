<?php

function wp_add_project($request)
{
    global $wpdb;
    $table_projects = $wpdb->prefix . "projects";

    $info = array(
        'name_project' => $request['name'],
        'description_project' => $request['description'],
        'id_company' => $request['company']
    );

    $wpdb->insert(
        $table_projects,
        $info
    );


    return new WP_REST_Response(array('project' => $info), 200);
}

function wp_get_all_projects()
{
    global $wpdb;
    $table_projects = $wpdb->prefix . "projects";

    $results = $wpdb->get_results("SELECT * FROM $table_projects");

    return $results;
}