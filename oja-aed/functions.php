<?php
/**
 * Oja Aed Theme Functions
 * Nordic family garden business — Saaremaa, Estonia
 */

defined('ABSPATH') || exit;

// ─── Theme Setup ────────────────────────────────────────────────────────────

function ojaaed_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    add_image_size('ojaaed-hero',         1920, 1080, true);
    add_image_size('ojaaed-product-card', 600,  750,  true);
    add_image_size('ojaaed-blog-card',    800,  560,  true);
    add_image_size('ojaaed-recipe-card',  700,  520,  true);
    add_image_size('ojaaed-square',       600,  600,  true);

    register_nav_menus([
        'primary' => __('Primary Navigation', 'oja-aed'),
        'footer'  => __('Footer Navigation', 'oja-aed'),
    ]);

    load_theme_textdomain('oja-aed', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'ojaaed_setup');

// ─── Assets ─────────────────────────────────────────────────────────────────

function ojaaed_enqueue_assets() {
    wp_enqueue_style(
        'ojaaed-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Jost:wght@300;400;500;600&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'ojaaed-style',
        get_template_directory_uri() . '/assets/css/main.css',
        ['ojaaed-fonts'],
        '1.0.0'
    );
    wp_enqueue_script(
        'ojaaed-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true
    );
    wp_localize_script('ojaaed-main', 'ojaaed', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ojaaed_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'ojaaed_enqueue_assets');

// ─── Widget Areas ────────────────────────────────────────────────────────────

function ojaaed_widgets_init() {
    $shared = [
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ];

    register_sidebar(array_merge($shared, [
        'name'        => __('Blog Sidebar', 'oja-aed'),
        'id'          => 'blog-sidebar',
        'description' => __('Appears on blog pages.', 'oja-aed'),
    ]));

    register_sidebar(array_merge($shared, [
        'name'        => __('Footer Column 1', 'oja-aed'),
        'id'          => 'footer-1',
        'description' => __('Footer left column.', 'oja-aed'),
    ]));
}
add_action('widgets_init', 'ojaaed_widgets_init');

// ─── Custom Post Types ───────────────────────────────────────────────────────

function ojaaed_register_post_types() {
    // Products
    register_post_type('product', [
        'labels' => [
            'name'          => __('Products', 'oja-aed'),
            'singular_name' => __('Product', 'oja-aed'),
            'add_new_item'  => __('Add New Product', 'oja-aed'),
            'edit_item'     => __('Edit Product', 'oja-aed'),
            'view_item'     => __('View Product', 'oja-aed'),
            'not_found'     => __('No products found', 'oja-aed'),
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'pood'],
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'     => 'dashicons-cart',
        'show_in_rest'  => true,
        'menu_position' => 5,
    ]);

    // Recipes
    register_post_type('recipe', [
        'labels' => [
            'name'          => __('Recipes', 'oja-aed'),
            'singular_name' => __('Recipe', 'oja-aed'),
            'add_new_item'  => __('Add New Recipe', 'oja-aed'),
            'edit_item'     => __('Edit Recipe', 'oja-aed'),
            'view_item'     => __('View Recipe', 'oja-aed'),
            'not_found'     => __('No recipes found', 'oja-aed'),
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'retseptid'],
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'     => 'dashicons-food',
        'show_in_rest'  => true,
        'menu_position' => 6,
    ]);
}
add_action('init', 'ojaaed_register_post_types');

// ─── Taxonomies ──────────────────────────────────────────────────────────────

function ojaaed_register_taxonomies() {
    register_taxonomy('product_cat', 'product', [
        'labels'       => [
            'name'          => __('Product Categories', 'oja-aed'),
            'singular_name' => __('Product Category', 'oja-aed'),
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'toote-kategooria'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('recipe_cat', 'recipe', [
        'labels'       => [
            'name'          => __('Recipe Categories', 'oja-aed'),
            'singular_name' => __('Recipe Category', 'oja-aed'),
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'retsepti-kategooria'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'ojaaed_register_taxonomies');

// ─── Helpers ─────────────────────────────────────────────────────────────────

function ojaaed_meta(string $key, ?int $post_id = null): string {
    return (string) get_post_meta($post_id ?: get_the_ID(), $key, true);
}

function ojaaed_botanical_svg(string $class = '', string $color = 'currentColor'): string {
    return sprintf(
        '<svg class="botanical-svg %s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 300" fill="none" aria-hidden="true">
            <path d="M60 290 C60 230 60 170 60 80 C60 50 60 20 60 5" stroke="%s" stroke-width="1.2" stroke-linecap="round"/>
            <path d="M60 240 C40 218 22 205 8 190" stroke="%s" stroke-width="0.9" stroke-linecap="round"/>
            <path d="M60 205 C82 185 97 172 112 158" stroke="%s" stroke-width="0.9" stroke-linecap="round"/>
            <path d="M60 168 C36 148 20 132 6 116" stroke="%s" stroke-width="0.9" stroke-linecap="round"/>
            <path d="M60 135 C85 117 100 103 115 88" stroke="%s" stroke-width="0.9" stroke-linecap="round"/>
            <path d="M60 100 C42 83 30 68 20 50" stroke="%s" stroke-width="0.9" stroke-linecap="round"/>
            <ellipse cx="6" cy="186" rx="15" ry="9" transform="rotate(-38 6 186)" stroke="%s" stroke-width="0.8"/>
            <ellipse cx="114" cy="154" rx="15" ry="9" transform="rotate(38 114 154)" stroke="%s" stroke-width="0.8"/>
            <ellipse cx="4" cy="112" rx="14" ry="8" transform="rotate(-42 4 112)" stroke="%s" stroke-width="0.8"/>
            <ellipse cx="116" cy="84" rx="14" ry="8" transform="rotate(42 116 84)" stroke="%s" stroke-width="0.8"/>
            <ellipse cx="18" cy="46" rx="13" ry="7" transform="rotate(-48 18 46)" stroke="%s" stroke-width="0.8"/>
        </svg>',
        esc_attr($class),
        ...array_fill(0, 12, esc_attr($color))
    );
}

function ojaaed_price(?int $post_id = null): string {
    $price    = ojaaed_meta('_product_price', $post_id);
    $currency = ojaaed_meta('_product_currency', $post_id) ?: '€';
    if ($price) {
        return '<span class="product-price">' . esc_html($currency) . esc_html($price) . '</span>';
    }
    return '<span class="product-price product-price--inquiry">' . esc_html__('Küsi hinda', 'oja-aed') . '</span>';
}

function ojaaed_recipe_meta_html(?int $post_id = null): string {
    $time       = ojaaed_meta('_recipe_time', $post_id);
    $servings   = ojaaed_meta('_recipe_servings', $post_id);
    $difficulty = ojaaed_meta('_recipe_difficulty', $post_id);

    $html = '<div class="recipe-meta-row">';
    if ($time)       $html .= '<div class="recipe-meta-item"><span class="rmi-label">' . esc_html__('Aeg', 'oja-aed') . '</span><span class="rmi-value">' . esc_html($time) . '</span></div>';
    if ($servings)   $html .= '<div class="recipe-meta-item"><span class="rmi-label">' . esc_html__('Portsjoneid', 'oja-aed') . '</span><span class="rmi-value">' . esc_html($servings) . '</span></div>';
    if ($difficulty) $html .= '<div class="recipe-meta-item"><span class="rmi-label">' . esc_html__('Raskusaste', 'oja-aed') . '</span><span class="rmi-value">' . esc_html($difficulty) . '</span></div>';
    $html .= '</div>';
    return $html;
}

function ojaaed_thumbnail_url(string $size = 'ojaaed-blog-card', ?int $post_id = null): string {
    $post_id = $post_id ?: get_the_ID();
    if (has_post_thumbnail($post_id)) {
        return (string) get_the_post_thumbnail_url($post_id, $size);
    }
    return '';
}

// ─── Excerpt ─────────────────────────────────────────────────────────────────

add_filter('excerpt_length', fn() => 22);
add_filter('excerpt_more',   fn() => '&hellip;');

// ─── Body Classes ────────────────────────────────────────────────────────────

add_filter('body_class', function (array $classes): array {
    if (is_singular())    $classes[] = 'is-singular';
    if (is_front_page())  $classes[] = 'is-front';
    return $classes;
});

// ─── Customizer ──────────────────────────────────────────────────────────────

function ojaaed_customize_register(WP_Customize_Manager $wp_customize): void {
    // Hero
    $wp_customize->add_section('ojaaed_hero', [
        'title'    => __('Hero Section', 'oja-aed'),
        'priority' => 30,
    ]);
    foreach ([
        'ojaaed_hero_tagline' => ['label' => 'Hero Tagline',  'default' => 'Kodus kasvatatud. Käsitsi tehtud.'],
        'ojaaed_hero_sub'     => ['label' => 'Hero Subtext',  'default' => 'Taimed · Käsitöö · Kingitused · Puitesemed'],
    ] as $id => $args) {
        $wp_customize->add_setting($id, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage']);
        $wp_customize->add_control($id, ['label' => $args['label'], 'section' => 'ojaaed_hero', 'type' => 'text']);
    }

    // Contact
    $wp_customize->add_section('ojaaed_contact', ['title' => __('Contact & Social', 'oja-aed'), 'priority' => 35]);
    foreach ([
        'ojaaed_address'   => ['label' => 'Address',   'default' => 'Saaremaa, Eesti',  'sanitize' => 'sanitize_text_field', 'type' => 'text'],
        'ojaaed_email'     => ['label' => 'Email',     'default' => '',                  'sanitize' => 'sanitize_email',      'type' => 'email'],
        'ojaaed_phone'     => ['label' => 'Phone',     'default' => '',                  'sanitize' => 'sanitize_text_field', 'type' => 'text'],
        'ojaaed_instagram' => ['label' => 'Instagram', 'default' => '',                  'sanitize' => 'esc_url_raw',         'type' => 'url'],
        'ojaaed_facebook'  => ['label' => 'Facebook',  'default' => '',                  'sanitize' => 'esc_url_raw',         'type' => 'url'],
    ] as $id => $args) {
        $wp_customize->add_setting($id, ['default' => $args['default'], 'sanitize_callback' => $args['sanitize']]);
        $wp_customize->add_control($id, ['label' => $args['label'], 'section' => 'ojaaed_contact', 'type' => $args['type']]);
    }
}
add_action('customize_register', 'ojaaed_customize_register');

// ─── Flush rewrite on theme switch ───────────────────────────────────────────

add_action('after_switch_theme', function () {
    ojaaed_register_post_types();
    ojaaed_register_taxonomies();
    flush_rewrite_rules();
});
