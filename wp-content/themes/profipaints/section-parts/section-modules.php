<?php
$id       = get_theme_mod('profipaints_modules_id', esc_html__('modules', 'profipaints'));
$disable  = get_theme_mod('profipaints_modules_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_modules_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-modules section-padding onepage-section {$meta_class}", 'modules'));
$title    = get_theme_mod('profipaints_modules_title', esc_html__('modules', 'profipaints'));
$subtitle = get_theme_mod('profipaints_modules_subtitle', esc_html__('Why choose Us', 'profipaints'));
$layout = intval(get_theme_mod('profipaints_modules_layout', 4));
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$data  = profipaints_get_modules_data();
if (!$disable && !empty($data)) {
    $desc = get_theme_mod('profipaints_modules_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'modules'; ?>" <?php do_action('profipaints_section_atts', 'modules'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'modules'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'modules')); ?>">
            <?php if ($title ||  $subtitle || $desc) { ?>
                <div class="section-title-area">
                    <?php if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; ?>
                    <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
                    <?php if ($desc) {
                        echo '<div class="section-desc">' . apply_filters('profipaints_the_content', wp_kses_post($desc)) . '</div>';
                    } ?>
                </div>
            <?php } ?>
            <div class="section-content">
                <div id="modules-carousel" class="modules-carousel row">
                    <?php
                    foreach ($data as $k => $f) {
                        $media = '';
                        $f =  wp_parse_args($f, array(
                            'icon_type' => 'icon',
                            'icon' => 'gg',
                            'image' => '',
                            'link' => '',
                            'title' => '',
                            'subtitle' => '',
                            'desc' => '',
                        ));
                        if ($f['image']) {
                            $url = profipaints_get_media_url($f['image']);
                            $image_alt = get_post_meta($f['image']['id'], '_wp_attachment_image_alt', true);
                            if ($url) {
                                $media = '<span class="icon-image"><img src="' . esc_url($url) . '" alt="' . $image_alt . '"></span>';
                            }
                        }
                    ?>
                        <div class="col-12 col-md-<?php echo $layout ?> d-flex align-items-stretch">
                            <div class="modules-item meta-color h-100">
                                <div class="modules-content">
                                    <h2><?php echo esc_html($f['title']); ?></h2>
                                    <p class="subtitle text-italic h4"><?php echo esc_html($f['subtitle']); ?></p>
                                    <div class="modules-item-content"><?php echo apply_filters('the_content', $f['desc']); ?></div>
                                </div>
                                <div class="modules-media">
                                    <?php echo $media; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    } // end loop modules

                    ?>
                </div>
            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'modules'); ?>

        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>