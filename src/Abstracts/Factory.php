<?php
/**
 * Factory class.
 */

namespace Sagar\WpSeeder\Abstracts;

abstract class Factory {
    /**
     * Faker
     *
     * @var Faker\Generator
     */
    protected $faker;

    /**
     * Singleton instance variable.
     *
     * @var self
     */
    protected static $instance;

    /**
     * Count.
     *
     * @var integer
     */
    protected $count = 100;

    abstract public function definition();

    abstract public function query();


    /**
     * Constructor.
     */
    public function __construct(){
        $this->faker = \Faker\Factory::create();
    }

    public static function instance() {
        if(is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function count( $count ) {
        $this->count = $count;

        return $this;
    }

    public function wpdb() {
        return $GLOBALS['wpdb'];
    }

    public function create() {
        $wpdb = $this->wpdb();

        $sql = $this->query();

        $wpdb->query( $sql );
    }
}
