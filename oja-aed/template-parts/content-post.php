<article class="post-card reveal">
    <div class="post-card__image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) :
                the_post_thumbnail('ojaaed-blog-card', ['loading' => 'lazy']);
            else : ?>
                <div style="background:linear-gradient(135deg,#2a3d2f 0%,#7a9475 100%);width:100%;height:100%;"></div>
            <?php endif; ?>
        </a>
    </div>
    <div class="post-card__meta">
        <?php $cats = get_the_category();
        if ($cats) : ?>
            <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>" class="post-card__cat"><?php echo esc_html($cats[0]->name); ?></a>
        <?php endif; ?>
        <time class="post-card__date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('j. F Y'); ?></time>
    </div>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p><?php the_excerpt(); ?></p>
    <a href="<?php the_permalink(); ?>" class="post-card__read"><?php esc_html_e('Loe edasi', 'oja-aed'); ?></a>
</article>
