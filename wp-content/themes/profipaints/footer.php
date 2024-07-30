<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ProfiPaints
 */

$hide_footer = false;
$page_id = get_the_ID();

if (is_page()) {
    $hide_footer = get_post_meta($page_id, '_hide_footer', true);
}

if (profipaints_is_wc_active()) {
    if (is_shop()) {
        $page_id =  wc_get_page_id('shop');
        $hide_footer = get_post_meta($page_id, '_hide_footer', true);
    }
}

if (!$hide_footer) {
?>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <?php
        /**
         * @since 2.0.0
         * @see profipaints_footer_widgets
         * @see profipaints_footer_connect
         */
        do_action('profipaints_before_site_info');
        $profipaints_btt_disable = sanitize_text_field(get_theme_mod('profipaints_btt_disable'));

        ?>

        <div class="site-info">
            <div class="container">
                <?php if ($profipaints_btt_disable != '1') : ?>
                    <div class="btt">
                        <a class="back-to-top" href="#page" title="<?php echo esc_html__('Back To Top', 'profipaints') ?>"><i class="fa fa-angle-double-up wow flash" data-wow-duration="2s"></i></a>
                    </div>
                <?php endif; ?>
                <?php
                /**
                 * hooked profipaints_footer_site_info
                 * @see profipaints_footer_site_info
                 */
                do_action('profipaints_footer_site_info');
                ?>
            </div>
        </div>
        <!-- .site-info -->

    </footer><!-- #colophon -->
<?php
}
/**
 * Hooked: profipaints_site_footer
 *
 * @see profipaints_site_footer
 */
do_action('profipaints_site_end');
?>
</div><!-- #page -->

<?php do_action('profipaints_after_site_end'); ?>

<?php wp_footer(); ?>

<?php profipaints_load_section('hero-footer'); ?>
<?php profipaints_load_section('features-footer'); ?>
<?php profipaints_load_section('about-footer'); ?>


</body>

</html>