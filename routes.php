<?php

require_once "controllers/employers.php";
require_once "controllers/companies.php";
require_once "controllers/projects.php";
require_once "controllers/todoes.php";

function wp_learn_register_routes()
{

    register_rest_route(
        'custom-api/v1',
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
        'custom-api/v1',
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
        'custom-api/v1',
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
        'custom-api/v1',
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
        'custom-api/v1',
        '/projects/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_get_all_projects',
            'permission_callback' => function () {
                return is_user_logged_in(); // Asegurarse de que el usuario esté autenticado
            }
        )
    );

    register_rest_route(
        'custom-api/v1',
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
        'custom-api/v1',
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
        'custom-api/v1',
        '/companies/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_company',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        'custom-api/v1',
        '/employers/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_employer',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        'custom-api/v1',
        '/projects/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_project',
            'permission_callback' => 'wp_check_permission'
        )
    );


    register_rest_route(
        'custom-api/v1',
        '/to-does/',
        array(
            'methods' => 'POST',
            'callback' => 'wp_add_todo',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        'custom-api/v1',
        '/to-does/admin/(?P<id>\d+)',
        array(
            'methods' => 'PUT',
            'callback' => 'wp_update_todo_admin',
            'permission_callback' => 'wp_check_permission'
        )
    );

    register_rest_route(
        'custom-api/v1',
        '/to-does/(?P<id>\d+)',
        array(
            'methods' => 'PUT',
            'callback' => 'wp_update_todo_employer',
            'permission_callback' => '__return_true'
        )
    );

    
    
    
}
