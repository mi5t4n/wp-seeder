<?php
/**
 * Post Meta factory.
 */

namespace Sagar\WpSeeder\Factories;

use Sagar\WpSeeder\Abstracts\Factory as Factory;

class PostMetaFactory extends Factory{

    protected $post_ids = [];

    protected $post_type = 'post';

    public function post_type( $post_type ) {
        $this->post_type = $post_type;

        return $this;
    }

    public function definition() {
        return array(
            'meta_key' => $this->faker->word(),
            'meta_value' => maybe_serialize( $this->faker->word() ),
            'post_id' => $this->faker->randomELement($this->get_posts()),
        );
    }

    public function get_posts() {
        if ( empty($this->post_ids) ) {
            $wpdb = $this->wpdb();

            if ( ! $wpdb ) {
                return;
            }

            $results = $wpdb->get_results(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type='post'"
            );

            $this->post_ids = wp_list_pluck( $results, 'ID' );
        }

        return $this->post_ids;
    }

    public function query() {
        $count = $this->count;
        $wpdb = $this->wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->postmeta} (meta_key, meta_value, post_id)";

        $values = [];
        for( $index = 0 ; $index < $count; ++$index ) {
            $values[] = $wpdb->prepare(
                "(%s, %s, %d)",
                array_values( $this->definition() )
            );
        }

        $values = join(',', $values );

        $sql = "{$sql} VALUES {$values};";

        return $sql;
    }
}
