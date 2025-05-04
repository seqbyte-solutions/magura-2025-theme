<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class Magura2025TemplateHandler {
    
    public function __construct() {
        add_action('wp_head', [$this, 'set_head']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function set_head() {
        include get_theme_file_path('/parts/head.php');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('gsap', MAGURA_2025_THEME_URL . '/assets/js/gsap-public/minified/gsap.min.js', [], '3.13.0');
    }

    public function enqueue_styles() {
        wp_enqueue_style('theme-globals', MAGURA_2025_THEME_URL . '/assets/css/globals.css'); 
        wp_enqueue_style('theme-styles', MAGURA_2025_THEME_URL . '/assets/css/style.css',['theme-globals']); 
        wp_enqueue_style('theme-header-styles', MAGURA_2025_THEME_URL . '/assets/css/header.css',['theme-globals']); 
        wp_enqueue_style('theme-footer-styles', MAGURA_2025_THEME_URL . '/assets/css/footer.css',['theme-globals']); 
        wp_enqueue_style('theme-media-queries', MAGURA_2025_THEME_URL . '/assets/css/media-queries.css',['theme-globals', 'theme-styles', 'theme-header-styles', 'theme-footer-styles']);
    }

    public function render(): void
    {
        global $post;

        if (is_404()) {
            $this->render404();
            return;
        }

        error_log('Template maintenance mode check: ' . get_option('maintainance_mode'));

        if (get_option('maintainance_mode') === 'true' && !is_user_logged_in() && !is_admin() && !(current_user_can('administrator') || current_user_can('editor'))) {
            $this->render_maintenance_page();
            return;
        }

        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="ro">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>
               <?php
                if(is_front_page()) {
                    echo 'Câștigă cu Măgura dintr-o îmbratișare! | Măgura';
                } else {
                    echo get_the_title($post->ID) . ' | Măgura';
                }
               ?> 
            </title>

            <?php
            wp_head();
            ?>
        </head>
        <body>
            <?php
            get_template_part('parts/header');
            ?>

            <main>
                <?php
                    $this->render_page_template();
                ?>
            </main>

            <?php
            get_template_part('parts/footer');
            wp_footer();
            ?>
        </body>
        </html>
        <?php
        $output = ob_get_clean();
        echo $output;
        ob_end_flush();
        exit;
    }

    private function render_page_template(): void
    {
        global $post;

        $page_slug = $post->post_name;

        $theme_pages = new Magura2025Pages();
        $pages = $theme_pages->get_theme_pages();

        foreach ($pages as $page) {
            if($page['slug'] === $page_slug) {
                $page_template = strtr($page['template'], ['.php' => '']);
                break;
            }
        }
        get_template_part($page_template);
    }

    private function render_maintenance_page(): void
    {
        ob_start();
        get_template_part('templates/maintenance');

        $output = ob_get_clean();
        echo $output;
        ob_end_flush();
        exit;
    }

    private function render404(): void
    {
        status_header(404);
        nocache_headers();
        get_template_part('templates/404');
    }
}