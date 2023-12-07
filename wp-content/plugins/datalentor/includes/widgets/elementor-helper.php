<?php
namespace Elementor;

// Create Category into Elementor.
function dtle_category() {
    Plugin::instance()->elements_manager->add_category(
        'datalentor', [
            'title' => esc_html__('Datalentor', DTLE_DOMAIN),
            'icon' => 'font'
        ], 1
    );
}

add_action('elementor/init', 'Elementor\dtle_category');
?>