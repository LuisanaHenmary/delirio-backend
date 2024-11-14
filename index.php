<?php

/**
 * Plugin Name: delirio-api
 * Version: 1.0.0
 */

require_once "controllers/tables.php";
require_once "controllers/user.php";
require_once "routes.php";

register_activation_hook(__FILE__, "wp_setup_api_tables");

register_deactivation_hook(__FILE__, "wp_delete_api_tables");

add_action('rest_api_init', 'wp_learn_register_routes');
