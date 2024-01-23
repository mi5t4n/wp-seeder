<?php
/**
 * Attachment command.
 */

namespace Sagar\WpSeeder\Commands;

use Sagar\WpSeeder\Factories\AttachmentFactory;
use function WP_CLI\Utils\make_progress_bar;

class AttachmentCommand {

    protected $label = 'Generating Attachments';

    public function run( $args, $assoc_args ) {
        add_filter( 'intermediate_image_sizes', '__return_empty_array' );

        $count = isset( $assoc_args['count'] ) ? absint( $assoc_args['count'] ) : 100;

        $progress = make_progress_bar( $this->label, $count );

        $batch = 5;

        for( $index = 0; $index < $count; $index += $batch) {
            AttachmentFactory::instance()->count( $batch )->create();

            $progress->tick($batch);
        }

        $progress->finish();

        remove_filter( 'intermediate_image_sizes', '__return_empty_array' );
    }
}
