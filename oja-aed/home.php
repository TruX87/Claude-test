<?php get_header(); ?>

<!-- Archive header -->
<div class="archive-header">
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--left'); ?>
    <?php echo ojaaed_botanical_svg('botanical-svg--lg botanical-svg--right'); ?>
    <div class="container">
        <span class="label"><?php esc_html_e('Oja Aed', 'oja-aed'); ?></span>
        <h1><?php esc_html_e('Aiaelu lood', 'oja-aed'); ?></h1>
        <p><?php esc_html_e('Hooajalised näpunäited, looduse lood ja elu Saaremaa koduaias.', 'oja-aed'); ?></p>
    </div>
</div>

<div class="container section">
    <?php if (have_posts()) : ?>
        <div class="blog-grid blog-grid--featured">
            <?php $first = true;
            while (have_posts()) : the_post();
                if ($first) : $first = false; ?>
                    <!-- Featured post -->
                    <article class="post-card">
                        <div class="post-card__image post-card__image--tall">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : the_post_thumbnail('ojaaed-blog-card');
                                else : ?><div style="background:linear-gradient(135deg,#2a3d2f,#7a9475);width:100%;height:100%;"></div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="post-card__meta">
                            <span class="post-card__cat"><?php the_category(' / '); ?></span>
                            <span class="post-card__date"><?php echo get_the_date('j. F Y'); ?></span>
                        </div>
                        <h2 style="font-size:clamp(1.8rem,3vw,2.8rem);margin-bottom:.75rem;line-height:1.15;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="post-card__read"><?php esc_html_e('Loe edasi', 'oja-aed'); ?></a>
                    </article>
                <?php else : ?>
                    <?php get_template_part('template-parts/content', 'post'); ?>
                <?php endif;
            endwhile; ?>
        </div>

        <div class="pagination">
            <?php the_posts_pagination(['prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('Postitusi ei leitud.', 'oja-aed'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer();
