<?php

namespace Sagar\WpSeeder;

class Main {

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
}
