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
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 100;

        $progress = make_progress_bar( $this->label, $count );

        $batch = 50;

        for( $index = 0; $index < $count; $index += $batch) {
            PostFactory::instance()->count( $batch)->create();

            $progress->tick($batch);
        }

        $progress->finish();
    }
}
