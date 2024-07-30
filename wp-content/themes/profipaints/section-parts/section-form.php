<?php
$id                         = get_theme_mod('profipaints_form_id', esc_html__('form', 'profipaints'));
$disable                    = get_theme_mod('profipaints_form_disable') == 1 ? true : false;
$meta_class                 = get_theme_mod('profipaints_form_meta') == 1 ? 'profipaints-meta' : '';
$section_classes            = esc_attr(apply_filters('profipaints_section_class', "section-form section-padding onepage-section {$meta_class}", 'form'));
$title                      = get_theme_mod('profipaints_form_title', esc_html__('Get in touch', 'profipaints'));
$subtitle                   = get_theme_mod('profipaints_form_subtitle', esc_html__('Section subtitle', 'profipaints'));

$profipaints_form_cf7           = get_theme_mod('profipaints_form_cf7');
$profipaints_form_cf7_disable   = get_theme_mod('profipaints_form_cf7_disable');
$profipaints_form_text          = get_theme_mod('profipaints_form_text');
$profipaints_contact_form_title = get_theme_mod('profipaints_contact_form_title');
$profipaints_contact_form_text  = get_theme_mod('profipaints_contact_form_text');

if (profipaints_is_selective_refresh()) {
    $disable = false;
}

if ($profipaints_form_cf7 || $profipaints_form_text || $profipaints_contact_form_title || $profipaints_contact_form_text) {
    $desc = wp_kses_post(get_theme_mod('profipaints_form_desc'));
?>
    <?php if (!$disable) : ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
            <section id="<?php echo ($id !== '') ? esc_attr($id) : 'form'; ?>" <?php do_action('profipaints_section_atts', 'form'); ?> class="<?php echo $section_classes; ?>">
            <?php } ?>
            <?php do_action('profipaints_section_before_inner', 'form'); ?>
            <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'form')); ?>">
                <?php if ($title || $subtitle || $desc) { ?>
                    <div class="section-title-area">
                        <?php if ($subtitle != '') {
                            echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>';
                        } ?>
                        <?php if ($title != '') {
                            echo '<h2 class="section-title">' . esc_html($title) . '</h2>';
                        } ?>
                        <?php if ($desc) {
                            echo '<div class="section-desc">' . apply_filters('profipaints_the_content', $desc) . '</div>';
                        } ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if ($profipaints_form_cf7_disable != '1') : ?>
                        <?php if (isset($profipaints_form_cf7) && $profipaints_form_cf7 != '') { ?>
                            <div class="form-form col-sm-6 wow slideInUp">
                                <?php echo do_shortcode(wp_kses_post($profipaints_form_cf7)); ?>
                            </div>
                        <?php } else { ?>
                            <div class="form-form col-sm-6 wow slideInUp">
                                <br>
                                <small>
                                    <i><?php printf(esc_html__('You can install %1$s plugin and go to Customizer &rarr; Section: form &rarr; Section Content to show a working form form here.', 'profipaints'), '<a href="' . esc_url('https://wordpress.org/plugins/pirate-forms/', 'profipaints') . '" target="_blank">form Form 7</a>'); ?></i>
                                </small>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                    <?php if ($profipaints_contact_form_title != '' || $profipaints_contact_form_text != '') { ?>
                        <div class="col-sm-6 wow slideInUp">
                            <?php if ($profipaints_contact_form_title) { ?>
                                <h3><?php echo wp_kses_post($profipaints_contact_form_title) ?></h3>
                            <?php } ?>
                            <?php if ($profipaints_contact_form_text) { ?>
                                <p>
                                    <?php echo wp_kses_post($profipaints_contact_form_text) ?>
                                </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php do_action('profipaints_section_after_inner', 'form'); ?>
            <?php if (!profipaints_is_selective_refresh()) { ?>
            </section>
        <?php } ?>
<?php endif;
}
