<?php

namespace Sagar\WpSeeder;

use Sagar\WpSeeder\Commands\PostCommand;

class Seeder {
    /**
	 * Generate posts
	 *
	 * ## OPTIONS
	 *
	 * [--post_type=<post_type>]
	 * : Post types to be generated.
	 * ---
	 * default: post
	 *
	 * [--count=<count>]
	 * : Total number of posts to be generated.
	 * ---
	 * default: 100
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 */
    public function post($args, $assoc_args ) {
        (new PostCommand())->run($args, $assoc_args);
    }

    public function comment($args, $assoc_args) {

    }

    public function terms( $args, $assoc_args ) {

    }

    public function users( $args, $assoc_args ) {

    }
}