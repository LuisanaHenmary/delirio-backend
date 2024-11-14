<?php

function wp_setup_api_tables()
{
    global $wpdb;
    $status_value = array("To-do", "In progress", "Done");
    $jobs_value = array("Job1", "Job2", "Job3");

    // Incluir archivo necesario para usar dbDelta
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Definir nombres de las tablas con prefijo de WordPress
    $table_jobs = $wpdb->prefix . "jobs";
    $table_status = $wpdb->prefix . "status";
    $table_companies = $wpdb->prefix . "companies";
    $table_employers = $wpdb->prefix . "employers";
    $table_todoes = $wpdb->prefix . "todoes";
    $table_projects = $wpdb->prefix . "projects";
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


    // SQL para crear la tabla "companies"
    $sql_company = "CREATE TABLE $table_companies (
        id_company BIGINT(20) NOT NULL AUTO_INCREMENT,
        nit VARCHAR(100) NOT NULL,
        name_company VARCHAR(100) NOT NULL,
        phone VARCHAR(100),
        id_user BIGINT(20) UNSIGNED NOT NULL,
        PRIMARY KEY  (id_company),
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
        id_job BIGINT(20),
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

    // SQL para crear la tabla "table_projects"
    $sql_project = "CREATE TABLE $table_projects (
        id_project BIGINT(20) NOT NULL AUTO_INCREMENT,
        name_project VARCHAR(100) NOT NULL,
        description_project VARCHAR(500),
        id_company BIGINT(20), 
        PRIMARY KEY  (id_project),
        FOREIGN KEY (id_company) REFERENCES $table_companies(id_company) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    // Ejecutar la creación de la tabla "todos"
    dbDelta($sql_project);

    // Verificar si hubo algún error en la última operación
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_projects'") != $table_projects) {
        error_log("Error: No se pudo crear la tabla 'todos'");
    } else {
        error_log("Tabla 'todos' creada exitosamente.");
    }

    // SQL para crear la tabla "todoes"
    $sql_todo = "CREATE TABLE $table_todoes (
        id_todo BIGINT(20) NOT NULL AUTO_INCREMENT,
        title VARCHAR(100) NOT NULL,
        expired VARCHAR(100) NOT NULL,
        id_status BIGINT(20),
        id_employer BIGINT(20),
        id_company BIGINT(20),
        id_project BIGINT(20),
        PRIMARY KEY  (id_todo),
        FOREIGN KEY (id_status) REFERENCES $table_status(id_status) ON DELETE CASCADE,
        FOREIGN KEY (id_employer) REFERENCES $table_employers(id_employer) ON DELETE CASCADE,
        FOREIGN KEY (id_company) REFERENCES $table_companies(id_company) ON DELETE CASCADE,
        FOREIGN KEY (id_project) REFERENCES $table_projects(id_project) ON DELETE CASCADE
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
    $table_companies = $wpdb->prefix . "companies";
    $table_employers = $wpdb->prefix . "employers";
    $table_todoes = $wpdb->prefix . "todoes";
    $table_projects = $wpdb->prefix . "projects";

    $wpdb->query("DROP TABLE IF EXISTS $table_todoes;");
    $wpdb->query("DROP TABLE IF EXISTS $table_projects;");
    $wpdb->query("DROP TABLE IF EXISTS $table_companies;");
    $wpdb->query("DROP TABLE IF EXISTS $table_employers;");
    $wpdb->query("DROP TABLE IF EXISTS $table_status;");
    $wpdb->query("DROP TABLE IF EXISTS $table_jobs;");
    
}
