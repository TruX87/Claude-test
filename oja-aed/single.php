<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- Hero -->
<div class="entry-hero">
    <?php if (has_post_thumbnail()) : the_post_thumbnail('ojaaed-hero');
    else : ?><div style="background:linear-gradient(160deg,#1b2820,#4a6741);width:100%;height:100%;"></div>
    <?php endif; ?>
    <div class="entry-hero__overlay"></div>
    <div class="entry-hero__content">
        <div class="entry-meta">
            <span><?php the_category(' · '); ?></span>
            <span><?php echo get_the_date('j. F Y'); ?></span>
            <span><?php esc_html_e('Autor:', 'oja-aed'); ?> <?php the_author(); ?></span>
        </div>
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<!-- Body -->
<div class="entry-body container container--narrow">
    <div class="entry-content">
        <?php the_content(); ?>
    </div>

    <!-- Tags -->
    <?php $tags = get_the_tags(); if ($tags) : ?>
    <div style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:.5rem;">
        <?php foreach ($tags as $tag) : ?>
        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
           style="font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;border:1px solid var(--cream-mid);padding:.3rem .8rem;color:var(--stone);transition:all .25s;"
           onmouseover="this.style.borderColor='var(--sage)';this.style.color='var(--forest)'"
           onmouseout="this.style.borderColor='var(--cream-mid)';this.style.color='var(--stone)'">
            <?php echo esc_html($tag->name); ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Post nav -->
    <nav class="post-navigation" style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:3rem;padding-top:2rem;border-top:1px solid var(--cream-mid);">
        <?php
        $prev = get_previous_post();
        $next = get_next_post();
        if ($prev) : ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>" style="display:flex;flex-direction:column;gap:.3rem;">
                <span style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:var(--sage);"><?php esc_html_e('Eelmine', 'oja-aed'); ?></span>
                <span style="font-family:var(--serif);font-size:1.1rem;"><?php echo esc_html(get_the_title($prev)); ?></span>
            </a>
        <?php endif;
        if ($next) : ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>" style="display:flex;flex-direction:column;gap:.3rem;text-align:right;margin-left:auto;">
                <span style="font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;color:var(--sage);"><?php esc_html_e('Järgmine', 'oja-aed'); ?></span>
                <span style="font-family:var(--serif);font-size:1.1rem;"><?php echo esc_html(get_the_title($next)); ?></span>
            </a>
        <?php endif; ?>
    </nav>
</div>

<!-- Related posts -->
<?php
$related = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'rand',
]);
if ($related->have_posts()) : ?>
<section class="section section--cream">
    <div class="container">
        <div class="section-header section-header--centered">
            <span class="label"><?php esc_html_e('Loe veel', 'oja-aed'); ?></span>
            <h2><?php esc_html_e('Seotud lood', 'oja-aed'); ?></h2>
        </div>
        <div class="blog-grid">
            <?php while ($related->have_posts()) : $related->the_post();
                get_template_part('template-parts/content', 'post');
            endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer();
