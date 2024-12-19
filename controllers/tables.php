<?php

function wp_setup_api_tables()
{
    global $wpdb;
    $status_value = array("Sin contenido", "Pendiente por aprobación", "Aprobado", "En proceso", "Publicado");
    $jobs_value = array("Diseñador grafico", "Administrador", "Fotografo");
    $plans_value = array(
        array(
            "name" => "Celeste",
            "level" => "Basico"
        ),
        array(
            "name" => "Indigo",
            "level" => "Medio"
        ),
        array(
            "name" => "Royal",
            "level" => "Full"
        ),
        array(
            "name" => "Cubrimiento de Cuento",
            "level" => ""
        ),
        array(
            "name" => "Pagina Web",
            "level" => ""
        ),
        array(
            "name" => "Logos - Basico",
            "level" => "Basico"
        ),
        array(
            "name" => "Logos - Medio",
            "level" => "Medio"
        ),
        array(
            "name" => "Logos - Full",
            "level" => "Full"
        ),
    );
    $type_to_do = array("Historia", "Post", "Carrucel", "Reel");

    // Incluir archivo necesario para usar dbDelta
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Definir nombres de las tablas con prefijo de WordPress
    $table_jobs = $wpdb->prefix . "jobs";
    $table_status = $wpdb->prefix . "status";
    $table_plans = $wpdb->prefix . "plans";
    $table_to_do_types = $wpdb->prefix . "to_do_types";
    $table_companies = $wpdb->prefix . "companies";
    $table_employers = $wpdb->prefix . "employers";
    $table_todoes = $wpdb->prefix . "todoes";
    $table_users = $wpdb->users;

    // SQL para crear la tabla "jobs"
    $sql_job = "CREATE TABLE $table_jobs (
        id_job BIGINT(20) NOT NULL AUTO_INCREMENT,
        name_job VARCHAR(100) NOT NULL,
        PRIMARY KEY  (id_job)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "jobs"
    dbDelta($sql_job);

    // Verificar si la tabla jobs se creó correctamente
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_jobs'") != $table_jobs) {
        error_log("Error: No se pudo crear la tabla 'jobs'");
        return; // Salir si la tabla 'jobs' no se creó
    }

    // SQL para crear la tabla "status"
    $sql_status = "CREATE TABLE $table_status (
        id_status BIGINT(20) NOT NULL AUTO_INCREMENT,
        name_status VARCHAR(100) NOT NULL,
        PRIMARY KEY  (id_status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "status"
    dbDelta($sql_status);

    // Verificar si la tabla status se creó correctamente
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_status'") != $table_status) {
        error_log("Error: No se pudo crear la tabla 'status'");
        return; // Salir si la tabla 'status' no se creó
    }

    // SQL para crear la tabla "plans"
    $sql_plans = "CREATE TABLE $table_plans (
        id_plan BIGINT(20) NOT NULL AUTO_INCREMENT,
        name_plan VARCHAR(100) NOT NULL,
        level_plan VARCHAR(100),
        PRIMARY KEY  (id_plan)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "plans"
    dbDelta($sql_plans);

    // Verificar si la tabla status se creó correctamente
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_plans'") != $table_plans) {
        error_log("Error: No se pudo crear la tabla 'plan'");
        return; // Salir si la tabla 'plans' no se creó
    }

    // SQL para crear la tabla "to_do_types"
    $sql_types = "CREATE TABLE $table_to_do_types (
        id_type BIGINT(20) NOT NULL AUTO_INCREMENT,
        name_type VARCHAR(100) NOT NULL,
        PRIMARY KEY  (id_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "to_do_types"
    dbDelta($sql_types);

    // Verificar si la tabla status se creó correctamente
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_to_do_types'") != $table_to_do_types) {
        error_log("Error: No se pudo crear la tabla 'plan'");
        return; // Salir si la tabla 'to_do_types' no se creó
    }


    foreach ($status_value as $s) {
        $wpdb->insert(
            $table_status,
            array('name_status' => $s)
        );
    }

    foreach ($jobs_value as $j) {
        $wpdb->insert(
            $table_jobs,
            array('name_job' => $j)
        );
    }

    foreach ($plans_value as $p) {
        $wpdb->insert(
            $table_plans,
            array(
                'name_plan' => $p["name"],
                'level_plan' => $p["level"]
            )
        );
    }

    foreach ($type_to_do as $t) {
        $wpdb->insert(
            $table_to_do_types,
            array('name_type' => $t)
        );
    }


    // SQL para crear la tabla "companies"
    $sql_company = "CREATE TABLE $table_companies (
        id_company BIGINT(20) NOT NULL AUTO_INCREMENT,
        nit VARCHAR(100) NOT NULL,
        name_company VARCHAR(100) NOT NULL,
        phone VARCHAR(100),
        id_plan BIGINT(20) NOT NULL,
        id_user BIGINT(20) UNSIGNED NOT NULL,
        PRIMARY KEY  (id_company),
        FOREIGN KEY (id_plan) REFERENCES $table_plans(id_plan) ON DELETE CASCADE,
        FOREIGN KEY (id_user) REFERENCES $table_users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "companies"
    dbDelta($sql_company);

    // Verificar si hubo algún error en la última operación
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_companies'") != $table_companies) {
        error_log("Error: No se pudo crear la tabla 'companies'");
    } else {
        error_log("Tabla 'companies' creada exitosamente.");
    }


    // SQL para crear la tabla "employers"
    $sql_employer = "CREATE TABLE $table_employers (
        id_employer BIGINT(20) NOT NULL AUTO_INCREMENT,
        ci VARCHAR(100) NOT NULL,
        name_employer VARCHAR(100) NOT NULL,
        phone VARCHAR(100),
        address_employer VARCHAR(100) NOT NULL,
        id_job BIGINT(20) NOT NULL,
        id_user BIGINT(20) UNSIGNED NOT NULL,
        PRIMARY KEY  (id_employer),
        FOREIGN KEY (id_job) REFERENCES $table_jobs(id_job) ON DELETE CASCADE,
        FOREIGN KEY (id_user) REFERENCES $table_users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "employers"
    dbDelta($sql_employer);

    // Verificar si hubo algún error en la última operación
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_employers'") != $table_employers) {
        error_log("Error: No se pudo crear la tabla 'employers'");
    } else {
        error_log("Tabla 'employers' creada exitosamente.");
    }

    //id_type
    // SQL para crear la tabla "todoes"
    $sql_todo = "CREATE TABLE $table_todoes (
        id_todo BIGINT(20) NOT NULL AUTO_INCREMENT,
        title VARCHAR(100) NOT NULL,
        delivery_date VARCHAR(100) NOT NULL,
        assignment_date VARCHAR(100) NOT NULL,
        description_todo VARCHAR(500),
        content_todo VARCHAR(500),
        material_link VARCHAR(100),
        copy_text VARCHAR(100),
        by_instragram BOOLEAN DEFAULT 0,
        by_facebook BOOLEAN DEFAULT 0,
        by_tiktok BOOLEAN DEFAULT 0,
        id_type BIGINT(20) NOT NULL,
        id_status BIGINT(20) NOT NULL,
        id_employer BIGINT(20) NOT NULL,
        id_company BIGINT(20) NOT NULL,
        PRIMARY KEY  (id_todo),
        FOREIGN KEY (id_type) REFERENCES $table_to_do_types(id_type) ON DELETE CASCADE,
        FOREIGN KEY (id_status) REFERENCES $table_status(id_status) ON DELETE CASCADE,
        FOREIGN KEY (id_employer) REFERENCES $table_employers(id_employer) ON DELETE CASCADE,
        FOREIGN KEY (id_company) REFERENCES $table_companies(id_company) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "todos"
    dbDelta($sql_todo);

    // Verificar si hubo algún error en la última operación
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_todoes'") != $table_todoes) {
        error_log("Error: No se pudo crear la tabla 'todos'");
    } else {
        error_log("Tabla 'todos' creada exitosamente.");
    }

    add_role(
        'employer',
        __("Employer"),
        array(
            'read' => true,
            "edit_wp_todos" => true,
        )
    );

    add_role(
        'company',
        __("Company"),
        array(
            'read' => true
        )
    );
}


function wp_delete_api_tables()
{

    global $wpdb;
    $table_jobs = $wpdb->prefix . "jobs";
    $table_status = $wpdb->prefix . "status";
    $table_plans = $wpdb->prefix . "plans";
    $table_to_do_types = $wpdb->prefix . "to_do_types";
    $table_companies = $wpdb->prefix . "companies";
    $table_employers = $wpdb->prefix . "employers";
    $table_todoes = $wpdb->prefix . "todoes";

    $wpdb->query("DROP TABLE IF EXISTS $table_todoes;");
    $wpdb->query("DROP TABLE IF EXISTS $table_companies;");
    $wpdb->query("DROP TABLE IF EXISTS $table_employers;");
    $wpdb->query("DROP TABLE IF EXISTS $table_to_do_types;");
    $wpdb->query("DROP TABLE IF EXISTS $table_plans;");
    $wpdb->query("DROP TABLE IF EXISTS $table_status;");
    $wpdb->query("DROP TABLE IF EXISTS $table_jobs;");
    
}
