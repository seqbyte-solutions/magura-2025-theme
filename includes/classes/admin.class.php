<?php

namespace Magura2025;

if (! defined('ABSPATH')) {
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
        add_action('wp_ajax_get_campaign_entry_reserves', [$this, 'get_campaign_entry_reserves']);
        add_action('wp_ajax_no_priv_get_campaign_entry_reserves', [$this, 'get_campaign_entry_reserves']);

        add_action('wp_ajax_switch_campaign_entry_reserve', [$this, 'switch_campaign_entry_reserve']);
        add_action('wp_ajax_no_priv_switch_campaign_entry_reserve', [$this, 'switch_campaign_entry_reserve']);

        add_action('wp_ajax_validate_campaign_winner', [$this, 'validate_campaign_winner']);
        add_action('wp_ajax_no_priv_validate_campaign_winner', [$this, 'validate_campaign_winner']);
        add_action('wp_ajax_generate_awb', [$this, 'generate_awb']);
        add_action('wp_ajax_no_priv_generate_awb', [$this, 'generate_awb']);
    }

    /**
     * Register a custom role with the can_see_analitics capability
     */
    public function register_custom_role()
    {
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

        // add another role "campaign_manager" with "can_manage_campaigns" capability
        if (!get_role('campaign_manager')) {
            add_role(
                'campaign_manager',
                'Campaign Manager',
                [
                    'read' => true,
                    'can_manage_campaigns' => true,
                    'can_see_analitics' => true,
                    'manage_options' => false
                ]
            );
        } else {
            // Update existing role to ensure manage_options is false
            $campaign_manager_role = get_role('campaign_manager');
            $campaign_manager_role->remove_cap('manage_options');
        }    }

    /**
     * Get the API key from WordPress options or environment variable
     * This is more secure than hardcoding the key in the source code
     */
    private function get_api_key()
    {
        // Try to get from WordPress options first
        $api_key = get_option('magura_api_key');
        
        // If not found in options, try environment variable
        if (empty($api_key)) {
            $api_key = defined('MAGURA_API_KEY') ? MAGURA_API_KEY : '';
        }
        
        // Fallback to the original key if neither option is set
        // Remove this fallback once you've properly configured the key
        if (empty($api_key)) {
            $api_key = 'tUBP2HIACXBvhc6LD47cPQrX7YSk4iBEn7prR7GmtbgOSPN1XtZEMR9u7g65N57OoJx2IEWdCJeV2EJTl9MYH3CL8Q5njzMqqvjRX7b23AOQjhEauLuRvbXT1xXb2qQI';
        }
        
        return $api_key;
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
        }        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/single?entry_id=' . $entry_id;
        $response = wp_remote_get($url, [
            'headers' => [
                'X-API-KEY' => $this->get_api_key(),
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
    public function get_campaign_entry_reserves()
    {
        // Check nonce for security
        check_ajax_referer('entry_data', 'security');

        $entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
        if (empty($entry_id)) {
            wp_send_json_error('Entry ID is required', 400);
            return;
        }        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/available-reserves?entry_id=' . $entry_id;
        $response = wp_remote_get($url, [
            'headers' => [
                'X-API-KEY' => $this->get_api_key(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
        error_log(print_r($url, true)); // Log the response for debugging
        error_log(print_r($response, true)); // Log the response for debugging
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

    public function validate_campaign_winner()
    {
        check_ajax_referer('entry_data', 'security');

        $entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
        if (empty($entry_id)) {
            wp_send_json_error('Entry ID is required', 400);
            return;
        }        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/validate';
        $response = wp_remote_post($url, [
            'headers' => [
                'X-API-KEY' => $this->get_api_key(),
                'Content-Type' => 'application/x-www-form-urlencoded', // Changed content type
                'Accept' => 'application/json'
            ],
            'body' => [ // Direct array instead of json_encode
                'entry_id' => $entry_id,
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
        if (empty($data['data']['entry_id'])) {
            wp_send_json_error('Entry ID is missing in the response', 400);
            return;
        }
        $this->send_validation_email($data['data']);
        wp_send_json_success($data);
    }

    private function send_validation_email($data)
    {
        $to = sanitize_email($data['email']);
        // $to = 'bucel.ionsebastian@gmail.com';
        $prize = $data['prize_name'];
        $entry_id = $data['entry_id'];

        $subject = 'Felicitări! Premiul tău din campania "Câștigă cu Măgura dintr-o îmbrățișare" a fost VALIDAT!';

        $message = 'Dragă câștigătorule,

Avem vești excelente pentru tine!

Suntem încântați să te anunțăm că premiul (' . $prize . ') pe care l-ai câștigat în cadrul campaniei noastre "Câștigă cu Măgura dintr-o îmbrățișare" a fost validat cu succes de către echipa Măgura. Felicitări încă o dată!

Ne apropiem de momentul în care te vei putea bucura de el!

Pentru a putea expedia premiul către tine, următorul pas este să completezi adresa de livrare. Te rugăm să accesezi linkul de mai jos pentru a ne furniza detaliile necesare:
https://magura.ro/validare-castigator/?entry_id=' . $entry_id . '

Te încurajăm să completezi aceste informații cât mai curând posibil, ideal în următoarele 5 zile lucratoare, pentru a ne asigura că premiul ajunge la tine în cel mai scurt timp.

Încă o dată, felicitări pentru câștig și îți mulțumim pentru participarea la campania noastră!


Cu drag,
Echipa Măgura';

        $headers = array('Content-Type: text/plain; charset=UTF-8');
        $headers[] = 'From: Măgura <contact@magura.ro>';
        $headers[] = 'Reply-To: Măgura <contact@magura.ro>';
        $headers[] = 'X-Mailer: PHP/' . phpversion();

        if (wp_mail($to, $subject, $message, $headers)) {
            wp_send_json_success('Email sent successfully');
        } else {
            wp_send_json_error('Failed to send email');
        }
    }

    public function switch_campaign_entry_reserve()
    {
        check_ajax_referer('entry_data', 'security');

        $entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
        if (empty($entry_id)) {
            wp_send_json_error('Entry ID is required', 400);
            return;
        }
        $reserve_id = isset($_POST['reserve_id']) ? sanitize_text_field($_POST['reserve_id']) : '';
        if (empty($reserve_id)) {
            wp_send_json_error('Reserve ID is required', 400);
            return;
        }        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/switch-reserve';
        $response = wp_remote_post($url, [
            'headers' => [
                'X-API-KEY' => $this->get_api_key(),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ],
            'body' => [ // Direct array instead of json_encode
                'entry_id' => $entry_id,
                'reserve_id' => $reserve_id,
            ]
        ]);

        error_log(print_r($url, true)); // Log the response for debugging
        error_log(print_r($response, true)); // Log the response for debugging

        // Check if the response is an error

        if (is_wp_error($response)) {
            wp_send_json_error('Error fetching data', 500);
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if (isset($data['status']) && $data['status'] === 'error') {
            wp_send_json_error($data['error'], 400);
            return;
        }
        wp_send_json_success($data);
    }

    public function generate_awb()
    {
        check_ajax_referer('entry_data', 'security');

        $entry_id = isset($_POST['entry_id']) ? sanitize_text_field($_POST['entry_id']) : '';
        if (empty($entry_id)) {
            wp_send_json_error('Entry ID is required', 400);
            return;
        }        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/generate-awb';
        $response = wp_remote_post($url, [
            'headers' => [
                'X-API-KEY' => $this->get_api_key(),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ],
            'body' => [ // Direct array instead of json_encode
                'entry_id' => $entry_id,
            ]
        ]);
        if (is_wp_error($response)) {
            wp_send_json_error('Error fetching data', 500);
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        error_log(print_r($data, true)); // Log the response for debugging

        if (isset($data['error'])) {
            wp_send_json_error($data['error'], 400);
            return;
        }
        if (empty($data['awb'])) {
            wp_send_json_error('Entry ID is missing in the response', 400);
            return;
        }
        wp_send_json_success($data);
    }
}
