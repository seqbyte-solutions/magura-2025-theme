<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Magura2025Theme{
    // Singleton instance
    private static $instance = null;

    private Magura2025ThemeSetup $setup;
    private Magura2025TemplateHandler $template_handler;
    private Magura2025ThemeAdmin $admin;
    
    // Make constructor private to prevent direct instantiation
    private function __construct() {
        $this->load_dependencies();
        $this->set_constants();

        $this->setup = new Magura2025ThemeSetup();
        $this->template_handler = new Magura2025TemplateHandler();
        $this->admin = new Magura2025ThemeAdmin();
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
        require_once get_theme_file_path('/includes/classes/admin.class.php');
        require_once get_theme_file_path('/includes/classes/pages.class.php');
        require_once get_theme_file_path('/includes/classes/menus.class.php');
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
        if ( ! defined('MAGURA_API_KEY')) {
            define('MAGURA_API_KEY', 
            'tUBP2HIACXBvhc6LD47cPQrX7YSk4iBEn7prR7GmtbgOSPN1XtZEMR9u7g65N57OoJx2IEWdCJeV2EJTl9MYH3CL8Q5njzMqqvjRX7b23AOQjhEauLuRvbXT1xXb2qQI');
        }
    }

    public function get_template_handler(): Magura2025TemplateHandler
    {
        return $this->template_handler;
    }
}

$GLOBALS['magura2025'] = Magura2025Theme::get_instance();