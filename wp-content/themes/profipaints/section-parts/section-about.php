<?php
$id       = get_theme_mod('profipaints_about_id', esc_html__('about', 'profipaints'));
$disable  = get_theme_mod('profipaints_about_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_about_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-about section-padding-60 onepage-section {$meta_class}", 'about'));
$title    = get_theme_mod('profipaints_about_title', esc_html__('about', 'profipaints'));
$subtitle = get_theme_mod('profipaints_about_subtitle', esc_html__('Why choose Us', 'profipaints'));
$description = get_theme_mod('profipaints_about_desc');
$image = get_theme_mod('profipaints_about_image');
$background_image = '';
if ($image) {
    $media = '<img src="' . esc_url($image) . '">';
    $background_image = ' style="background-image:url(' . esc_url($image) . ');"';
}

$layout = intval(get_theme_mod('profipaints_about_layout', 12));
$form = get_theme_mod('profipaints_about_form');
// $layout_col = 12 / $layout;
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
// $data  = profipaints_get_about_data();
if (!$disable) {
    $desc = get_theme_mod('profipaints_about_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'about'; ?>" <?php do_action('profipaints_section_atts', 'about'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'about'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container-fluid', 'about')); ?>">
            <?php if ($title) { ?>
                <div class="section-title-area">
                    <?php
                    // if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; 
                    ?>
                    <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
                </div>
            <?php } ?>

            <div class="row row-fluid">
                <div class="col-12 col-md-6 ps-0">
                    <div class="about-bg" <?php echo $background_image ?>></div>
                </div>
                <div class="col-12 col-md-6 pe-0">
                    <?php if ($desc) { ?>
                        <div class="about-section-desc">
                            <?php if ($subtitle) { ?>
                                <?php if ($subtitle != '') echo '<h5 class="section-subtitle-inner">' . esc_html($subtitle) . '</h5>'; ?>
                            <?php } ?>
                            <?php echo apply_filters('profipaints_the_content', wp_kses_post($desc)); ?>
                        </div>
                    <?php } ?>
                    <?php if ($form) { ?>
                        <div class="about-form">
                            <a href="#" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#about-modal"><?php echo esc_html__('Связаться с нами', 'profipaints'); ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
        <?php do_action('profipaints_section_after_inner', 'about'); ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>