<?php get_header(); ?>

<div class="container section">
    <?php if (have_posts()) : ?>
        <div class="blog-grid">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', 'post');
            endwhile; ?>
        </div>
        <div class="pagination">
            <?php echo paginate_links(['prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('Postitusi ei leitud.', 'oja-aed'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer();
