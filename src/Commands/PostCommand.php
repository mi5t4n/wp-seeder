<?php
/**
 * Post command.
 */

namespace Sagar\WpSeeder\Commands;

use Sagar\WpSeeder\Factories\PostFactory;
use function WP_CLI\Utils\make_progress_bar;
class PostCommand {

    protected $label = 'Generating Posts';

    public function run( $args, $assoc_args ) {
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 1000;
        $batch = isset( $assoc_args['batch'] ) ? absint( $assoc_args['batch'] ) : 100;
        $post_type = isset( $assoc_args['post_type'] ) ? sanitize_text_field( $assoc_args['post_type'] ) : 'post';

        $progress = make_progress_bar( $this->label, $count );
        for( $index = 0; $index < $count; $index += $batch) {
            PostFactory::instance()->count( $batch)->post_type($post_type)->create();

            $progress->tick($batch);
        }
        $progress->finish();
    }
}
