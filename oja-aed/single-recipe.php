<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $time       = ojaaed_meta('_recipe_time');
    $servings   = ojaaed_meta('_recipe_servings');
    $difficulty = ojaaed_meta('_recipe_difficulty');
    $ingredients = ojaaed_meta('_recipe_ingredients');
    $notes      = ojaaed_meta('_recipe_notes');
    $cats       = get_the_terms(get_the_ID(), 'recipe_cat');
    $cat_name   = $cats && !is_wp_error($cats) ? $cats[0]->name : '';
?>

<!-- Hero -->
<div class="entry-hero">
    <?php if (has_post_thumbnail()) : the_post_thumbnail('ojaaed-hero');
    else : ?><div style="background:linear-gradient(160deg,#2a3d2f,#8b6847);width:100%;height:100%;"></div>
    <?php endif; ?>
    <div class="entry-hero__overlay"></div>
    <div class="entry-hero__content">
        <span class="label"><?php echo $cat_name ? esc_html($cat_name) : esc_html__('Retseptid', 'oja-aed'); ?></span>
        <h1><?php the_title(); ?></h1>
        <div class="entry-meta">
            <?php if ($time)     : ?><span><?php echo esc_html($time); ?></span><?php endif; ?>
            <?php if ($servings) : ?><span><?php echo esc_html($servings . ' ' . __('portsjonit', 'oja-aed')); ?></span><?php endif; ?>
            <?php if ($difficulty): ?><span><?php echo esc_html($difficulty); ?></span><?php endif; ?>
        </div>
    </div>
</div>

<!-- Recipe body -->
<div class="container">
    <div class="recipe-single">

        <!-- Main content -->
        <div class="recipe-single__content">
            <button class="recipe-print-btn btn btn--dark" style="margin-bottom:2rem;" aria-label="<?php esc_attr_e('Prindi retsept', 'oja-aed'); ?>">
                <?php esc_html_e('Prindi retsept', 'oja-aed'); ?>
            </button>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php if ($notes) : ?>
            <div style="background:var(--cream);padding:1.5rem;margin-top:2rem;border-left:3px solid var(--sage);">
                <h4 style="font-size:.72rem;letter-spacing:.15em;text-transform:uppercase;color:var(--sage);margin-bottom:.75rem;"><?php esc_html_e('Märkused', 'oja-aed'); ?></h4>
                <p style="font-size:.95rem;color:var(--stone);"><?php echo nl2br(esc_html($notes)); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="recipe-single__sidebar">
            <!-- Meta card -->
            <div class="recipe-card-meta" style="margin-bottom:1.5rem;">
                <h4><?php esc_html_e('Retsepti info', 'oja-aed'); ?></h4>
                <?php echo ojaaed_recipe_meta_html(); ?>
            </div>

            <!-- Ingredients -->
            <?php if ($ingredients) :
                $items = array_filter(array_map('trim', explode("\n", $ingredients)));
                if ($items) : ?>
            <div class="recipe-card-meta">
                <h4><?php esc_html_e('Koostisosad', 'oja-aed'); ?></h4>
                <ul class="recipe-ingredients">
                    <?php foreach ($items as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; endif; ?>
        </aside>

    </div>
</div>

<!-- Related recipes -->
<?php
$related = new WP_Query([
    'post_type'      => 'recipe',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'rand',
]);
if ($related->have_posts()) : ?>
<section class="section section--cream">
    <div class="container">
        <div class="section-header section-header--centered">
            <span class="label"><?php esc_html_e('Veel retsepte', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Sulle võib meeldida', 'oja-aed'); ?></h2>
        </div>
        <div class="recipe-grid">
            <?php while ($related->have_posts()) : $related->the_post();
                get_template_part('template-parts/content', 'recipe');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer();
