<?php
$id       = get_theme_mod('profipaints_videolightbox_id', 'videolightbox');
$disable  = get_theme_mod('profipaints_videolightbox_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_videolightbox_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-videolightbox section-padding onepage-section {$meta_class}", 'videolightbox'));
$heading  = get_theme_mod('profipaints_videolightbox_title');
$video    = get_theme_mod('profipaints_videolightbox_url');
if (profipaints_is_selective_refresh()) {
    $disable = false;
}

if (!$disable) {
    if ((!$disable && ($video || $heading)) || profipaints_is_selective_refresh()) {
?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'videolightbox'; ?>" <?php do_action('profipaints_section_atts', 'videolightbox'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'videolightbox'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'videolightbox')); ?>">
            <?php if ($video) { ?>
                <div class="videolightbox__icon videolightbox-popup">
                    <a href="<?php echo esc_attr($video); ?>" data-scr="<?php echo esc_attr($video); ?>" class="popup-video">
                        <span class="video_icon"><i class="fa fa-play"></i></span>
                    </a>
                </div>
            <?php } ?>
            <?php if ($heading) { ?>
                <h2 class="videolightbox__heading"><?php echo do_shortcode(wp_kses_post($heading)); ?></h2>
            <?php } ?>
        </div>
        <?php do_action('profipaints_section_after_inner', 'videolightbox'); ?>
        <?php if ((!$disable && ($video || $heading)) || profipaints_is_selective_refresh()) { ?>
        </section>
<?php }
    }
