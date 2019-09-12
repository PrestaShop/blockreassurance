<?php

if (!(php_sapi_name() === 'cli-server')) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check ' . basename(__FILE__) . ' for more information.');
}

$rootDir = getenv('_PS_ROOT_DIR_');
if (!$rootDir) {
    echo '[ERROR] Define _PS_ROOT_DIR_ with the path to PrestaShop folder' . PHP_EOL;
    exit(1);
}
// Add module composer autoloader
require_once dirname(__DIR__) . '/../../vendor/autoload.php';
// Add PrestaShop composer autoload
define('_PS_ADMIN_DIR_', $rootDir . '/admin-dev/');
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_);
require_once $rootDir . '/config/defines.inc.php';
require_once $rootDir . '/config/autoload.php';
require_once $rootDir . '/config/bootstrap.php';
// Make sure loader php-parser is coming from php stan composer
$loader = new \Composer\Autoload\ClassLoader();
$loader->setPsr4('PhpParser\\', array('/composer/vendor/nikic/php-parser/lib/PhpParser'));
$loader->register(true);
// We must declare these constant in this boostrap script.
// Ignoring the error partern with this value will throw another error if not found
// during the checks.
$constantsToDefine = [
    '_DB_PREFIX_',
    '_PS_SSL_PORT_',
    '_THEME_NAME_',
    '_PARENT_THEME_NAME_',
    '__PS_BASE_URI__',
    '_PS_PRICE_DISPLAY_PRECISION_',
    '_PS_PRICE_COMPUTE_PRECISION_',
    '_PS_OS_CHEQUE_',
    '_PS_OS_PAYMENT_',
    '_PS_OS_PREPARATION_',
    '_PS_OS_SHIPPING_',
    '_PS_OS_DELIVERED_',
    '_PS_OS_CANCELED_',
    '_PS_OS_REFUND_',
    '_PS_OS_ERROR_',
    '_PS_OS_OUTOFSTOCK_',
    '_PS_OS_OUTOFSTOCK_PAID_',
    '_PS_OS_OUTOFSTOCK_UNPAID_',
    '_PS_OS_BANKWIRE_',
    '_PS_OS_PAYPAL_',
    '_PS_OS_WS_PAYMENT_',
    '_PS_OS_COD_VALIDATION_',
];
foreach ($constantsToDefine as $constant) {
    if (!defined($constant)) {
        define($constant, 'DUMMY_VALUE');
    }
}
