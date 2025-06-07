<?php

namespace Magura2025;

if (! defined('ABSPATH')) {
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
        add_action('magura2025_cron_send_expiry_email', [$this, 'send_expiry_email']);

        // Add custom cron schedule
        add_filter('cron_schedules', [$this, 'add_cron_interval']);

        // open ajax endpoint to send an email
        add_action("wp_ajax_magura_send_email", [$this, 'send_email']);
        add_action("wp_ajax_nopriv_magura_send_email", [$this, 'send_email']);
    }

    public function theme_activation()
    {
        $this->theme_menus->register_menus();
        $this->theme_pages->create_theme_pages();
        $this->theme_menus->create_default_menus();
    }

    public function register_options()
    {
        add_option('maintainance_mode', 'false');
        add_option('campaign_entries', []);
    }

    public function theme_deactivation()
    {
        delete_option('maintainance_mode');
        // remove menus and pages
        $this->theme_menus->remove_menus();
        $this->theme_pages->remove_theme_pages();
    }

    // Add custom minutely schedule
    public function add_cron_interval($schedules)
    {
        $schedules['minutely'] = array(
            'interval' => 60, // 60 seconds
            'display'  => esc_html__('Every Minute', 'magura-2025-theme'),
        );
        return $schedules;
    }

    // schedule a cron job to run every minute
    public function schedule_cron_job()
    {
        if (!wp_next_scheduled('magura2025_cron_fetch_entries')) {
            wp_schedule_event(time(), 'hourly', 'magura2025_cron_fetch_entries');
        }
        if (!wp_next_scheduled('magura2025_cron_send_expiry_email')) {
            wp_schedule_event(time(), 'daily', 'magura2025_cron_send_expiry_email');
        }
    }

    public function fetch_entries()
    {
        $api_url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries';
        $headers = [
            'X-API-KEY' => MAGURA_API_KEY
        ];
        $response = wp_remote_get(
            $api_url,
            [
                'headers' => $headers,
            ]
        );

        if (is_wp_error($response)) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data['data'])) {
            update_option('campaign_entries', $data['data']);
        }
    }

    public function send_email()
    {
        check_ajax_referer('send_email_nonce', 'security');

        $to = sanitize_email($_POST['email']);
        $prize = sanitize_text_field($_POST['prize']);
        $entry_id = sanitize_text_field($_POST['entry_id']);
        $prize = $prize === 'Vacanta' ? "Voucher Îmbrățisează România" : ($prize === 'Set Magura' ? 'Set Măgura' : 'Rucsac Măgura');
        $subject = 'Ai pus mâna pe un premiu!';

        $message = "Felicitări!

Hei, se pare că norocul ți-a zâmbit!
Ai pus mâna pe un premiu: " . $prize . "

ID înscriere: " . $entry_id . "\n\n

O zi plină de îmbrățișări!
Echipa Măgura";


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

    public function send_expiry_email()
    {
        $api_url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/validations/pending';
        $headers = [
            'X-API-KEY' => MAGURA_API_KEY
        ];
        $response = wp_remote_get(
            $api_url,
            [
                'headers' => $headers,
            ]
        );

        if (is_wp_error($response)) {
            error_log('Error fetching pending validations: ' . $response->get_error_message());
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        foreach ($data['data'] as $entry) {
            $entry_id = $entry['entry_uuid'];
            $expires_at = $entry['expires_at'];

            $to = sanitize_email($entry['email']);
            $prize = $entry['prize_name'] === 'Vacanta' ? "Voucher Îmbrățisează România" : ($entry['prize_name'] === 'Set Magura' ? 'Set Măgura' : 'Rucsac Măgura');
            $subject = 'Revendicarea premiului dvs. expiră în curând!';
            $message = "Hei,
            
            Se pare că încă nu ai completat formularul de revendicare a premiului tău: " . $prize . "
            Poți completa formularul aici: 
            https://magura.ro/validare-castigator/?entry_id=" . $entry_id . "
            
            Acest link este valabil până la data de " . date('d.m.Y', strtotime($expires_at)) . ". După această dată, înscrierea dvs. va fi considerată invalidă și nu veți mai putea revendica premiul.

            O zi plină de îmbrățișări!
            Echipa Măgura
            ";


            $headers = array('Content-Type: text/plain; charset=UTF-8');
            $headers[] = 'From: Măgura <contact@magura.ro>';
            $headers[] = 'Reply-To: Măgura <contact@magura.ro>';
            $headers[] = 'X-Mailer: PHP/' . phpversion();

            wp_mail($to, $subject, $message, $headers);
        }
        foreach ($data['expired_validations'] as $entry) {
            $entry_id = $entry['entry_uuid'];
            $expires_at = $entry['expires_at'];

            $to = sanitize_email($entry['email']);
            $prize = $entry['prize_name'] === 'Vacanta' ? "Voucher Îmbrățisează România" : ($entry['prize_name'] === 'Set Magura' ? 'Set Măgura' : 'Rucsac Măgura');
            $subject = 'Revendicarea premiului dvs. a expirat!';
            $message = "Hei,
            
            Se pare că încă nu ai completat formularul de revendicare a premiului tău: " . $prize . ".
            Din păcate, acest link a expirat pe " . date('d.m.Y', strtotime($expires_at)) . " și nu mai puteți revendica premiul dvs.. 

            O zi plină de îmbrățișări!
            Echipa Măgura
            ";


            $headers = array('Content-Type: text/plain; charset=UTF-8');
            $headers[] = 'From: Măgura <contact@magura.ro>';
            $headers[] = 'Reply-To: Măgura <contact@magura.ro>';
            $headers[] = 'X-Mailer: PHP/' . phpversion();
            wp_mail($to, $subject, $message, $headers);
        }
    }
}
