<?php

namespace Sagar\WpSeeder;

class Main {

    /**
     * Cli instance.
     *
     * @var [type]
     */
    protected $cli;

    /**
     * Instance.
     *
     * @var self
     */
    protected static $instance;

    /**
     * Create an instance.
     *
     * @return self
     */
    public static function instance(): self {
        if ( is_null( self::$instance)) {
            self::$instance =  new self;
        }

        return self::$instance;
    }

    public function init(){
        $this->init_hooks();
    }

    public function init_hooks() {
        add_action( 'cli_init', array( $this, 'register_cli_commands' ) );
    }

    public function register_cli_commands() {
        \WP_CLI::add_command( "seeder", Seeder::class );
    }
}
