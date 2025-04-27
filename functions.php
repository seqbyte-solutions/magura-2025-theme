<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

namespace Magura2025;

class Magura2025Theme{
    // Singleton instance
    private static $instance = null;
    
    // Make constructor private to prevent direct instantiation
    private function __construct() {
        $this->load_dependencies();
        $this->set_constants();
    }
    
    /**
     * Get singleton instance
     * 
     * @return Magura2025Theme The single instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function load_dependencies() {
        require_once get_theme_file_path('/includes/classes/setup.class.php');
        require_once get_theme_file_path('/includes/classes/template-handler.class.php');
    }

    private function set_constants() {
        if ( ! defined( 'MAGURA_2025_THEME_URL' ) ) {
            define( 'MAGURA_2025_THEME_URL', get_template_directory_uri() );
        }
        if ( ! defined( 'MAGURA_2025_THEME_PATH' ) ) {
            define( 'MAGURA_2025_THEME_PATH', get_template_directory() );
        }
    }
}

$GLOBALS['magura2025'] = Magura2025Theme::get_instance();