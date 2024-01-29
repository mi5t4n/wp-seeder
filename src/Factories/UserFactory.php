<?php
/**
 * User factory.
 */

namespace Sagar\WpSeeder\Factories;

use Sagar\WpSeeder\Abstracts\Factory;

class UserFactory extends Factory {
    protected $role = 'subscriber';

    public function role( $role ) {
        $this->role = [$role => 1];
        return $this;
    }

    public function definition() {
        return array(
            'user_pass' => $this->faker->password(),
            'user_login' => $this->faker->username(),
            'user_email' => $this->faker->unique()->safeEmail(),
            'user_nicename' => $this->faker->username(),
        );
    }

    public function query() {
        $count = $this->count;
        $wpdb = $this->wpdb();

        if ( ! $wpdb ) {
            return;
        }

        $sql = "INSERT INTO {$wpdb->users}";

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


    public function create() {
        $this->create_users();

        $wpdb = $this->wpdb();
        $row_count = $wpdb->get_var( 'SELECT ROW_COUNT() as rows_affected');
        $last_insert_id = $wpdb->get_var( 'SELECT LAST_INSERT_ID()');

        $this->create_users_meta( $last_insert_id, $last_insert_id + $row_count - 1 );
    }

    protected function create_users() {
        $wpdb = $this->wpdb();

        $sql = $this->query();

        $wpdb->query( $sql );
    }

    protected function create_users_meta( $start_user_id, $end_user_id ) {
        $wpdb = $this->wpdb();
        $sql = "INSERT INTO {$wpdb->usermeta} (user_id, meta_key, meta_value)";

        foreach( range($start_user_id, $end_user_id ) as $user_id ) {
            $values[] =$wpdb->prepare(
                "(%d, %s, %s)",
                $user_id,
                "{$wpdb->base_prefix}capabilities",
                maybe_serialize( $this->role)
            );
        }

        $values = join(',', $values );

        $sql = "{$sql} VALUES {$values};";

        $wpdb->query( $sql );
    }
}
