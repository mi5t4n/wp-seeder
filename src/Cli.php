<?php
/**
 * Handles cli command initialization.
 */

namespace Mi5t4n\WpSeeder;

class Cli {
	/**
	 * Register CLI commands.
	 *
	 * @since 1.3.1
	 */
	public static function register() {

        \WP_CLI::add_command( "seeder", PostCommand );
	}
}
