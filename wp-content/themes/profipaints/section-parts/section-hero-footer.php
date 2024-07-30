<?php
$id         = get_theme_mod('profipaints_hero_id', esc_html__('hero', 'profipaints'));
$disable    = sanitize_text_field(get_theme_mod('profipaints_hero_disable')) == 1 ? true : false;
$profipaints_hcl1_modaltitle  = get_theme_mod('profipaints_hcl1_modaltitle');
$profipaints_hcl1_modaltext = get_theme_mod('profipaints_hcl1_modaltext');

$custom_logo_id = get_theme_mod('custom_logo');
$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

if (profipaints_is_selective_refresh()) {
    $disable = false;
}
?>
<?php if (!$disable) : ?>
    <div class="modal fade" id="hero-content-0" tabindex="-1" aria-labelledby="heroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-wide">
            <div class="modal-content modal-content-high">
                <div class="modal-header px-40 py-30">
                    <h3><?php echo esc_html($profipaints_hcl1_modaltitle); ?></h3>
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
                <div class="modal-body px-40 py-30">
                    <p><?php echo $profipaints_hcl1_modaltext; ?></p>
                    <p class="text-end mt-44 mb-0"><img src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" style="max-width: 115px"></p>
                </div>
            </div>
        </div>
    </div>
<?php endif;
