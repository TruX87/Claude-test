</main><!-- #main -->

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand -->
            <div class="footer-brand">
                <div class="logo-text">Oja Aed</div>
                <p><?php esc_html_e('Kodus kasvatatud taimed, käsitsi valmistatud esemed ja südamest tehtud kingitused Saaremaa saare südamest.', 'oja-aed'); ?></p>
                <div class="footer-social">
                    <?php if ($ig = get_theme_mod('ojaaed_instagram')) : ?>
                        <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a>
                    <?php endif; ?>
                    <?php if ($fb = get_theme_mod('ojaaed_facebook')) : ?>
                        <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Navigation -->
            <div class="footer-col">
                <h5><?php esc_html_e('Navigatsioon', 'oja-aed'); ?></h5>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Avaleht', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>"><?php esc_html_e('Pood', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('Blogi', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>"><?php esc_html_e('Retseptid', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/meist')); ?>"><?php esc_html_e('Meist', 'oja-aed'); ?></a></li>
                </ul>
            </div>

            <!-- Products -->
            <div class="footer-col">
                <h5><?php esc_html_e('Tooted', 'oja-aed'); ?></h5>
                <ul>
                    <li><a href="<?php echo esc_url(get_term_link('taimed', 'product_cat')); ?>"><?php esc_html_e('Taimed', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_term_link('kasitoo', 'product_cat')); ?>"><?php esc_html_e('Käsitöö', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_term_link('kingitused', 'product_cat')); ?>"><?php esc_html_e('Kingitused', 'oja-aed'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_term_link('puitesemed', 'product_cat')); ?>"><?php esc_html_e('Puitesemed', 'oja-aed'); ?></a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-col">
                <h5><?php esc_html_e('Kontakt', 'oja-aed'); ?></h5>
                <address>
                    <?php if ($addr = get_theme_mod('ojaaed_address', 'Saaremaa, Eesti')) : ?>
                        <p><?php echo esc_html($addr); ?></p>
                    <?php endif; ?>
                    <?php if ($email = get_theme_mod('ojaaed_email')) : ?>
                        <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    <?php endif; ?>
                    <?php if ($phone = get_theme_mod('ojaaed_phone')) : ?>
                        <p><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                    <?php endif; ?>
                </address>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="footer-bottom">
            <span>&copy; <?php echo date('Y'); ?> Oja Aed. <?php esc_html_e('Kõik õigused kaitstud.', 'oja-aed'); ?></span>
            <span><?php esc_html_e('Saaremaa, Eesti', 'oja-aed'); ?></span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
