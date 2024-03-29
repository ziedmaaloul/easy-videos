<?php

namespace TypeRocket\Core;
use  \App\Controllers\PluginController;

/**
 * Plugin Name: Easy Videos
 * Plugin URI: http://www.example.com
 * Plugin Prefix: easy_videos
 * Plugin ID: easy-videos
 * Description: Easy Videos Importer
 * Version: 1.0.0
 * Author: Zied Maaloul
 * Author URI: http://www.example.com
 * Text Domain: Import Videos from Youtube
 * Domain Path: languages
 * Domain Var: PLUGIN_TD
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Initialisation
add_action('admin_init', function() {
    global $pagenow;
    if ( $pagenow == 'admin.php' ) {
        // Import JS and Css Files
        wp_enqueue_style( 'bootstrap-styles', "https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css");
        wp_enqueue_script( 'jquery-script', "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js");
        wp_enqueue_script( 'ajax-script', site_url().'/'.EASY_VIDEOS_URL."/resources/assets/js/ajax.js");
    }
});

 // Define EASY_VIDEOS_PATH And URL
define('EASY_VIDEOS_PATH', __DIR__);
define('EASY_VIDEOS_URL', 'wp-content/plugins/easy-videos');

// Start Check if Plugin is active

if(!file_exists( realpath(dirname(realpath(__DIR__)).'/typerocket-v5/typerocket-v5.php'))){
    // Rocket not installed
    
	$admin_pages = [ 'index.php', 'plugins.php' ];
    if ( in_array( $pagenow, $admin_pages ) ) {
            echo '
            <div class="notice notice-error">
                <p>To use Easy Videos Plugins , You must install and activate <a href="https://typerocket.com/downloads/v5.zip">TypeRocket v5 Plugin</a>  , Please Check <a href="https://typerocket.com/docs/v5/install-via-plugin/" target="_blanc">Documentation</a></p>
            </div>
            ';
    }
    return;
}
// End Check if Plugin is active
    
// Define Resources Constants
if(!defined('EASY_VIDEOS_RESOURCES_PATH')){
    define('EASY_VIDEOS_RESOURCES_PATH', EASY_VIDEOS_PATH.'/resources/views');
}


// Define Assets Constants
if(!defined('EASY_VIDEOS_ASSETS_PATH')){
    define('EASY_VIDEOS_ASSETS_PATH', EASY_VIDEOS_PATH.'/resources/assets');
}

// Define Application Name Space
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

define('TYPEROCKET_CORE_CONFIG_PATH',__DIR__. '/config' );

// Start Plugin

if (! EASY_VIDEOS_SKIP_INIT) {
    ApplicationKernel::init();
}

$pluginController = new PluginController();
$pluginController->createPostType();
