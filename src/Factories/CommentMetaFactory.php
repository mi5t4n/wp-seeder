<?php
/**
 * Comment Meta factory.
 */

namespace Sagar\WpSeeder\Factories;

use Sagar\WpSeeder\Abstracts\Factory as Factory;

class CommentMetaFactory extends Factory{

    protected $comment_ids = [];

    protected $comment_type = 'comment';

    public function comment_type( $comment_type ) {
        $this->comment_type = $comment_type;

        return $this;
    }

    public function definition() {
        return array(
            'meta_key' => $this->faker->word(),
            'meta_value' => maybe_serialize( $this->faker->word() ),
            'comment_id' => $this->faker->randomELement($this->get_comments()),
        );
    }

    public function get_comments() {
        if ( empty($this->comment_ids) ) {
            $wpdb = $this->wpdb();

            if ( ! $wpdb ) {
                return;
            }

            $results = $wpdb->get_results(
                "SELECT comment_ID FROM {$wpdb->comments} WHERE comment_type='comment'"
            );

            $this->comment_ids = wp_list_pluck( $results, 'comment_ID' );
        }

        return $this->comment_ids;
    }

    public function query() {
        $count = $this->count;
        $wpdb = $this->wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->commentmeta} (meta_key, meta_value, comment_id)";

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
