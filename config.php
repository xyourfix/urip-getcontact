<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'modern_app');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'ModernApp');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');
define('APP_TIMEZONE', 'Asia/Jakarta');

// Security Configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('CSRF_TOKEN_LENGTH', 32);

// API Configuration
define('API_RATE_LIMIT', 100); // requests per hour
define('API_TIMEOUT', 30); // seconds

// File Upload Configuration
define('MAX_UPLOAD_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);
define('UPLOAD_PATH', 'uploads/');

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');
define('FROM_EMAIL', 'noreply@modernapp.com');
define('FROM_NAME', APP_NAME);

// GetContact API Configuration
define('GETCONTACT_TOKEN', 'TOKEN'); // Replace with your actual token
define('GETCONTACT_KEY', 'FINAL_KEY'); // Replace with your actual final key
define('GETCONTACT_API_URL', 'https://pbssrv-centralevents.com/v2.8/number-detail');

// Cache Configuration
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600);
define('CACHE_PATH', 'cache/');

// Debug Mode
define('DEBUG_MODE', true);
define('ERROR_REPORTING', E_ALL);

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

// Error reporting based on debug mode
if (DEBUG_MODE) {
    error_reporting(ERROR_REPORTING);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Autoload function for classes
function autoload($className) {
    $file = __DIR__ . '/classes/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('autoload');

// CSRF Token Generation
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION['csrf_token'];
}

// CSRF Token Validation
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Redirect function
function redirect($url, $statusCode = 302) {
    header("Location: $url", true, $statusCode);
    exit();
}

// JSON Response
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>