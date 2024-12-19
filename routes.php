<?php

require_once "controllers/employers.php";
require_once "controllers/companies.php";
require_once "controllers/todoes.php";

function wp_learn_register_routes()
{
    $prefix_api = "delirio-api";
    $vertion = "v1";

    register_rest_route(
        "$prefix_api/$vertion",
        '/status/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_status',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/types/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_types',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/jobs/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_jobs',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/plans/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_plans',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/employers/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_employers',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/employer/(?P<id>\d+)',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_todoes_per_id_user_employer',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/company/(?P<id>\d+)',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_todoes_per_id_user_company',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/companies/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_companies',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );


    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_todoes',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/get-rol',
        array(
            'methods' => 'GET',
            'callback' => 'check_user_rol',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/companies/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_company',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/employers/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_employer',
            'permission_callback' => 'wp_check_permission'
        )
    );


    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_todo',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/admin/(?P<id>\d+)',
        array(
            'methods' => 'PUT',
            'callback' => 'wp_update_todo_admin',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        "$prefix_api/$vertion",
        '/to-does/(?P<id>\d+)',
        array(
            'methods' => 'PUT',
            'callback' => 'wp_update_todo_employer',
            'permission_callback' => '__return_true'
        )
    );

    
    
    
}
