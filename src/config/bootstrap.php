<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base = rtrim($scriptName, '/') . '/';
define('BASE_URL', $base);

require_once __DIR__ . '/connect-db.php';
require_once __DIR__ . '/constants.php';

if (!empty($_SESSION['timezone'])) {
    date_default_timezone_set($_SESSION['timezone']);
}
?>