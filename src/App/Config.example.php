<?php

namespace App;

class Config {
    /**
     * Database information
     */
    const
        DB_USER = 'root',       // Login
        DB_PSW = '',            // Password
        DB_HOST = 'localhost',  // Host
        DB_PORT = 3306,         // Port
        DB_NAME = 'e_commerce'; // Name of the database

    /**
     * Begining of each URL of this project
     * Useful to avoid problems,
     * especially considering :
     * - http://localhost:8000
     * - http://localhost/<DIRECTORY>
     */
    const BASE_URL = 'http://localhost:8000';

    /**
     * The directory where to store logs
     */
    const LOGS_DIR = __DIR__ . '/../../logs';

    /**
     * The directory where views are stored
     */
    const VIEWS_DIR = __DIR__ . '/../views';

    /**
     * The mail from and to which write to website
     */
    const MAIL_CONTACT = 'admin_monsite@yopmail.fr';

    /**
     * All the information about SMTP servers
     */
    const
        SMTP_HOST = '',
        SMTP_PORT = '',
        SMTP_USER = '',
        SMTP_PSW = '';
}
