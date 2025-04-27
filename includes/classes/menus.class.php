<?php

namespace Magura2025;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Magura2025Menus
{
    private $menu_locations;
    private $menu_items;

    public function __construct()
    {
        $this->menu_locations = [
            'header-primary' => 'Header primary',
            'header-mobile-primary' => 'Header mobile primary',
            'footer'  => 'Footer primary',
            'footer-utils'  => 'Footer utils',
        ];

        $this->menu_items = [
            'header-primary' => [
                [
                    'title' => 'Înscrie-te',
                    'type' => 'page',
                    'page_slug' => 'inscrie-te',
                ],
                [
                    'title' => 'Concurs',
                    'type' => 'custom',
                    'url' => '#',
                    'children' => [
                        [
                            'title' => 'Cum poți câștiga',
                            'type' => 'page',
                            'page_slug' => 'cum-poti-castiga',
                        ],
                        [
                            'title' => 'Premii',
                            'type' => 'page',
                            'page_slug' => 'premii',
                        ],
                        [
                            'title' => 'Câștigători',
                            'type' => 'page',
                            'page_slug' => 'castigatori',
                        ],
                        [
                            'title' => 'Regulament',
                            'type' => 'page',
                            'page_slug' => 'regulament',
                        ],
                    ],
                ],
                [
                    'title' => 'Produse participante',
                    'type' => 'page',
                    'page_slug' => 'produse-participante',
                ],

                [
                    'title' => 'Îmbrățisările Măgura',
                    'type' => 'page',
                    'page_slug' => 'imbratisarile-magura',
                ]
            ],
            'header-mobile-primary' => [
                [
                    'title' => 'Acasă',
                    'type' => 'page',
                    'page_slug' => 'acasa',
                ],
                [
                    'title' => 'Înscrie-te',
                    'type' => 'page',
                    'page_slug' => 'inscrie-te',
                ],
                [
                    'title' => 'Cum poți câștiga',
                    'type' => 'page',
                    'page_slug' => 'cum-poti-castiga',
                ],
                [
                    'title' => 'Premii',
                    'type' => 'page',
                    'page_slug' => 'premii',
                ],
                [
                    'title' => 'Câștigători',
                    'type' => 'page',
                    'page_slug' => 'castigatori',
                ],
                [
                    'title' => 'Regulament',
                    'type' => 'page',
                    'page_slug' => 'regulament',
                ],
                [
                    'title' => 'Produse participante',
                    'type' => 'page',
                    'page_slug' => 'produse-participante',
                ],

                [
                    'title' => 'Îmbrățisările Măgura',
                    'type' => 'page',
                    'page_slug' => 'imbratisarile-magura',
                ]
            ],
            'footer' => [
                [
                    'title' => 'Acasă',
                    'type' => 'page',
                    'page_slug' => 'acasa',
                ],
                [
                    'title' => 'Înscrie-te',
                    'type' => 'page',
                    'page_slug' => 'inscrie-te',
                ],
                [
                    'title' => 'Cum poți câștiga',
                    'type' => 'page',
                    'page_slug' => 'cum-poti-castiga',
                ],
                [
                    'title' => 'Premii',
                    'type' => 'page',
                    'page_slug' => 'premii',
                ],
                [
                    'title' => 'Câștigători',
                    'type' => 'page',
                    'page_slug' => 'castigatori',
                ],
                
                [
                    'title' => 'Produse participante',
                    'type' => 'page',
                    'page_slug' => 'produse-participante',
                ],

                [
                    'title' => 'Îmbrățisările Măgura',
                    'type' => 'page',
                    'page_slug' => 'imbratisarile-magura',
                ]
            ],
            'footer-utils' => [
                [
                    'title' => 'Regulament',
                    'type' => 'page',
                    'page_slug' => 'regulament',
                ],
                [
                    'title' => 'Politica de confidențialitate',
                    'type' => 'page',
                    'page_slug' => 'politica-de-confidentialitate',
                ],
                [
                    'title' => 'Politica de cookies',
                    'type' => 'page',
                    'page_slug' => 'politica-de-cookies',
                ],
            ],
        ];

        add_action('init', [$this, 'register_menus']);
    }

    public function register_menus(): void
    {
        register_nav_menus($this->menu_locations);
    }

    public function create_default_menus(): void
    {
        foreach ($this->menu_locations as $location => $menu_name) {
            $menu_exists = wp_get_nav_menu_object($menu_name);
            if (!$menu_exists) {
                $this->create_single_menu($location, $menu_name);
            }
        }
    }

    private function create_single_menu(string $location, string $menu_name): void
    {
        $menu_id = wp_create_nav_menu($menu_name);
        if (is_wp_error($menu_id)) {
            return;
        }

        $locactions = get_theme_mod('nav_menu_locations');
        $locactions[$location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locactions);
        if (isset($this->menu_items[$location])) {
            $this->create_menu_item($menu_id, $this->menu_items[$location]);
        }
    }

    private function create_menu_item($menu_id, $items, $parent_id = 0): void
    {
        foreach ($items as $item) {
            if ($item['type'] === 'custom') {
                $item_id = wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => $item['url'],
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $parent_id,
                ]);
            } elseif ($item['type'] === 'page') {
                $page = get_posts([
                    'name' => $item['page_slug'],
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'numberposts' => 1,
                ])[0] ?? null;

                if ($page) {
                    $item_id = wp_update_nav_menu_item($menu_id, 0, [
                        'menu-item-object-id' => $page->ID,
                        'menu-item-object' => 'page',
                        'menu-item-type' => 'post_type',
                        'menu-item-title' => $item['title'],
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => $parent_id,
                    ]);
                }
            }

            if (isset($item['children'])) {
                $this->create_menu_item($menu_id, $item['children'], $item_id);
            }
        }
    }

    public function remove_menus(): void
    {
        foreach ($this->menu_locations as $location => $menu_name) {
            $menu = wp_get_nav_menu_object($menu_name);
            if ($menu) {
                wp_delete_nav_menu($menu->term_id);
            }
        }
    }
}
