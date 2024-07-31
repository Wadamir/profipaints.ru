<?php
$id       = get_theme_mod('profipaints_about_id', esc_html__('about', 'profipaints'));
$disable  = get_theme_mod('profipaints_about_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_about_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-about section-padding onepage-section {$meta_class}", 'about'));
$title   = get_theme_mod('profipaints_about_title');
$form = get_theme_mod('profipaints_about_form');

if (profipaints_is_selective_refresh()) {
    $disable = false;
}
if (!$disable) {
    // $desc = get_theme_mod('profipaints_about_desc');
?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <div class="modal fade" id="about-modal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-wide">
                <div class="modal-content modal-content-high">
                    <div class="modal-header">
                        <h3 id="modal-title" class="text-uppercase"><?php echo $title; ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1561_14432)">
                                        <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#1B1D21"></path>
                                    </g>
                                    <defs>
                                        <clipPath>
                                            <rect width="24" height="24" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="about-item meta-color h-100">
                            <?php if ($form) { ?>
                                <div class="form">
                                    <?php echo do_shortcode(wp_kses_post($form)); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>