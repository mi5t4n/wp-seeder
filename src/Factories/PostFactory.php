<?php
/**
 * Post factory.
 */

namespace Sagar\WpSeeder\Factories;

use Faker\Factory;


class PostFactory {

    /**
     * Faker
     *
     * @var Faker\Generator
     */
    protected $faker;

    protected $batch = 50;

    protected $count = 100;


    public function __construct(){
        $this->faker = Factory::create();
    }

    public function definition() {
        return array(
            'post_title' => $this->faker->text(),
            'post_content' => $this->faker->text(),
            'post_type' => 'post'
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

        $sql = "INSERT INTO {$wpdb->posts}";

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
}