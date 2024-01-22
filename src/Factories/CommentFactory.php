<?php
/**
 * Comment factory.
 */

namespace Sagar\WpSeeder\Factories;

use Faker\Factory;


class CommentFactory {

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
            'comment_agent' => $this->faker->userAgent(),
            'comment_approved' => $this->faker->numberBetween(0, 1),
            'comment_author' => $this->faker->name(),
            'comment_author' => $this->faker->email(),
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

        $sql = "INSERT INTO {$wpdb->comments}";

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
