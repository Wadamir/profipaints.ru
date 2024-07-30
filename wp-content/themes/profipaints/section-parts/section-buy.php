<?php
$id       = get_theme_mod('profipaints_buy_id', esc_html__('buy', 'profipaints'));
$disable  = get_theme_mod('profipaints_buy_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_buy_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-buy section-margin-lg onepage-section {$meta_class}", 'buy'));
$title    = get_theme_mod('profipaints_buy_title', esc_html__('buy', 'profipaints'));
$subtitle = get_theme_mod('profipaints_buy_subtitle', esc_html__('Why choose Us', 'profipaints'));
$description = get_theme_mod('profipaints_buy_desc');
$image1 = get_theme_mod('profipaints_buy_image1');
$background_image1 = '';
if ($image1) {
    $media1 = '<img src="' . esc_url($image1) . '">';
    $background_image1 = ' style="background-image:url(' . esc_url($image1) . ');"';
}
$link1 = get_theme_mod('profipaints_buy_link1');

$image2 = get_theme_mod('profipaints_buy_image2');
$background_image2 = '';
if ($image2) {
    $media2 = '<img src="' . esc_url($image2) . '">';
    $background_image2 = ' style="background-image:url(' . esc_url($image2) . ');"';
}
$link2 = get_theme_mod('profipaints_buy_link2');

$image3 = get_theme_mod('profipaints_buy_image3');
$background_image3 = '';
if ($image3) {
    $media3 = '<img src="' . esc_url($image3) . '">';
    $background_image3 = ' style="background-image:url(' . esc_url($image3) . ');"';
}
$link3 = get_theme_mod('profipaints_buy_link3');

$layout = intval(get_theme_mod('profipaints_buy_layout', 12));
// $layout_col = 12 / $layout;
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
// $data  = profipaints_get_buy_data();
if (!$disable) {
    $desc = get_theme_mod('profipaints_buy_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'buy'; ?>" <?php do_action('profipaints_section_atts', 'buy'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'buy'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'buy')); ?>">
            <div class="section-content">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-4 d-flex equal-height">
                        <div class="buy-item2">
                            <?php if ($title) { ?>
                                <div class="section-title-area mb-3">
                                    <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
                                </div>
                            <?php } ?>
                            <?php if ($desc) {
                                echo '<div class="buy-section-desc">' . apply_filters('profipaints_the_content', wp_kses_post($desc)) . '</div>';
                            } ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex equal-height">
                        <div class="buy-item">
                            <a href="<?php echo $link1 ?>" target="_blank" class="buy-bg w-100 h-100" <?php echo $background_image1 ?>>
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="white" />
                                    <path d="M20.0001 9L10.4168 8.58333L10.4755 9.93458L17.7447 10.2554L8.50012 19.5L9.50012 20.5L18.7447 11.2554L19.0655 18.5246L20.4168 18.5833L20.0001 9Z" fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex equal-height">
                        <div class="buy-item">
                            <a href="<?php echo $link2 ?>" target="_blank" class="buy-bg buy-bg-half w-100 h-50" <?php echo $background_image2 ?>>
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="white" />
                                    <path d="M20.0001 9L10.4168 8.58333L10.4755 9.93458L17.7447 10.2554L8.50012 19.5L9.50012 20.5L18.7447 11.2554L19.0655 18.5246L20.4168 18.5833L20.0001 9Z" fill="white" />
                                </svg>
                            </a>
                            <a href="<?php echo $link3 ?>" target="_blank" class="buy-bg buy-bg-half w-100 h-50" <?php echo $background_image3 ?>>
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="white" />
                                    <path d="M20.0001 9L10.4168 8.58333L10.4755 9.93458L17.7447 10.2554L8.50012 19.5L9.50012 20.5L18.7447 11.2554L19.0655 18.5246L20.4168 18.5833L20.0001 9Z" fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'buy'); ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php } ?>