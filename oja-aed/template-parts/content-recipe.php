<article class="recipe-card reveal">
    <div class="recipe-card__image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) :
                the_post_thumbnail('ojaaed-recipe-card', ['loading' => 'lazy']);
            else : ?>
                <div style="background:linear-gradient(135deg,#8b6847,#4a6741);width:100%;height:100%;"></div>
            <?php endif; ?>
        </a>
    </div>

    <?php
    $cats = get_the_terms(get_the_ID(), 'recipe_cat');
    if ($cats && !is_wp_error($cats)) : ?>
        <a href="<?php echo esc_url(get_term_link($cats[0])); ?>" class="recipe-card__cat"><?php echo esc_html($cats[0]->name); ?></a>
    <?php endif; ?>

    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p><?php the_excerpt(); ?></p>

    <?php echo ojaaed_recipe_meta_html(); ?>
</article>
