<?php
$id                 = get_theme_mod('profipaints_contact_id', esc_html__('contact', 'profipaints'));
$disable            = get_theme_mod('profipaints_contact_disable') == 1 ? true : false;
$meta_class         = get_theme_mod('profipaints_contact_meta') == 1 ? 'profipaints-meta' : '';
$section_classes    = esc_attr(apply_filters('profipaints_section_class', "section-contact section-padding-lg section-margin-60 section-meta {$meta_class}", 'contact'));
$title              = get_theme_mod('profipaints_contact_title', esc_html__('Get in touch', 'profipaints'));
$subtitle           = get_theme_mod('profipaints_contact_subtitle', esc_html__('Section subtitle', 'profipaints'));

$profipaints_contact_cf7           = get_theme_mod('profipaints_contact_cf7');
$profipaints_contact_cf7_disable   = get_theme_mod('profipaints_contact_cf7_disable');
$profipaints_contact_text          = get_theme_mod('profipaints_contact_text');
$profipaints_contact_address_title = get_theme_mod('profipaints_contact_address_title');
$profipaints_contact_address       = get_theme_mod('profipaints_contact_address');
$profipaints_contact_phone         = get_theme_mod('profipaints_contact_phone');
$profipaints_contact_phone_text    = (get_theme_mod('profipaints_contact_phone_text') != '') ? get_theme_mod('profipaints_contact_phone_text') : esc_html__('Phone', 'profipaints');
$profipaints_contact_email         = get_theme_mod('profipaints_contact_email');
$profipaints_contact_email_text    = (get_theme_mod('profipaints_contact_email_text') != '') ? get_theme_mod('profipaints_contact_email_text') : esc_html__('Email', 'profipaints');
$profipaints_contact_whatsapp      = get_theme_mod('profipaints_contact_whatsapp');
$profipaints_contact_whatsapp_text = (get_theme_mod('profipaints_contact_whatsapp_text') != '') ? get_theme_mod('profipaints_contact_whatsapp_text') : esc_html__('WhatsApp', 'profipaints');
$profipaints_contact_telegram      = get_theme_mod('profipaints_contact_telegram');
$profipaints_contact_telegram_text = (get_theme_mod('profipaints_contact_telegram_text') != '') ? get_theme_mod('profipaints_contact_telegram_text') : esc_html__('Telegram', 'profipaints');

$profipaints_contact_yamap         = get_theme_mod('profipaints_contact_yamap');
// var_dump($profipaints_contact_yamap);
if (is_array($profipaints_contact_yamap)) die;
$profipaints_contact_yamap_iframe  = '';
if ($profipaints_contact_yamap !== '' && strpos($profipaints_contact_yamap, 'iframe') !== false) {
    $profipaints_contact_yamap_iframe = $profipaints_contact_yamap;
}
if ($profipaints_contact_yamap !== '' && strpos($profipaints_contact_yamap, 'iframe') === false) {
    $profipaints_contact_yamap_iframe = '<iframe src="' . $profipaints_contact_yamap . '" frameborder="0" allowfullscreen="true" width="100%" height="400px" style="display: block;"></iframe>';
}
$profipaints_contact_yamap_disable = get_theme_mod('profipaints_contact_yamap_disable');

if (profipaints_is_selective_refresh()) {
    $disable = false;
}

$icon_address = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_1456_5073)">
<path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM7 9C7 6.24 9.24 4 12 4C14.76 4 17 6.24 17 9C17 11.88 14.12 16.19 12 18.88C9.92 16.21 7 11.85 7 9Z" /><path d="M12 11.5C13.3807 11.5 14.5 10.3807 14.5 9C14.5 7.61929 13.3807 6.5 12 6.5C10.6193 6.5 9.5 7.61929 9.5 9C9.5 10.3807 10.6193 11.5 12 11.5Z" /></g><defs><clipPath id="clip0_1456_5073"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>';
$icon_marker = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20 3.33325C12.6483 3.33325 6.66664 9.31492 6.66664 16.6583C6.61831 27.3999 19.4933 36.3066 20 36.6666C20 36.6666 33.3816 27.3999 33.3333 16.6666C33.3333 9.31492 27.3516 3.33325 20 3.33325ZM20 23.3333C16.3166 23.3333 13.3333 20.3499 13.3333 16.6666C13.3333 12.9833 16.3166 9.99992 20 9.99992C23.6833 9.99992 26.6666 12.9833 26.6666 16.6666C26.6666 20.3499 23.6833 23.3333 20 23.3333Z" />
</svg>';
$icon_phone = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.65 3C10.4545 3 3 10.4545 3 19.65C3 28.8455 10.4545 36.3 19.65 36.3C28.8455 36.3 36.3 28.8455 36.3 19.65C36.3 10.4545 28.8455 3 19.65 3ZM13.6664 9.61366C14.0095 9.59343 14.3195 9.79847 14.5546 10.1624L16.831 14.4794C17.0706 14.9909 16.9344 15.5386 16.5769 15.9041L15.5343 16.9468C15.4699 17.035 15.4276 17.1343 15.4265 17.2435C15.8264 18.7913 17.0393 20.219 18.1094 21.2008C19.1795 22.1825 20.3297 23.5118 21.8227 23.8267C22.0073 23.8782 22.2333 23.8966 22.3654 23.7739L23.5767 22.5402C23.9949 22.2233 24.5998 22.0697 25.0462 22.3288H25.0665L29.1741 24.7536C29.7771 25.1315 29.8395 25.862 29.4078 26.3064L26.5787 29.1132C26.1609 29.5417 25.6058 29.6857 25.0666 29.6863C22.6815 29.6149 20.4279 28.4443 18.5769 27.2413C15.5386 25.0309 12.7515 22.2894 11.0019 18.9773C10.3308 17.5884 9.54251 15.8163 9.61774 14.266C9.62445 13.6828 9.78224 13.1115 10.1929 12.7356L13.0221 9.90639C13.2425 9.71886 13.4606 9.62581 13.6664 9.61366Z" />
</svg>';
$icon_whatsapp = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M31.7501 8.18335C30.2221 6.63989 28.4021 5.41613 26.3961 4.58344C24.3902 3.75074 22.2386 3.32579 20.0667 3.33335C10.9667 3.33335 3.55008 10.75 3.55008 19.85C3.55008 22.7667 4.31675 25.6 5.75008 28.1L3.41675 36.6667L12.1667 34.3667C14.5834 35.6833 17.3001 36.3834 20.0667 36.3834C29.1667 36.3834 36.5834 28.9667 36.5834 19.8667C36.5834 15.45 34.8667 11.3 31.7501 8.18335ZM20.0667 33.5833C17.6001 33.5833 15.1834 32.9167 13.0667 31.6667L12.5667 31.3667L7.36675 32.7333L8.75008 27.6667L8.41675 27.15C7.04632 24.9616 6.31865 22.4321 6.31675 19.85C6.31675 12.2833 12.4834 6.11668 20.0501 6.11668C23.7167 6.11668 27.1667 7.55002 29.7501 10.15C31.0292 11.4233 32.0429 12.9378 32.7324 14.6057C33.4219 16.2737 33.7735 18.0619 33.7667 19.8667C33.8001 27.4333 27.6334 33.5833 20.0667 33.5833ZM27.6001 23.3167C27.1834 23.1167 25.1501 22.1167 24.7834 21.9667C24.4001 21.8334 24.1334 21.7667 23.8501 22.1667C23.5667 22.5834 22.7834 23.5167 22.5501 23.7833C22.3167 24.0667 22.0667 24.1 21.6501 23.8834C21.2334 23.6833 19.9001 23.2334 18.3334 21.8334C17.1001 20.7334 16.2834 19.3834 16.0334 18.9667C15.8001 18.55 16.0001 18.3334 16.2167 18.1167C16.4001 17.9333 16.6334 17.6333 16.8334 17.4C17.0334 17.1667 17.1167 16.9833 17.2501 16.7167C17.3834 16.4333 17.3167 16.2 17.2167 16C17.1167 15.8 16.2834 13.7667 15.9501 12.9334C15.6167 12.1334 15.2667 12.2334 15.0167 12.2167H14.2167C13.9334 12.2167 13.5001 12.3167 13.1167 12.7334C12.7501 13.15 11.6834 14.15 11.6834 16.1834C11.6834 18.2167 13.1667 20.1834 13.3667 20.45C13.5667 20.7334 16.2834 24.9 20.4167 26.6833C21.4001 27.1167 22.1667 27.3667 22.7667 27.55C23.7501 27.8667 24.6501 27.8167 25.3667 27.7167C26.1667 27.6 27.8167 26.7167 28.1501 25.75C28.5001 24.7833 28.5001 23.9667 28.3834 23.7833C28.2667 23.6 28.0167 23.5167 27.6001 23.3167Z" />
</svg>';
$icon_telegram = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.9899 3.33325C16.6936 3.33325 13.4712 4.31073 10.7304 6.14209C7.98959 7.97345 5.85338 10.5764 4.59192 13.6219C3.33046 16.6673 3.00041 20.0184 3.6435 23.2514C4.28658 26.4844 5.87393 29.4542 8.2048 31.785C10.5357 34.1159 13.5054 35.7033 16.7384 36.3463C19.9714 36.9894 23.3225 36.6594 26.368 35.3979C29.4134 34.1365 32.0164 32.0002 33.8477 29.2594C35.6791 26.5186 36.6566 23.2963 36.6566 19.9999C36.6566 17.8112 36.2255 15.644 35.3879 13.6219C34.5503 11.5998 33.3227 9.76245 31.775 8.21481C30.2274 6.66716 28.3901 5.43951 26.368 4.60193C24.3459 3.76435 22.1786 3.33325 19.9899 3.33325ZM25.2899 28.5866C25.2277 28.7423 25.1329 28.8829 25.0119 28.9989C24.8909 29.1149 24.7464 29.2037 24.5882 29.2593C24.43 29.3149 24.2617 29.336 24.0947 29.3211C23.9277 29.3063 23.7658 29.2558 23.6199 29.1733L19.0949 25.6566L16.1916 28.3366C16.1242 28.3863 16.0454 28.4184 15.9624 28.4297C15.8794 28.4411 15.7949 28.4314 15.7166 28.4016L16.2732 23.4199L16.2899 23.4349L16.3016 23.3366C16.3016 23.3366 24.4432 15.9233 24.7749 15.6083C25.1116 15.2933 24.9999 15.2249 24.9999 15.2249C25.0199 14.8416 24.3982 15.2249 24.3982 15.2249L13.6099 22.1649L9.11825 20.6349C9.11825 20.6349 8.42825 20.3883 8.36325 19.8433C8.29492 19.3033 9.13992 19.0099 9.13992 19.0099L27.0016 11.9133C27.0016 11.9133 28.4699 11.2599 28.4699 12.3433L25.2899 28.5866Z" />
</svg>';
$icon_email = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M35.5 7H5.5C4.83696 7 4.20107 7.27393 3.73223 7.76152C3.26339 8.24912 3 8.91044 3 9.6V30.4C3 31.0896 3.26339 31.7509 3.73223 32.2385C4.20107 32.7261 4.83696 33 5.5 33H35.5C36.163 33 36.7989 32.7261 37.2678 32.2385C37.7366 31.7509 38 31.0896 38 30.4V9.6C38 8.91044 37.7366 8.24912 37.2678 7.76152C36.7989 7.27393 36.163 7 35.5 7ZM32.75 9.6L20.5 18.414L8.25 9.6H32.75ZM5.5 30.4V10.783L19.7875 21.066C19.9967 21.217 20.2453 21.2979 20.5 21.2979C20.7547 21.2979 21.0033 21.217 21.2125 21.066L35.5 10.783V30.4H5.5Z" />
</svg>';

if ($profipaints_contact_cf7 || $profipaints_contact_text || $profipaints_contact_address_title || $profipaints_contact_phone || $profipaints_contact_email || $profipaints_contact_telegram || $profipaints_contact_whatsapp) {
    $desc = wp_kses_post(get_theme_mod('profipaints_contact_desc'));
?>
    <?php if (!$disable) : ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
            <section id="<?php echo ($id !== '') ? esc_attr($id) : 'contact'; ?>" <?php do_action('profipaints_section_atts', 'contact'); ?> class="<?php echo $section_classes; ?>">
            <?php } ?>
            <?php do_action('profipaints_section_before_inner', 'contact'); ?>
            <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'contact')); ?>">
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
                    <?php if ($profipaints_contact_cf7_disable != '1') : ?>
                        <?php if (isset($profipaints_contact_cf7) && $profipaints_contact_cf7 != '') { ?>
                            <div class="contact-form col-sm-6 wow slideInUp">
                                <?php echo do_shortcode(wp_kses_post($profipaints_contact_cf7)); ?>
                            </div>
                        <?php } else { ?>
                            <div class="contact-form col-sm-6 wow slideInUp">
                                <br>
                                <small>
                                    <i><?php printf(esc_html__('You can install %1$s plugin and go to Customizer &rarr; Section: Contact &rarr; Section Content to show a working contact form here.', 'profipaints'), '<a href="' . esc_url('https://wordpress.org/plugins/pirate-forms/', 'profipaints') . '" target="_blank">Contact Form 7</a>'); ?></i>
                                </small>
                            </div>
                        <?php } ?>
                    <?php endif; ?>

                    <div class="col-sm-6 wow slideInUp">
                        <div class="address-box-text">
                            <?php
                            if ($profipaints_contact_text != '') {
                                echo apply_filters('profipaints_the_content', wp_kses_post(trim($profipaints_contact_text)));
                            }
                            ?>
                        </div>
                        <div class="address-box">
                            <h3><?php if ($profipaints_contact_address_title != '') {
                                    echo wp_kses_post($profipaints_contact_address_title);
                                } ?></h3>

                            <?php if ($profipaints_contact_address != '') : ?>
                                <div class="address-contact">
                                    <span class="svg_icon"><?php echo $icon_marker; ?></span>
                                    <div class="address-content"><?php echo wp_kses_post($profipaints_contact_address); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($profipaints_contact_phone != '') : ?>
                                <a href='tel:<?php echo $profipaints_contact_phone; ?>' class="address-contact">
                                    <span class="address-contact-icon"><?php echo $icon_phone; ?></span>
                                    <span class="address-content"><?php echo wp_kses_post($profipaints_contact_phone_text); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if ($profipaints_contact_whatsapp != '') : ?>
                                <a href='https://wa.me/<?php echo $profipaints_contact_whatsapp; ?>' class="address-contact">
                                    <span class="address-contact-icon"><?php echo $icon_whatsapp; ?></span>
                                    <div class="address-content"><?php echo wp_kses_post($profipaints_contact_whatsapp_text); ?></div>
                                </a>
                            <?php endif; ?>

                            <?php if ($profipaints_contact_telegram != '') : ?>
                                <a href='https://t.me/<?php echo $profipaints_contact_telegram; ?>' class="address-contact">
                                    <span class="address-contact-icon icon-telegram"><?php echo $icon_telegram; ?></span>
                                    <span class="address-content"><?php echo wp_kses_post($profipaints_contact_telegram_text); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if ($profipaints_contact_email != '') : ?>
                                <a href="mailto:<?php echo antispambot($profipaints_contact_email); ?>" class="address-contact">
                                    <span class="address-contact-icon icon-email"><?php echo $icon_email; ?></span>
                                    <span class="address-content"><?php echo antispambot($profipaints_contact_email_text); ?> </span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($profipaints_contact_yamap && $profipaints_contact_yamap_disable != '1') : ?>
                        <div class="col-sm-6 wow slideInUp">
                            <div class="contact-map">
                                <?php echo $profipaints_contact_yamap_iframe; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php do_action('profipaints_section_after_inner', 'contact'); ?>
            <?php if (!profipaints_is_selective_refresh()) { ?>
            </section>
        <?php } ?>
<?php endif;
}
