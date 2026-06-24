<?php
/**
 * Entry point khusus untuk Vercel
 * File ini akan menangani semua request
 */

// Set environment ke production
define('ENVIRONMENT', 'production');

// Tentukan root path (naik satu folder dari api)
$root_path = dirname(__DIR__);

// Definisikan path system dan application
$system_path = $root_path . '/system';
$application_folder = $root_path . '/application';

// Validasi folder system
if (!is_dir($system_path)) {
    die('System folder not found at: ' . $system_path);
}

// Validasi folder application
if (!is_dir($application_folder)) {
    die('Application folder not found at: ' . $application_folder);
}

// Set constants untuk CodeIgniter
define('BASEPATH', $system_path . DIRECTORY_SEPARATOR);
define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('SYSDIR', basename(BASEPATH));

// Load file utama CodeIgniter
require_once BASEPATH . 'core/CodeIgniter.php';