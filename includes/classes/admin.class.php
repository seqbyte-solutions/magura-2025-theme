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

        add_action('wp_ajax_get_campaign_entry_data', [$this, 'get_campaign_entry_data']);
        add_action('wp_ajax_no_priv_get_campaign_entry_data', [$this, 'get_campaign_entry_data']);
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
        add_submenu_page(
            'magura-2025-campaign',
            'Câștigători',
            'Câștigători',
            'can_see_analitics',
            'magura-2025-campaign-winners',
            [$this, 'campaign_winners']
        );
        add_submenu_page(
            'magura-2025-campaign',
            'Validare câștigători',
            'Validare câștigători',
            'can_see_analitics',
            'magura-2025-campaign-validated-winners',
            [$this, 'campaign_validated_winners']
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
    public function campaign_winners()
    {
        // Check if the user has the required capability
        if (!current_user_can('can_see_analitics')) {
            return;
        }

        // Include the HTML template for the admin page
        include MAGURA_2025_THEME_PATH . '/templates/admin/campaign-winners.php';
    }
    public function campaign_validated_winners()
    {
        // Check if the user has the required capability
        if (!current_user_can('can_see_analitics')) {
            return;
        }

        // Include the HTML template for the admin page
        include MAGURA_2025_THEME_PATH . '/templates/admin/campaign-validated-winners.php';
    }

    public function get_campaign_entry_data()
    {
        // Check if the user has the required capability
        // if (!current_user_can('can_see_analitics')) {
        //     wp_send_json_error('Unauthorized', 401);
        //     return;
        // }

        // Check nonce for security
        check_ajax_referer('entry_data', 'security');

        $entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
        if (empty($entry_id)) {
            wp_send_json_error('Entry ID is required', 400);
            return;
        }

        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/single?id=' . $entry_id;
        $response = wp_remote_get($url, [
            'headers' => [
                'X-API-KEY' => 'tUBP2HIACXBvhc6LD47cPQrX7YSk4iBEn7prR7GmtbgOSPN1XtZEMR9u7g65N57OoJx2IEWdCJeV2EJTl9MYH3CL8Q5njzMqqvjRX7b23AOQjhEauLuRvbXT1xXb2qQI',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
        if (is_wp_error($response)) {
            wp_send_json_error('Error fetching data', 500);
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if (isset($data['error'])) {
            wp_send_json_error($data['error'], 400);
            return;
        }
        wp_send_json_success($data);
    }
}
