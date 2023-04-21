<?php
/**
 * Plugin Name: DLM PLUGIN PRO
 * Description: Sample plugin that integrates with Digital License Manager PRO update server
 * Version: 1.0.0
 * Author: Darko Gjorgjijoski
 * License: GPLv2 or later
 * Text Domain: dlm-plugin-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'DLM_PLUGIN_PRO_ID', 1 ); // The software ID in Digital License Manager PRO.
define( 'DLM_PLUGIN_PRO_VERSION', '1.0.0' );
define( 'DLM_PLUGIN_PRO_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'DLM_PLUGIN_PRO_FILE', __FILE__ );
define( 'DLM_PLUGIN_PRO_BASENAME', plugin_basename( __FILE__ ) );
define( 'DLM_PLUGIN_PRO_URL', 'https://yoursite.com/product/dlm-plugin-pro' );
define( 'DLM_PLUGIN_PRO_ACTIVATOR_CONSUMER_KEY', 'ck_XXXXXXXXXXXXXXXXXXXXXXXXXXX' );
define( 'DLM_PLUGIN_PRO_ACTIVATOR_CONSUMER_SECRET', 'cs_XXXXXXXXXXXXXXXXXXXXXXXXXX' );
define( 'DLM_PLUGIN_PRO_ACTIVATOR_URL', 'http://yoursite.com/wp-json/dlm/v1/' );

if ( ! file_exists( DLM_PLUGIN_PRO_PATH . 'vendor/autoload.php' ) ) {
	wp_die( 'Please run composer install to install the composer dependencies.' );
}

require_once DLM_PLUGIN_PRO_PATH . 'vendor/autoload.php';

// Init plugin.
new \IdeoLogix\DLMPluginPro\Bootstrap();
