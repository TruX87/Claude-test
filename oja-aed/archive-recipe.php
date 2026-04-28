<?php get_header(); ?>

<div class="archive-header">
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--left'); ?>
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--right'); ?>
    <div class="container">
        <span class="label"><?php esc_html_e('Oja Aed', 'oja-aed'); ?></span>
        <h1><?php esc_html_e('Retseptid', 'oja-aed'); ?></h1>
        <p><?php esc_html_e('Hooajalised retseptid põllult lauale — lihtsad, kohalikud ja maitsvad.', 'oja-aed'); ?></p>
    </div>
</div>

<!-- Category filter -->
<?php
$recipe_cats = get_terms(['taxonomy' => 'recipe_cat', 'hide_empty' => true]);
if ($recipe_cats && !is_wp_error($recipe_cats)) : ?>
<div class="container">
    <div class="filter-tabs" style="margin-top:2rem;">
        <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>"
           class="filter-tab <?php echo !is_tax('recipe_cat') ? 'is-active' : ''; ?>">
            <?php esc_html_e('Kõik', 'oja-aed'); ?>
        </a>
        <?php foreach ($recipe_cats as $cat) : ?>
        <a href="<?php echo esc_url(get_term_link($cat)); ?>"
           class="filter-tab <?php echo is_tax('recipe_cat', $cat->term_id) ? 'is-active' : ''; ?>">
            <?php echo esc_html($cat->name); ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="container section">
    <?php if (have_posts()) : ?>
    <div class="recipe-grid">
        <?php while (have_posts()) : the_post();
            get_template_part('template-parts/content', 'recipe');
        endwhile; ?>
    </div>
    <div class="pagination">
        <?php the_posts_pagination(['prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
    </div>
    <?php else : ?>
    <p style="text-align:center;color:var(--stone);"><?php esc_html_e('Retsepte ei leitud.', 'oja-aed'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer();
