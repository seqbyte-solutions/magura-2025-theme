<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Magura2025ThemeApi
{
    private $namespace = 'magura2025/v1';

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_api_routes']);
    }

    public function register_api_routes()
    {
        register_rest_route($this->namespace, '/options', [
            'methods' => 'GET',
            'callback' => [$this, 'get_options'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($this->namespace, '/options', [
            'methods' => 'POST',
            'callback' => [$this, 'update_options'],
            'permission_callback' => '__return_true',
        ]);
    }
}