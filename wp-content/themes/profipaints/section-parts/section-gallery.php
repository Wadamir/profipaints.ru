<?php
$id                 = get_theme_mod('profipaints_gallery_id', esc_html__('gallery', 'profipaints'));
$disable            = get_theme_mod('profipaints_gallery_disable', 1) ==  1 ? true : false;
$meta_class         = get_theme_mod('profipaints_gallery_meta') == 1 ? 'profipaints-meta' : '';
$section_classes    = esc_attr(apply_filters('profipaints_section_class', "section-gallery section-padding-70 onepage-section {$meta_class}", 'gallery'));
$title    = get_theme_mod('profipaints_gallery_title', esc_html__('Gallery', 'profipaints'));
$subtitle = get_theme_mod('profipaints_gallery_subtitle', esc_html__('Section subtitle', 'profipaints'));
$desc     = get_theme_mod('profipaints_gallery_desc');

if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$layout = get_theme_mod('profipaints_gallery_layout', 'default');

?>
<?php if (!$disable) { ?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'gallery'; ?>" <?php do_action('profipaints_section_atts', 'gallery'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'gallery'); ?>

        <div class="g-layout-<?php echo esc_attr($layout); ?> <?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'gallery')); ?>">
            <?php if ($title || $subtitle || $desc) { ?>
                <div class="section-title-area">
                    <?php if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; ?>
                    <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
                    <?php if ($desc) {
                        echo '<div class="section-desc">' . apply_filters('profipaints_the_content', wp_kses_post($desc)) . '</div>';
                    } ?>
                </div>
            <?php } ?>
            <div class="gallery-content">
                <?php
                profipaints_gallery_generate();
                ?>
            </div>
            <?php
            $readmore_link = get_theme_mod('profipaints_g_readmore_link');
            $readmore_text = get_theme_mod('profipaints_g_readmore_text', esc_html__('View More', 'profipaints'));
            if ($readmore_link) {
            ?>
                <div class="all-gallery">
                    <a class="btn btn-theme-primary-outline" href="<?php echo esc_attr($readmore_link); ?>"><?php echo esc_html($readmore_text); ?></a>
                </div>
            <?php } ?>

        </div>
        <?php do_action('profipaints_section_after_inner', 'gallery'); ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php }
