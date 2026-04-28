<?php get_header(); ?>

<!-- ═══ HERO ═══════════════════════════════════════════════════════════════ -->
<section class="hero" aria-label="<?php esc_attr_e('Hero', 'oja-aed'); ?>">
    <div class="hero-bg">
        <?php if (has_post_thumbnail(get_the_ID())) :
            echo get_the_post_thumbnail(get_the_ID(), 'ojaaed-hero');
        endif; ?>
    </div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <span class="label"><?php esc_html_e('Saaremaa · Eesti', 'oja-aed'); ?></span>
        <h1><?php echo esc_html(get_theme_mod('ojaaed_hero_tagline', 'Kodus kasvatatud. Käsitsi tehtud.')); ?></h1>
        <div class="divider divider--center"></div>
        <p><?php echo esc_html(get_theme_mod('ojaaed_hero_sub', 'Taimed · Käsitöö · Kingitused · Puitesemed')); ?></p>
        <div class="hero-actions">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="btn btn--light"><?php esc_html_e('Vaata poodi', 'oja-aed'); ?></a>
            <a href="<?php echo esc_url(home_url('/meist')); ?>" class="btn btn--light" style="opacity:.7"><?php esc_html_e('Meist', 'oja-aed'); ?></a>
        </div>
    </div>

    <div class="hero-scroll" aria-hidden="true">
        <span><?php esc_html_e('Keri', 'oja-aed'); ?></span>
    </div>
</section>

<!-- ═══ ABOUT STRIP ════════════════════════════════════════════════════════ -->
<section class="about-strip reveal">
    <div class="about-strip__image">
        <?php
        $about_img = get_theme_mod('ojaaed_about_image');
        if ($about_img) : ?>
            <img src="<?php echo esc_url($about_img); ?>" alt="<?php esc_attr_e('Oja Aed perekond', 'oja-aed'); ?>" loading="lazy">
        <?php else : ?>
            <div style="background:linear-gradient(135deg,#2a3d2f 0%,#4a6741 50%,#7a9475 100%);width:100%;height:100%;min-height:540px;"></div>
        <?php endif; ?>
    </div>
    <div class="about-strip__content">
        <?php echo ojaaed_botanical_svg('botanical-svg--lg about-strip__botanical'); ?>
        <span class="label"><?php esc_html_e('Meie lugu', 'oja-aed'); ?></span>
        <h2><?php esc_html_e('Väike aed, suured unistused', 'oja-aed'); ?></h2>
        <div class="divider"></div>
        <p><?php esc_html_e('Oja Aed sündis armastusest looduse ja käsitöö vastu. Kasvatame taimi oma koduaias Saaremaal, valmistame käsitsi kingitusi ja puitesemeid ning jagame retsepte, mis kannavad edasi saare aeglast ja ausat elulaadi.', 'oja-aed'); ?></p>
        <p><?php esc_html_e('Kõik, mida teeme, on tehtud südamega — seemest kätte, puust esemeks, põllult lauale.', 'oja-aed'); ?></p>
        <a href="<?php echo esc_url(home_url('/meist')); ?>" class="btn btn--dark" style="width:fit-content"><?php esc_html_e('Loe rohkem', 'oja-aed'); ?></a>
    </div>
</section>

<!-- ═══ TAGLINE BAND ═══════════════════════════════════════════════════════ -->
<div class="tagline-band">
    <span class="label"><?php esc_html_e('Oja Aed · Saaremaa', 'oja-aed'); ?></span>
    <blockquote>"<?php esc_html_e('Loodus ei kiirusta, aga ta jõuab kõigega.', 'oja-aed'); ?>"</blockquote>
</div>

<!-- ═══ CATEGORIES ═════════════════════════════════════════════════════════ -->
<section>
    <div class="categories-grid">

        <?php
        $cats = [
            ['slug' => 'taimed',     'label' => __('Taimed', 'oja-aed'),     'title' => __('Elavad taimed', 'oja-aed'),    'color' => '#2a3d2f'],
            ['slug' => 'kasitoo',    'label' => __('Käsitöö', 'oja-aed'),    'title' => __('Käsitsi tehtud', 'oja-aed'),   'color' => '#3d5e42'],
            ['slug' => 'kingitused', 'label' => __('Kingitused', 'oja-aed'), 'title' => __('Südamest kingitud', 'oja-aed'), 'color' => '#4a6741'],
            ['slug' => 'puitesemed','label' => __('Puitesemed', 'oja-aed'), 'title' => __('Puust loodud', 'oja-aed'),      'color' => '#8b6847'],
        ];
        foreach ($cats as $cat) :
            $term = get_term_by('slug', $cat['slug'], 'product_cat');
            $url  = $term ? get_term_link($term) : get_post_type_archive_link('product');
        ?>
        <a href="<?php echo esc_url($url); ?>" class="category-card">
            <div class="category-card__bg" style="background:<?php echo esc_attr($cat['color']); ?>;">
                <?php if ($term && $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true)) :
                    echo wp_get_attachment_image($thumb_id, 'ojaaed-product-card');
                endif; ?>
            </div>
            <div class="category-card__overlay"></div>
            <div class="category-card__content">
                <span class="label"><?php echo esc_html($cat['label']); ?></span>
                <h3><?php echo esc_html($cat['title']); ?></h3>
            </div>
        </a>
        <?php endforeach; ?>

    </div>
</section>

<!-- ═══ FEATURED PRODUCTS ══════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header section-header--centered reveal">
            <span class="label"><?php esc_html_e('Poest', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Värsked tooted', 'oja-aed'); ?></h2>
            <p><?php esc_html_e('Kõik tooted on kasvatatud või valmistatud meie koduse aia piires Saaremaal.', 'oja-aed'); ?></p>
        </div>

        <?php
        $products = new WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => 3,
            'meta_key'       => '_product_featured',
            'meta_value'     => '1',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        if (!$products->have_posts()) :
            $products = new WP_Query(['post_type' => 'product', 'posts_per_page' => 3]);
        endif;
        if ($products->have_posts()) : ?>
        <div class="products-grid">
            <?php while ($products->have_posts()) : $products->the_post();
                get_template_part('template-parts/content', 'product');
            endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="btn btn--dark"><?php esc_html_e('Kõik tooted', 'oja-aed'); ?></a>
        </div>
    </div>
</section>

<!-- ═══ BLOG POSTS ═════════════════════════════════════════════════════════ -->
<section class="section section--cream">
    <div class="container">
        <div class="section-header section-header--centered reveal">
            <span class="label"><?php esc_html_e('Blogist', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Aiaelu lood', 'oja-aed'); ?></h2>
            <p><?php esc_html_e('Jagame hooajalisi näpunäiteid, aia-lugusid ja mõtteid looduses elamisest.', 'oja-aed'); ?></p>
        </div>

        <?php
        $posts = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true]);
        if ($posts->have_posts()) : ?>
        <div class="blog-grid">
            <?php while ($posts->have_posts()) : $posts->the_post();
                get_template_part('template-parts/content', 'post');
            endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn--dark"><?php esc_html_e('Kõik postitused', 'oja-aed'); ?></a>
        </div>
    </div>
</section>

<!-- ═══ RECIPES ════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header section-header--centered reveal">
            <span class="label"><?php esc_html_e('Retseptid', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Põllult lauale', 'oja-aed'); ?></h2>
            <p><?php esc_html_e('Hooajalised retseptid, mis kasutavad meie aiast pärit saadusi ja kohalikku toorainet.', 'oja-aed'); ?></p>
        </div>

        <?php
        $recipes = new WP_Query(['post_type' => 'recipe', 'posts_per_page' => 3]);
        if ($recipes->have_posts()) : ?>
        <div class="recipe-grid">
            <?php while ($recipes->have_posts()) : $recipes->the_post();
                get_template_part('template-parts/content', 'recipe');
            endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>" class="btn btn--dark"><?php esc_html_e('Kõik retseptid', 'oja-aed'); ?></a>
        </div>
    </div>
</section>

<!-- ═══ LOCATION ═══════════════════════════════════════════════════════════ -->
<section class="location-strip">
    <div class="location-strip__map">
        <iframe
            src="https://maps.google.com/maps?q=Saaremaa,+Estonia&z=10&output=embed"
            loading="lazy"
            title="<?php esc_attr_e('Oja Aed asukoht', 'oja-aed'); ?>"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    <div class="location-strip__info">
        <span class="label"><?php esc_html_e('Leia meid', 'oja-aed'); ?></span>
        <h2><?php esc_html_e('Saaremaa saarel', 'oja-aed'); ?></h2>
        <div class="divider"></div>
        <address>
            <p><?php echo esc_html(get_theme_mod('ojaaed_address', 'Saaremaa, Eesti')); ?></p>
            <?php if ($email = get_theme_mod('ojaaed_email')) : ?>
                <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
            <?php endif; ?>
            <?php if ($phone = get_theme_mod('ojaaed_phone')) : ?>
                <p><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
            <?php endif; ?>
        </address>
        <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn--dark" style="width:fit-content;margin-top:1rem"><?php esc_html_e('Võta ühendust', 'oja-aed'); ?></a>
    </div>
</section>

<?php get_footer();
