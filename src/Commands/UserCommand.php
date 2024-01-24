<?php
/**
 * User command.
 */

namespace Sagar\WpSeeder\Commands;

use Sagar\WpSeeder\Factories\UserFactory;
use function WP_CLI\Utils\make_progress_bar;

class UserCommand {

    protected $label = 'Generating Users';

    public function run( $args, $assoc_args ) {
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 1000;
        $batch = isset( $assoc_args['batch'] ) ? absint( $assoc_args['batch'] ) : 100;

        $progress = make_progress_bar( $this->label, $count );

        for( $index = 0; $index < $count; $index += $batch) {
            UserFactory::instance()->count( $batch )->create();

            $progress->tick($batch);
        }

        $progress->finish();
    }
}
