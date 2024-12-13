<?php
// SMTP Configuration
define('SMTP_HOST', 'mtl101.truehost.cloud');
define('SMTP_USERNAME', 'muiz@wheatchain.xyz');
define('SMTP_PASSWORD', 'Ikyw;VjQ5^;5');
define('SMTP_PORT', 587);
define('FROM_EMAIL', 'muiz@wheatchain.xyz');
define('FROM_NAME', 'WheatChain inc.');

// Additional required settings
define('SMTP_SECURE', 'tls');  // Enable TLS encryption
define('SMTP_AUTH', true);     // Enable SMTP authentication
define('SMTP_DEBUG', 2);       // Enable verbose debug output

// Additional connection settings
define('SMTP_TIMEOUT', 30);    // Connection timeout in seconds
define('SMTP_KEEP_ALIVE', true); // Keep connection alive

// Error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);