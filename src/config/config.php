<?php
/**
 * Application Configuration
 */

// Site settings
define('SITE_NAME', 'E-commerce');
define('SITE_URL', 'http://localhost/ecomerce');

// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecomerce_db'); // Updated to the correct database name
define('DB_USER', 'root');
define('DB_PASS', '');

// Path settings
define('ROOT_PATH', dirname(__DIR__, 2));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Timezone
date_default_timezone_set('America/Sao_Paulo');