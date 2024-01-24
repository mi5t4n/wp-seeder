<?php

namespace Sagar\WpSeeder;

use Sagar\WpSeeder\Commands\PostCommand;
use Sagar\WpSeeder\Commands\UserCommand;
use Sagar\WpSeeder\Commands\CommentCommand;
use Sagar\WpSeeder\Commands\AttachmentCommand;

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
	 * [--batch=<batch>]
	 * : Number of posts to inserted in batch.
	 * ---
	 * default: 100
	 *
	 * [--count=<count>]
	 * : Total number of posts to be generated.
	 * ---
	 * default: 1000
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 */
    public function post($args, $assoc_args ) {
        (new PostCommand())->run($args, $assoc_args);
    }

	 /**
	 * Generate comments
	 *
	 * ## OPTIONS
	 *
	 * [--post_type=<post_type>]
	 * : Post types to be generated.
	 * ---
	 * default: post
	 *
	 * [--batch=<batch>]
	 * : Number of comments to inserted in batch.
	 * ---
	 * default: 100
	 *
	 * [--count=<count>]
	 * : Total number of comments to be generated.
	 * ---
	 * default: 1000
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 */
    public function comment($args, $assoc_args) {
        (new CommentCommand())->run($args, $assoc_args);
    }

    public function terms( $args, $assoc_args ) {

    }

	/**
	 * Generate users
	 *
	 * ## OPTIONS
	 *
	 * [--role=<role>]
	 * : Roles to be generated.
	 * ---
	 * default: subscriber
	 *
	 * [--count=<count>]
	 * : Total number of users to be generated.
	 * ---
	 * default: 100
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 */
    public function user( $args, $assoc_args ) {
        (new UserCommand())->run($args, $assoc_args);
    }


	/**
	 * Generate attachments
	 *
	 * ## OPTIONS
	 *
	 * [--count=<count>]
	 * : Total number of attachments to be generated.
	 * ---
	 * default: 100
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 */
    public function attachment( $args, $assoc_args ) {
        (new AttachmentCommand())->run($args, $assoc_args);
    }
}
