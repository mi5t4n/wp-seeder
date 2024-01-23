<?php
/**
 * Attachment factory.
 */

namespace Sagar\WpSeeder\Factories;

use Faker\Factory;
use WpOrg\Requests\Requests;
use WpOrg\Requests\Response;

class AttachmentFactory {

    /**
     * Faker
     *
     * @var Faker\Generator
     */
    protected $faker;

    protected $batch = 5;

    protected $count = 100;

    protected $height = 768;

    protected $width = 1024;


    public function __construct(){
        $this->faker = Factory::create();
    }

    public function definition() {
        return array(
            'post_title' => $this->faker->text(),
            'post_content' => $this->faker->text(),
            'post_type' => 'attachment'
        );
    }

    public function set_batch( $batch ) {
        $this->batch = (int) $batch;
        return $this;
    }

    public function get_batch() {
        return $this->batch;
    }

    public function get_count() {
        return $this->count;
    }

    public function set_count( $count ) {
        $this->count = (int) $count;
        return $this;
    }

    public function get_wpdb() {
        return $GLOBALS['wpdb'];
    }

    public function get_query() {
        $batch = $this->get_batch();
        $wpdb = $this->get_wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->attachments}";

        $columns = array_keys( $this->definition());
        $columns = '(' . join(',', $columns) . ')';

        $placeholders = array_fill(0, count( $this->definition() ), '%s');
        $placeholders = '(' . join( ',', $placeholders ) . ')';

        $values = [];
        for( $index = 0 ; $index < $batch; ++$index ) {
            $values[] = $wpdb->prepare(
                $placeholders,
                array_values( $this->definition() )
            );
        }

        $values = join(',', $values );

        $sql = "{$sql} {$columns} VALUES {$values};";

        return $sql;
    }

    public function insert() {
        $wpdb = $this->get_wpdb();

        $sql = $this->get_query();

        $wpdb->query( $sql );
    }

    public function download() {
        global $wp_filesystem;

        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();

        $requests = array_map( function( $nothing ) {
            return [
                'url' => 'https://picsum.photos/1024/768',
                'method' => 'GET'
            ];
        }, array_fill( 0, $this->get_batch(), '' ) );


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

        $c = 1;
    }
}
