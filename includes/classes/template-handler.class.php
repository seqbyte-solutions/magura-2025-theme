<?php

namespace Magura2025;

class Magura2025TemplateHandler {
    
    public function __construct() {
        add_action('wp_head', [$this, 'set_head']);
    }

    public function set_head() {
        include get_theme_file_path('/parts/head.php');
    }
}