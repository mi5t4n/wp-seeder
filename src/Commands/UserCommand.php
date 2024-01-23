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
        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 100;

        $progress = make_progress_bar( $this->label, $count );

        $batch = 50;
        $factory = new UserFactory();

        for( $index = 0; $index < $count; $index += $batch) {
            $factory->set_count( $count )->set_batch( $batch )->insert();

            $progress->tick($batch);
        }

        $progress->finish();
    }
}
