<?php

/**
 * Plugin Name:       Plugin Boilerplate
 * Plugin URI:        https://andriy.space
 * Description:       Plugin Boilerplate
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Andriy Haydash
 * Author URI:        https://andriy.space
 * Version:           1.0
 * Text Domain:       plugin-boilerplate
 */

use PluginBoilerplate\Plugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$helpersFile = __DIR__ . '/helpers/functions.php';

if (file_exists($helpersFile)) {
    require_once($helpersFile);
}

spl_autoload_register(function ($class_name) {
    $dir = __DIR__ . DIRECTORY_SEPARATOR; 
    
    $replacements = [
        'PluginBoilerplate\\' => '',
        'Settings\\' => 'settings/',
    ];

    foreach ($replacements as $namespace => $replacement) {
        $class_name = str_replace($namespace, $replacement, $class_name);
    }

    $file = $dir . $class_name . '.php';

    if (file_exists($file)) {
        // only include if file exists, otherwise we might enter some conflicts with other pieces of code which are also using the spl_autoload_register function
        include $file; 
    }
});

new Plugin();