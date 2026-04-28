<?php get_header(); ?>

<!-- Archive header -->
<div class="archive-header">
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--left'); ?>
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--right'); ?>
    <div class="container">
        <span class="label"><?php esc_html_e('Oja Aed', 'oja-aed'); ?></span>
        <h1><?php esc_html_e('Meie pood', 'oja-aed'); ?></h1>
        <p><?php esc_html_e('Kõik kasvatatud ja valmistatud meie koduaias Saaremaal — südamega ja hoolikalt.', 'oja-aed'); ?></p>
    </div>
</div>

<!-- Category filter -->
<?php
$product_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
if ($product_cats && !is_wp_error($product_cats)) : ?>
<div class="container">
    <div class="filter-tabs" style="margin-top:2rem;">
        <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>"
           class="filter-tab <?php echo !is_tax('product_cat') ? 'is-active' : ''; ?>">
            <?php esc_html_e('Kõik', 'oja-aed'); ?>
        </a>
        <?php foreach ($product_cats as $cat) : ?>
        <a href="<?php echo esc_url(get_term_link($cat)); ?>"
           class="filter-tab <?php echo is_tax('product_cat', $cat->term_id) ? 'is-active' : ''; ?>">
            <?php echo esc_html($cat->name); ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Products grid -->
<div class="container section">
    <?php if (have_posts()) : ?>
    <div class="products-grid">
        <?php while (have_posts()) : the_post();
            get_template_part('template-parts/content', 'product');
        endwhile; ?>
    </div>
    <div class="pagination">
        <?php the_posts_pagination(['prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
    </div>
    <?php else : ?>
    <div style="text-align:center;padding:4rem 0;">
        <p style="color:var(--stone);margin-bottom:1.5rem;"><?php esc_html_e('Selles kategoorias ei ole hetkel tooteid.', 'oja-aed'); ?></p>
        <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="btn btn--dark"><?php esc_html_e('Vaata kõiki tooteid', 'oja-aed'); ?></a>
    </div>
    <?php endif; ?>
</div>

<?php get_footer();
