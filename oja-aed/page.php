<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
    <div class="entry-hero">
        <?php the_post_thumbnail('ojaaed-hero'); ?>
        <div class="entry-hero__overlay"></div>
        <div class="entry-hero__content">
            <span class="label"><?php esc_html_e('Oja Aed', 'oja-aed'); ?></span>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
    <?php else : ?>
    <div class="archive-header">
        <div class="container">
            <span class="label"><?php esc_html_e('Oja Aed', 'oja-aed'); ?></span>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
    <?php endif; ?>

    <div class="entry-body container container--narrow">
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer();
