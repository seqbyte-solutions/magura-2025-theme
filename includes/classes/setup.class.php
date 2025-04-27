<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class Magura2025ThemeSetup
{
    private $theme_pages;
    private $theme_menus;

    public function __construct()
    {
        $this->theme_pages = new Magura2025Pages();
        $this->theme_menus = new Magura2025Menus();

        add_action('after_setup_theme', [$this, 'register_options']);
        add_action('after_switch_theme', [$this, 'theme_activation']);

        add_action('switch_theme', [$this, 'theme_deactivation']);
    }

    public function theme_activation() {
        $this->theme_menus->register_menus();
        $this->theme_pages->create_theme_pages();
        $this->theme_menus->create_default_menus();
    }

    public function register_options() {
        add_option('maintainance_mode', 'true');
    }

    public function theme_deactivation() {
        delete_option('maintainance_mode');
        // remove menus and pages
        $this->theme_menus->remove_menus();
        $this->theme_pages->remove_theme_pages();

    }
}
