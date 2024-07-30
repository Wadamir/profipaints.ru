<?php
$id       = get_theme_mod('profipaints_about_id', esc_html__('about', 'profipaints'));
$disable  = get_theme_mod('profipaints_about_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_about_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-about section-padding onepage-section {$meta_class}", 'about'));
$title    = get_theme_mod('profipaints_about_title', esc_html__('about', 'profipaints'));
$subtitle = get_theme_mod('profipaints_about_subtitle', esc_html__('Why choose Us', 'profipaints'));
$layout = intval(get_theme_mod('profipaints_about_layout', 4));
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$data  = profipaints_get_about_data();
if (!$disable && !empty($data)) {
    $desc = get_theme_mod('profipaints_about_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'about'; ?>" <?php do_action('profipaints_section_atts', 'about'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'about'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'about')); ?>">
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
                <div id="about-carousel" class="about-carousel row">
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
                            'btn_text' => '',
                            'btn_type' => 'btn-primary',
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
                            <div class="about-item meta-color w-100 h-100">
                                <div class="about-content">
                                    <?php if ($f['title'] !== '') : ?>
                                        <h2><?php echo esc_html($f['title']); ?></h2>
                                    <?php endif; ?>
                                    <?php if ($f['subtitle'] !== '') : ?>
                                        <p class="text-center h4"><?php echo esc_html($f['subtitle']); ?></p>
                                    <?php endif; ?>
                                    <?php if ($f['desc'] !== '' && $f['desc'] !== '<p></p>') : ?>
                                        <div class="about-item-content"><?php echo apply_filters('the_content', $f['desc']); ?></div>
                                    <?php endif; ?>
                                    <?php if ($f['btn_text'] !== '') : ?>
                                        <p class="text-center">
                                            <a href="#" class="btn btn-lg <?php echo esc_attr($f['btn_type']); ?>" data-bs-toggle="modal" data-bs-target="#about-item-content-<?php echo $k ?>"><?php echo esc_html($f['btn_text']); ?></a>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="about-media">
                                    <?php echo $media; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    } // end loop about
                    ?>
                </div>
            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'about'); ?>

        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>