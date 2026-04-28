<?php get_header(); ?>

<div class="container section error-404">
    <div>
        <h1>404</h1>
        <h2><?php esc_html_e('Lehekülge ei leitud', 'oja-aed'); ?></h2>
        <p><?php esc_html_e('Otsitav leht on kadunud nagu üks unustatud seemne — aga meie aed on siin ootamas.', 'oja-aed'); ?></p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--dark"><?php esc_html_e('Tagasi avalehele', 'oja-aed'); ?></a>
    </div>
</div>

<?php get_footer();
