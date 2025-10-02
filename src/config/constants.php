<?php
// Application identity
define('APP_NAME', 'ContractorConnector');
define('APP_VERSION', '1.0.0');

// Environment: 'development' or 'production'
define('ENV', 'development');

// Default time zone (fallback if session timezone isn’t set)
define('DEFAULT_TIMEZONE', 'UTC');

// Mail settings (used in contact forms, notifications)
define('SUPPORT_EMAIL', 'support@contractorconnector.local');

// Asset paths (relative to BASE_URL defined in bootstrap.php)
define('CSS_PATH', BASE_URL . 'public/css/');
define('JS_PATH',  BASE_URL . 'public/js/');
define('IMG_PATH', BASE_URL . 'public/images/');

// Feature flags (toggle experimental features)
define('ENABLE_BETA_FEATURES', false);