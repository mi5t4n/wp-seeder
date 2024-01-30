<?php
/**
 * Post factory.
 */

namespace Sagar\WpSeeder\Factories;

use Sagar\WpSeeder\Abstracts\Factory as Factory;

class PostFactory extends Factory{

    protected $post_type = 'post';

    public function post_type( $post_type ) {
        $this->post_type = $post_type;

        return $this;
    }

    public function definition() {
        $post_title = $this->faker->unique()->text();

        return array(
            'post_title' => $post_title,
            'post_content' => $this->faker->realTextBetween( 100, 360, 5 ),
            'post_excerpt' => $this->faker->paragraph( $this->faker->numberBetween(1,10)),
            'post_type' => $this->post_type,
            'post_status' => $this->faker->randomKey(get_post_stati()),
            'ping_status' => $this->faker->randomElement(['open', 'closed']),
            'comment_status' => $this->faker->randomElement(['open', 'closed']),
            'post_name' => sanitize_title( $post_title),
            'guid' => site_url(sanitize_title( $post_title )),
            'post_date' => $this->faker->dateTimeBetween()->format('Y-m-d H:i:s'),
            'post_date_gmt' => $this->faker->dateTimeBetween()->format('Y-m-d H:i:s'),
            'post_modified' => $this->faker->dateTimeBetween()->format('Y-m-d H:i:s'),
            'post_modified_gmt' => $this->faker->dateTimeBetween()->format('Y-m-d H:i:s'),
        );
    }

    public function query() {

        $count = $this->count;
        $wpdb = $this->wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->posts}";

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
