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
        add_action('wp', [$this, 'schedule_cron_job']);
        add_action('magura2025_cron_fetch_entries', [$this, 'fetch_entries']);
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

    // schedule a cron job to run every hour
    public function schedule_cron_job() {
        if (!wp_next_scheduled('magura2025_cron_fetch_entries')) {
            wp_schedule_event(time(), 'hourly', 'magura2025_cron_fetch_entries');
        }
    }
    
    public function fetch_entries() {
        $api_url = 'https://api-magura.promoapp.ro/api/v1/entries';
        $response = wp_remote_get($api_url);

        if (is_wp_error($response)) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // if (isset($data['entries'])) {
        //     update_option('magura2025_entries', $data['entries']);
        // }
    }
}
