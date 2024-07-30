<?php
$id       = get_theme_mod('profipaints_features_id', esc_html__('features', 'profipaints'));
$disable  = get_theme_mod('profipaints_features_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_features_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-features section-padding-60 onepage-section {$meta_class}", 'features'));
$title    = get_theme_mod('profipaints_features_title', esc_html__('Features', 'profipaints'));
$subtitle = get_theme_mod('profipaints_features_subtitle', esc_html__('Why choose Us', 'profipaints'));
$layout = intval(get_theme_mod('profipaints_features_layout', 4));
// var_dump(get_theme_mod('profipaints_features_layout'));
// $layout_col = 12 / $layout;
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$data  = profipaints_get_features_data();
if (!$disable && !empty($data)) {
    $desc = get_theme_mod('profipaints_features_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'features'; ?>" <?php do_action('profipaints_section_atts', 'features'); ?> class="<?php echo $section_classes; ?>">
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
                <div id="products-carousel" class="features-carousel row">
                    <?php
                    foreach ($data as $k => $f) {
                        $media = '';
                        $f =  wp_parse_args($f, array(
                            'icon_type'     => 'icon',
                            'icon'          => 'gg',
                            'image'         => '',
                            'title'         => '',
                            'subtitle'      => '',
                            'desc'          => '',
                        ));
                        if ($f['image']) {
                            $url = profipaints_get_media_url($f['image']);
                            $image_alt = get_post_meta($f['image']['id'], '_wp_attachment_image_alt', true);
                            if ($url) {
                                $media = '<span class="icon-image"><img src="' . esc_url($url) . '" alt="' . $image_alt . '"></span>';
                            }
                        }
                        if ($f['image2']) {
                            $url2 = profipaints_get_media_url($f['image2']);
                            $image2_alt = get_post_meta($f['image2']['id'], '_wp_attachment_image_alt', true);
                            if ($url2) {
                                $media2 = '<span class="icon-image"><img src="' . esc_url($url2) . '" alt="' . $image2_alt . '"></span>';
                            }
                        }
                        if ($f['image3']) {
                            $url3 = profipaints_get_media_url($f['image3']);
                            $image3_alt = get_post_meta($f['image3']['id'], '_wp_attachment_image_alt', true);
                            if ($url3) {
                                $media3 = '<span class="icon-image"><img src="' . esc_url($url3) . '" alt="' . $image3_alt . '"></span>';
                            }
                        }
                    ?>
                        <div class="col-12 col-md-6 col-lg-<?php echo $layout ?> mb-10">
                            <div class="feature-item meta-color h-100">
                                <div class="feature-media">
                                    <?php echo $media; ?>
                                </div>
                                <h3 class="dnone"><?php echo esc_html($f['title']); ?></h3>
                                <p class="subtitle d-none"><?php echo esc_html($f['subtitle']); ?></p>
                                <p class="text-center m-0 w-100">
                                    <a href="#" class="btn btn-lg btn-primary btn-text-icon w-100" data-bs-toggle="modal" data-bs-target="#feature-item-content-<?php echo $k ?>">
                                        <span class="btn-text"><?php echo esc_html__('ПОДРОБНЕЕ', 'profipaints'); ?></span>
                                        <span class="btn-icon"> <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M28.9195 11.9194H15.0807L15.0807 13.8707L25.5775 13.8776L11.621 27.834L13.0049 29.2179L26.9613 15.2615L26.9683 25.7582H28.9195V11.9194Z" fill="white" />
                                            </svg>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    <?php
                    } // end loop features

                    ?>
                </div>
            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'features'); ?>

        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>