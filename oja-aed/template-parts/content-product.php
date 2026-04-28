<article class="product-card reveal">
    <div class="product-card__image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) :
                the_post_thumbnail('ojaaed-product-card', ['loading' => 'lazy']);
            else : ?>
                <div style="background:linear-gradient(160deg,var(--cream-mid),var(--sand));width:100%;height:100%;"></div>
            <?php endif; ?>
        </a>
        <?php $badge = ojaaed_meta('_product_badge');
        if ($badge) : ?>
            <span class="product-card__badge"><?php echo esc_html($badge); ?></span>
        <?php endif; ?>
    </div>

    <?php
    $cats = get_the_terms(get_the_ID(), 'product_cat');
    if ($cats && !is_wp_error($cats)) : ?>
        <a href="<?php echo esc_url(get_term_link($cats[0])); ?>" class="product-card__cat"><?php echo esc_html($cats[0]->name); ?></a>
    <?php endif; ?>

    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p><?php the_excerpt(); ?></p>

    <div class="product-card__footer">
        <?php echo ojaaed_price(); ?>
        <a href="<?php the_permalink(); ?>" class="btn btn--dark" style="padding:.6rem 1.2rem;font-size:.72rem;"><?php esc_html_e('Vaata', 'oja-aed'); ?></a>
    </div>
</article>
