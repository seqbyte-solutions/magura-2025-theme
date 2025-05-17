<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Magura2025ThemeAdmin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('init', [$this, 'register_custom_role']);
    }

    /**
     * Register a custom role with the can_see_analitics capability
     */
    public function register_custom_role() {
        // Add the custom capability to administrators
        $admin_role = get_role('administrator');
        if ($admin_role) {
            $admin_role->add_cap('can_see_analitics');
        }

        // Create the new role if it doesn't exist
        if (!get_role('analytics_viewer')) {
            add_role(
                'analytics_viewer',
                'Analytics Viewer',
                [
                    'read' => true,
                    'can_see_analitics' => true,
                    'manage_options' => false
                ]
            );
        } else {
            // Update existing role to ensure manage_options is false
            $analytics_role = get_role('analytics_viewer');
            $analytics_role->remove_cap('manage_options');
        }
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Campanie',
            'Campanie',
            'can_see_analitics', // Changed from 'manage_options' to custom capability
            'magura-2025-campaign',
            [$this, 'campaign_analytics'],
            'dashicons-star-filled',
            100
        );
        add_submenu_page(
            'magura-2025-campaign',
            'Înscrieri',
            'Înscrieri',
            'can_see_analitics',
            'magura-2025-campaign-entries',
            [$this, 'campaign_entries']
        );
    }

    public function campaign_analytics()
    {
        // Check if the user has the required capability
        if (!current_user_can('can_see_analitics')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
            return;
        }

        // Include the HTML template for the admin page
        include MAGURA_2025_THEME_PATH . '/templates/admin/campaign-analytics.php';
    }
    
    public function campaign_entries()
    {
        // Check if the user has the required capability
        if (!current_user_can('can_see_analitics')) {
            return;
        }

        // Include the HTML template for the admin page
        include MAGURA_2025_THEME_PATH . '/templates/admin/campaign-entries.php';
    }
}
