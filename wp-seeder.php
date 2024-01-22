<?php
/**
 * Plugin Name: WP Seeder
 * Plugin URI: https://example.com/
 * Description: WP Seeder
 * Version: 0.1.0
 * Author: Sagar Tamang
 * Author URI: https://example.com
 * Text Domain: wp-seeder
 * Domain Path: /i18n/languages/
 * Requires at least: 6.3
 * Requires PHP: 7.4
 *
 */

use Sagar\WpSeeder\Main;

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WP_SEEDER_PLUGIN_FILE' ) ) {
	define( 'WP_SEEDER_PLUGIN_FILE', __FILE__ );
}

require dirname( __FILE__ ) . '/vendor/autoload.php';

Main::instance()->init();
