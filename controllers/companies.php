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

    $results = $wpdb->get_results("SELECT * FROM $table_companies");

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