<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $cats       = get_the_terms(get_the_ID(), 'product_cat');
    $cat_name   = $cats && !is_wp_error($cats) ? $cats[0]->name : '';
    $cat_url    = $cats && !is_wp_error($cats) ? get_term_link($cats[0]) : get_post_type_archive_link('product');
    $price      = ojaaed_meta('_product_price');
    $currency   = ojaaed_meta('_product_currency') ?: '€';
    $dimensions = ojaaed_meta('_product_dimensions');
    $material   = ojaaed_meta('_product_material');
    $avail      = ojaaed_meta('_product_availability');
    $season     = ojaaed_meta('_product_season');
?>

<!-- Breadcrumb -->
<div style="background:var(--cream);padding:.9rem 0;border-bottom:1px solid var(--cream-mid);">
    <div class="container" style="display:flex;gap:.5rem;align-items:center;font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;color:var(--stone);">
        <a href="<?php echo esc_url(home_url('/')); ?>" style="transition:color .2s;" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--stone)'"><?php esc_html_e('Avaleht', 'oja-aed'); ?></a>
        <span>·</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" style="transition:color .2s;" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--stone)'"><?php esc_html_e('Pood', 'oja-aed'); ?></a>
        <?php if ($cat_name) : ?>
        <span>·</span>
        <a href="<?php echo esc_url($cat_url); ?>" style="transition:color .2s;" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--stone)'"><?php echo esc_html($cat_name); ?></a>
        <?php endif; ?>
        <span>·</span>
        <span style="color:var(--charcoal);"><?php the_title(); ?></span>
    </div>
</div>

<!-- Product single -->
<div class="container">
    <div class="product-single">

        <!-- Gallery -->
        <div class="product-single__gallery">
            <div class="product-single__main-image">
                <?php if (has_post_thumbnail()) : the_post_thumbnail('ojaaed-product-card');
                else : ?><div style="background:linear-gradient(135deg,var(--cream-mid),var(--sand));width:100%;height:100%;min-height:400px;"></div>
                <?php endif; ?>
            </div>
            <?php
            $gallery_ids = get_post_meta(get_the_ID(), '_product_gallery', true);
            if ($gallery_ids) :
                $ids = array_filter(array_map('trim', explode(',', $gallery_ids)));
                if ($ids) : ?>
            <div class="product-single__thumbs">
                <?php foreach (array_slice($ids, 0, 4) as $img_id) :
                    echo wp_get_attachment_image($img_id, 'ojaaed-square', false, ['class' => 'product-single__thumb-img', 'loading' => 'lazy']);
                endforeach; ?>
            </div>
            <?php endif; endif; ?>
        </div>

        <!-- Info -->
        <div class="product-single__info">
            <?php if ($cat_name) : ?>
            <a href="<?php echo esc_url($cat_url); ?>" class="product-single__cat"><?php echo esc_html($cat_name); ?></a>
            <?php endif; ?>

            <h1><?php the_title(); ?></h1>

            <?php if ($price) : ?>
            <div class="product-single__price"><?php echo esc_html($currency . $price); ?></div>
            <?php else : ?>
            <div class="product-single__price" style="font-size:1.1rem;font-style:italic;color:var(--stone);"><?php esc_html_e('Küsi hinda', 'oja-aed'); ?></div>
            <?php endif; ?>

            <div class="product-single__divider"></div>

            <div class="product-single__excerpt">
                <?php the_excerpt(); ?>
            </div>

            <!-- Details grid -->
            <?php if ($dimensions || $material || $avail || $season) : ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;padding:1.5rem;background:var(--cream);">
                <?php if ($material) : ?>
                <div>
                    <div style="font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--stone);margin-bottom:.25rem;"><?php esc_html_e('Materjal', 'oja-aed'); ?></div>
                    <div style="font-family:var(--serif);font-size:1rem;"><?php echo esc_html($material); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($dimensions) : ?>
                <div>
                    <div style="font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--stone);margin-bottom:.25rem;"><?php esc_html_e('Mõõtmed', 'oja-aed'); ?></div>
                    <div style="font-family:var(--serif);font-size:1rem;"><?php echo esc_html($dimensions); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($season) : ?>
                <div>
                    <div style="font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--stone);margin-bottom:.25rem;"><?php esc_html_e('Hooaeg', 'oja-aed'); ?></div>
                    <div style="font-family:var(--serif);font-size:1rem;"><?php echo esc_html($season); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($avail) : ?>
                <div>
                    <div style="font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--stone);margin-bottom:.25rem;"><?php esc_html_e('Saadavus', 'oja-aed'); ?></div>
                    <div style="font-family:var(--serif);font-size:1rem;"><?php echo esc_html($avail); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- CTA -->
            <div class="product-single__contact">
                <p><?php esc_html_e('Huvitab toode? Kirjuta meile — vastame kiiresti ja aitame valida just sinule sobiva.', 'oja-aed'); ?></p>
                <?php if ($email = get_theme_mod('ojaaed_email')) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>?subject=<?php echo esc_attr(sprintf(__('Päring: %s', 'oja-aed'), get_the_title())); ?>" class="btn btn--filled"><?php esc_html_e('Saada päring', 'oja-aed'); ?></a>
                <?php else : ?>
                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="btn btn--filled"><?php esc_html_e('Võta ühendust', 'oja-aed'); ?></a>
                <?php endif; ?>
            </div>

            <!-- Full description -->
            <?php if (get_the_content()) : ?>
            <div class="product-single__divider"></div>
            <div class="entry-content"><?php the_content(); ?></div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Related products -->
<?php
$related = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'rand',
    'tax_query'      => $cats && !is_wp_error($cats) ? [['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => wp_list_pluck($cats, 'term_id')]] : [],
]);
if (!$related->have_posts()) :
    $related = new WP_Query(['post_type' => 'product', 'posts_per_page' => 3, 'post__not_in' => [get_the_ID()], 'orderby' => 'rand']);
endif;
if ($related->have_posts()) : ?>
<section class="section section--cream">
    <div class="container">
        <div class="section-header section-header--centered">
            <span class="label"><?php esc_html_e('Poest veel', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Seotud tooted', 'oja-aed'); ?></h2>
        </div>
        <div class="products-grid">
            <?php while ($related->have_posts()) : $related->the_post();
                get_template_part('template-parts/content', 'product');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer();
