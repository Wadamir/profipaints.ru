<?php
$id       = get_theme_mod('profipaints_features_id', esc_html__('features', 'profipaints'));
$disable  = get_theme_mod('profipaints_features_disable') == 1 ? true : false;
$title    = get_theme_mod('profipaints_features_title', esc_html__('Features', 'profipaints'));
$subtitle = get_theme_mod('profipaints_features_subtitle', esc_html__('Why choose Us', 'profipaints'));
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$data  = profipaints_get_features_data();
if (!$disable && !empty($data)) {
    $desc = get_theme_mod('profipaints_features_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php if ($id != '') {
                            echo esc_attr($id);
                        } ?>" <?php do_action('profipaints_section_atts', 'features'); ?> class="<?php echo esc_attr(apply_filters('profipaints_section_class', 'section-features section-padding onepage-section', 'features')); ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'features'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'features')); ?>">
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
                <div id="features-carousel" class="features-carousel owl-theme owl-carousel">
                    <?php
                    $layout = intval(get_theme_mod('profipaints_features_layout', 3));
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
                        if ($f['icon_type'] == 'image' && $f['image']) {
                            $url = profipaints_get_media_url($f['image']);
                            $image_alt = get_post_meta($f['image']['id'], '_wp_attachment_image_alt', true);
                            if ($url) {
                                $media = '<span class="icon-image"><img src="' . esc_url($url) . '" alt="' . $image_alt . '"></span>';
                            }
                        } else if ($f['icon']) {
                            $f['icon'] = trim($f['icon']);
                            $media = '<span class="fa-stack fa-5x"><i class="fa fa-circle fa-stack-2x icon-background-default"></i> <i class="feature-icon fa ' . esc_attr($f['icon']) . ' fa-stack-1x"></i></span>';
                        }

                    ?>
                        <div class="feature-item meta-color">
                            <div class="feature-media">
                                <?php if ($f['link']) { ?><a title="<?php echo esc_attr($f['title']) ?>" href="<?php echo esc_url($f['link']); ?>"><?php } ?>
                                    <?php echo $media; ?>
                                    <?php if ($f['link']) { ?></a><?php } ?>
                            </div>
                            <p class="subtitle"><?php echo esc_html($f['subtitle']); ?></p>
                            <h4><?php if ($f['link']) { ?><a title="<?php echo esc_attr($f['title']) ?>" href="<?php echo esc_url($f['link']); ?>"><?php } ?><?php echo esc_html($f['title']); ?><?php if ($f['link']) { ?></a><?php } ?></h4>
                            <div class="feature-item-content"><?php echo apply_filters('the_content', $f['desc']); ?></div>
                        </div>
                    <?php
                    } // end loop featues

                    ?>
                </div>
            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'features'); ?>

        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>