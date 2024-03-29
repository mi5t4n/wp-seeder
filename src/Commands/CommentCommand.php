<?php
/**
 * Comment command.
 */

namespace Sagar\WpSeeder\Commands;

use Sagar\WpSeeder\Factories\CommentFactory;
use function WP_CLI\Utils\make_progress_bar;
class CommentCommand {

    protected $label = 'Generating Comments';

    public function run( $args, $assoc_args ) {
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 1000;
        $batch = isset( $assoc_args['batch'] ) ? absint( $assoc_args['batch'] ) : 100;
        $post_type = isset( $assoc_args['post_type'] ) ? sanitize_text_field( $assoc_args['post_type'] ) : 'post';

        $progress = make_progress_bar( $this->label, $count );
        for( $index = 0; $index < $count; $index += $batch) {
            CommentFactory::instance()->count( $batch )->create();

            $progress->tick($batch);
        }

        $progress->finish();
    }
}
