<?php
// Used to define custom function used in Datalentor Plugin.

function dtle_get_page_templates($type = null) {
    $args = [
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
    ];

    if ($type) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'elementor_library_type',
                'field' => 'slug',
                'terms' => $type,
            ],
        ];
    }

    $page_templates = get_posts($args);
    $options = array();

    if (!empty($page_templates) && !is_wp_error($page_templates)) {
        foreach ($page_templates as $post) {
            $options[$post->ID] = $post->post_title;
        }
    }
    return $options;
}
