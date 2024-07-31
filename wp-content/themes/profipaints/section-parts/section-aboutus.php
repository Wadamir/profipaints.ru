<?php
$id       = get_theme_mod('profipaints_aboutus_id', esc_html__('aboutus', 'profipaints'));
$disable  = get_theme_mod('profipaints_aboutus_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_aboutus_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-aboutus section-padding-70 onepage-section {$meta_class}", 'aboutus'));
$title    = get_theme_mod('profipaints_aboutus_title', esc_html__('aboutus', 'profipaints'));
$subtitle = get_theme_mod('profipaints_aboutus_subtitle', esc_html__('Why choose Us', 'profipaints'));
$description = get_theme_mod('profipaints_aboutus_desc');
$image = get_theme_mod('profipaints_aboutus_image');
$background_image = '';
if ($image) {
    $media = '<img src="' . esc_url($image) . '">';
    $background_image = ' style="background-image:url(' . esc_url($image) . ');"';
}

$layout = intval(get_theme_mod('profipaints_aboutus_layout', 12));
// $layout_col = 12 / $layout;
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
// $data  = profipaints_get_aboutus_data();
if (!$disable) {
    $desc = get_theme_mod('profipaints_aboutus_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'aboutus'; ?>" <?php do_action('profipaints_section_atts', 'aboutus'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'aboutus'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'aboutus')); ?>">

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="aboutus-section-desc rounded-secondary">
                        <?php if ($title ||  $subtitle || $desc) { ?>
                            <div class="section-title-area">
                                <?php if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; ?>
                                <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
                            </div>
                        <?php } ?>
                        <?php if ($desc) {
                            echo apply_filters('profipaints_the_content', wp_kses_post($desc));
                        } ?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="aboutus-bg rounded-secondary" <?php echo $background_image ?>></div>
                </div>
            </div>

        </div>
        <?php do_action('profipaints_section_after_inner', 'aboutus'); ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>