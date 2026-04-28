<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
    <div class="header-inner">

        <!-- Left nav -->
        <nav class="header-nav header-nav--left" aria-label="<?php esc_attr_e('Left navigation', 'oja-aed'); ?>">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'items_wrap'     => '%3$s',
                'depth'          => 1,
                'fallback_cb'    => false,
                'walker'         => new class extends Walker_Nav_Menu {
                    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0) {
                        if ($depth === 0 && $data_object->menu_item_parent == 0) {
                            $output .= '<a href="' . esc_url($data_object->url) . '">' . esc_html($data_object->title) . '</a>';
                        }
                    }
                },
            ]); ?>
            <?php if (!has_nav_menu('primary')) : ?>
                <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>"><?php esc_html_e('Pood', 'oja-aed'); ?></a>
                <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>"><?php esc_html_e('Retseptid', 'oja-aed'); ?></a>
            <?php endif; ?>
        </nav>

        <!-- Logo -->
        <div class="site-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <?php if (has_custom_logo()) :
                    the_custom_logo();
                else : ?>
                    <span class="logo-text">Oja Aed</span>
                <?php endif; ?>
            </a>
        </div>

        <!-- Right nav -->
        <nav class="header-nav header-nav--right" aria-label="<?php esc_attr_e('Right navigation', 'oja-aed'); ?>">
            <?php if (!has_nav_menu('primary')) : ?>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('Blogi', 'oja-aed'); ?></a>
                <a href="<?php echo esc_url(home_url('/meist')); ?>"><?php esc_html_e('Meist', 'oja-aed'); ?></a>
            <?php endif; ?>
            <a href="<?php echo esc_url(home_url('/kontakt')); ?>"><?php esc_html_e('Kontakt', 'oja-aed'); ?></a>
        </nav>

        <!-- Mobile toggle -->
        <button class="menu-toggle" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle menu', 'oja-aed'); ?>">
            <span></span><span></span><span></span>
        </button>

    </div>
</header>

<!-- Mobile nav overlay -->
<nav class="primary-nav" aria-label="<?php esc_attr_e('Mobile navigation', 'oja-aed'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Avaleht', 'oja-aed'); ?></a>
    <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>"><?php esc_html_e('Pood', 'oja-aed'); ?></a>
    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('Blogi', 'oja-aed'); ?></a>
    <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>"><?php esc_html_e('Retseptid', 'oja-aed'); ?></a>
    <a href="<?php echo esc_url(home_url('/meist')); ?>"><?php esc_html_e('Meist', 'oja-aed'); ?></a>
    <a href="<?php echo esc_url(home_url('/kontakt')); ?>"><?php esc_html_e('Kontakt', 'oja-aed'); ?></a>
</nav>

<main id="main" class="site-main">
