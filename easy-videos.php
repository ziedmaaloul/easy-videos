<?php

namespace TypeRocket\Core;
use  \App\Controllers\PluginController;

/**
 * Plugin Name: Easy Videos
 * Plugin URI: http://www.heimdal.com
 * Plugin Prefix: easy_videos
 * Plugin ID: easy-videos
 * Description: Easy Videos Importer
 * Version: 1.0.0
 * Author: Zied Maaloul
 * Author URI: http://www.heimdal.com
 * Text Domain: Import Videos from Youtube
 * Domain Path: languages
 * Domain Var: PLUGIN_TD
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

 // Define EASY_VIDEOS_PATH
define('EASY_VIDEOS_PATH', __DIR__);


if(!defined('EASY_VIDEOS_RESOURCES_PATH')){
    define('EASY_VIDEOS_RESOURCES_PATH', EASY_VIDEOS_PATH.'/resources/view');
}

if (!defined('TYPEROCKET_APP_NAMESPACE')) {
    define('TYPEROCKET_APP_NAMESPACE', 'App');
}


// Define EASY_VIDEOS alternate path
if (!defined('EASY_VIDEOS_APP_ROOT_PATH')) {
    define('EASY_VIDEOS_APP_ROOT_PATH', EASY_VIDEOS_PATH);
}

// Define App auto loader
if (!defined('EASY_VIDEOS_AUTOLOAD_APP')) {
    define('EASY_VIDEOS_AUTOLOAD_APP', ['prefix' => 'App' . '\\', 'folder' => __DIR__ . '/app/']);
}

// Run vendor autoloader
if (!defined('EASY_VIDEOS_AUTO_LOADER')) {
    // Require Two Vendors , Vendor of Framework and Vendor of current plugin for custom packages
    require realpath(dirname(realpath(__DIR__)).'/typerocket-v5/typerocket/vendor/autoload.php');
    require realpath(__DIR__.'/vendor/autoload.php');
} else {
    call_user_func(EASY_VIDEOS_AUTO_LOADER);
}

// Run app autoloader
$tr_autoload_map = EASY_VIDEOS_AUTOLOAD_APP;
ApplicationKernel::autoloadPsr4($tr_autoload_map);

// Define configuration path
if (!defined('EASY_VIDEOS_CORE_CONFIG_PATH')) {
    define('EASY_VIDEOS_CORE_CONFIG_PATH', __DIR__ . '/config');
}

if (! defined('EASY_VIDEOS_SKIP_INIT')) {
    define('EASY_VIDEOS_SKIP_INIT', false);
}

if (! EASY_VIDEOS_SKIP_INIT) {
    ApplicationKernel::init();
}


define('TYPEROCKET_CORE_CONFIG_PATH',__DIR__. '/config' );

// Start Plugin
$pluginController = new PluginController();
$pluginController->createPostType();
