<?php
/**
 * Comment factory.
 */

namespace Sagar\WpSeeder\Factories;

use Sagar\WpSeeder\Abstracts\Factory;

class CommentFactory extends Factory {
    public function definition() {
        return array(
            'comment_agent' => $this->faker->userAgent(),
            'comment_approved' => $this->faker->numberBetween(0, 1),
            'comment_author' => $this->faker->name(),
            'comment_author' => $this->faker->email(),
        );
    }

    public function query() {
        $count = $this->count;
        $wpdb = $this->wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->comments}";

        $columns = array_keys( $this->definition());
        $columns = '(' . join(',', $columns) . ')';

        $placeholders = array_fill(0, count( $this->definition() ), '%s');
        $placeholders = '(' . join( ',', $placeholders ) . ')';

        $values = [];
        for( $index = 0 ; $index < $count; ++$index ) {
            $values[] = $wpdb->prepare(
                $placeholders,
                array_values( $this->definition() )
            );
        }

        $values = join(',', $values );

        $sql = "{$sql} {$columns} VALUES {$values};";

        return $sql;
    }
}
