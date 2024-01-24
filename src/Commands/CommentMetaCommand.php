<?php
/**
 * CommentMeta command.
 */

namespace Sagar\WpSeeder\Commands;

use Sagar\WpSeeder\Factories\CommentMetaFactory;
use function WP_CLI\Utils\make_progress_bar;
class CommentMetaCommand {

    protected $label = 'Generating CommentMetas';

    public function run( $args, $assoc_args ) {
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 1000;
        $batch = isset( $assoc_args['batch'] ) ? absint( $assoc_args['batch'] ) : 100;
        $comment_type = isset( $assoc_args['comment_type'] ) ? sanitize_text_field( $assoc_args['comment_type'] ) : 'commentmeta';

        $progress = make_progress_bar( $this->label, $count );
        for( $index = 0; $index < $count; $index += $batch) {
            CommentMetaFactory::instance()->count( $batch)->comment_type($comment_type)->create();

            $progress->tick($batch);
        }
        $progress->finish();
    }
}
