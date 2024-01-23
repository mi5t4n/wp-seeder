<?php
/**
 * Attachment factory.
 */

namespace Sagar\WpSeeder\Factories;

use WpOrg\Requests\Requests;
use WpOrg\Requests\Response;
use Sagar\WpSeeder\Abstracts\Factory;

class AttachmentFactory extends Factory {
    public function query() {

    }

    public function definition() {
        return array(
            'post_title' => $this->faker->text(),
            'post_content' => $this->faker->text(),
            'post_type' => 'attachment'
        );
    }

    public function create() {
        global $wp_filesystem;

        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();

        $requests = array_map( function( $nothing ) {
            return [
                'url' => 'https://picsum.photos/1024/768',
                'method' => 'GET'
            ];
        }, array_fill( 0, $this->count, '' ) );


        $responses = Requests::request_multiple($requests);

        foreach( $responses as $response ) {
            if ( 200 !== $response->status_code ) {
                continue;
            }

            $content_type = $response->headers['Content-Type'];

            $mime_types = array_flip( wp_get_mime_types() );

            $ext = isset( $mime_types[$content_type]) ? $mime_types[$content_type] : null;
            $ext = current(explode('|', $ext ));
            if ( ! $ext ) {
                continue;
            }

            $image_name = wp_tempnam( 'images-');
            $image_name = str_replace( '.tmp', $ext, $image_name );

            $wp_filesystem->put_contents($image_name, $response->body);

            media_handle_sideload([
               'name' => $image_name,
               'tmp_name' => $image_name,
            ]);
        }
    }
}
