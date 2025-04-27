<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use WP_Error;

class Magura2025Pages
{
    private $theme_pages;

    public function __construct()
    {
        $this->theme_pages = [
            [
                'title'         => 'Acasă',
                'content'       => '',
                'template'      => 'templates/page-home.php',
                'slug'          => 'acasa',
                'parent_id'     => 0,
                'is_front_page' => true,
            ],
            [
                'title'         => 'Îmbrățisările Măgura',
                'content'       => '',
                'template'      => 'templates/page-campaigns-history.php',
                'slug'          => 'imbratisarile-magura',
                'parent_id'     => 0,
                'is_front_page' => false,
            ],
            [
                'title'         => 'Produse participante',
                'content'       => '',
                'template'      => 'templates/page-products.php',
                'slug'          => 'produse-participante',
                'parent_id'     => 0,
                'is_front_page' => false,
            ],
            [
                'title'         => 'Concurs',
                'content'       => '',
                'template'      => 'templates/page-campaign-all.php',
                'slug'          => 'concurs',
                'parent_id'     => 0,
                'is_front_page' => false,
            ],
            [
                'title'         => 'Înscrie-te',
                'content'       => '',
                'template'      => 'templates/page-entry.php',
                'slug'          => 'inscrie-te',
                'parent_id'     => 'concurs',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Cum poți câștiga',
                'content'       => '',
                'template'      => 'templates/page-how-to-win.php',
                'slug'          => 'cum-poti-castiga',
                'parent_id'     => 'concurs',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Premii',
                'content'       => '',
                'template'      => 'templates/page-prizes.php',
                'slug'          => 'premii',
                'parent_id'     => 'concurs',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Câștigători',
                'content'       => '',
                'template'      => 'templates/page-winners.php',
                'slug'          => 'castigatori',
                'parent_id'     => 'concurs',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Regulament',
                'content'       => '',
                'template'      => 'templates/page-utils.php',
                'slug'          => 'regulament',
                'parent_id'     => 'concurs',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Utile',
                'content'       => '',
                'template'      => 'templates/page-utils-all.php',
                'slug'          => 'utile',
                'parent_id'     => 0,
                'is_front_page' => false,
            ],
            [
                'title'         => 'Politica de confidențialitate',
                'content'       => '',
                'template'      => 'templates/page-utils.php',
                'slug'          => 'politica-de-confidentialitate',
                'parent_id'     => 'utile',
                'is_front_page' => false,
            ],
            [
                'title'         => 'Politica de cookies',
                'content'       => '',
                'template'      => 'templates/page-utils.php',
                'slug'          => 'politica-de-cookies',
                'parent_id'     => 'utile',
                'is_front_page' => false,
            ],
        ];
    }

    public function create_theme_pages(): void
    {
        $pages_ids = [];

        foreach ($this->theme_pages as $page) {
            if (!$this->check_if_page_exists($page['slug'])) {
                $temp_data = $page;
                $temp_data['parent_id'] = 0;

                $page_id = $this->create_single_page($temp_data);

                if ($page_id) {
                    $pages_ids[$page['slug']] = $page_id;

                    if (isset($page['is_front_page']) && $page['is_front_page'] === true) {
                        update_option('show_on_front', 'page');
                        update_option('page_on_front', $page_id);
                    }
                }
            } else {
                $existing_page = get_page_by_path($page['slug']);
                if ($existing_page) {
                    $pages_ids[$page['slug']] = $existing_page->ID;
                }
            }
        }

        foreach ($this->theme_pages as $page) {
            if (is_string($page['parent_id']) && isset($pages_ids[$page['parent_id']])) {
                if (isset($pages_ids[$page['slug']])) { 
                    wp_update_post([
                        'ID' => $pages_ids[$page['slug']],
                        'post_parent' => $pages_ids[$page['parent_id']]
                    ]);
                } else {
                    error_log('Warning: Undefined array key for slug '.$page['slug']);
                }
            }
        }
    }

    private function check_if_page_exists(string $slug): bool
    {
        $page = get_posts([
            'name' => $slug,
            'post_type' => 'page',
        ]);
        return !empty($page) ? true : false;
    }

    private function create_single_page(array $page_data): int | WP_Error
    {
        $page = [
            'post_title' => $page_data['title'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_parent' => $page_data['parent_id'],
            'post_name' => $page_data['slug'],
        ];

        if (isset($page_data['template'])) {
            $page['post_template'] = $page_data['template'];
        }

        return wp_insert_post($page);
    }

    public function get_theme_pages(): array
    {
        return $this->theme_pages;
    }

    public function remove_theme_pages(): void
    {
        foreach ($this->theme_pages as $page) {
            $existing_page = get_page_by_path($page['slug']);
            if ($existing_page) {
                wp_delete_post($existing_page->ID, true);
            }
        }
    }
}