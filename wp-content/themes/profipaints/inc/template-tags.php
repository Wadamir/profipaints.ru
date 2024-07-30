<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ProfiPaints
 */

/**
 * Display header brand
 *
 * @since 1.2.1
 */
function profipaints_add_retina_logo($html)
{
    $custom_logo_id = get_theme_mod('custom_logo');

    $custom_logo_attr = array(
        'class'    => 'custom-logo',
        'itemprop' => 'logo',
    );
    $image_retina_url = false;
    $retina_id = false;
    $retina_url = sanitize_text_field(get_theme_mod('profipaints_retina_logo'));
    if ($retina_url) {
        $retina_id = attachment_url_to_postid($retina_url);
        if ($retina_id) {
            $image_retina_url = wp_get_attachment_image_src($retina_id, 'full');
            if ($image_retina_url) {
                $custom_logo_attr['srcset'] = $image_retina_url[0] . ' 2x';
            }
        }
    }

    if (!$custom_logo_id) {
        $custom_logo_id = $retina_id;
    }

    $t_logo_html = '';

    if (profipaints_is_transparent_header()) {
        $t_logo = sanitize_text_field(get_theme_mod('profipaints_transparent_logo'));
        $t_logo_r = sanitize_text_field(get_theme_mod('profipaints_transparent_retina_logo'));
        $t_logo_attr = array(
            'class'    => 'custom-logo-transparent',
            'itemprop' => 'logo',
        );

        if ($t_logo_r) {
            $t_logo_r = attachment_url_to_postid($t_logo_r);
            if ($t_logo_r) {
                $image_tr_url = wp_get_attachment_image_src($t_logo_r, 'full');
                if ($image_tr_url) {
                    $t_logo_attr['srcset'] = $image_tr_url[0] . ' 2x';
                }
            }
        }

        if ($t_logo) {
            $t_logo = attachment_url_to_postid($t_logo);
        }
        if (!$t_logo) {
            $t_logo = $t_logo_r;
        }

        if ($t_logo) {
            $t_logo_html = wp_get_attachment_image($t_logo, 'full', false, $t_logo_attr);
        }
    }

    // We have a logo. Logo is go.
    if ($custom_logo_id) {

        /*
		 * If the logo alt attribute is empty, get the site title and explicitly
		 * pass it to the attributes used by wp_get_attachment_image().
		 */
        $image_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
        if (empty($image_alt)) {
            $custom_logo_attr['alt'] = get_bloginfo('name', 'display');
        }

        if (!$t_logo_html) {
            $class = ' no-t-logo';
        } else {
            $class = ' has-t-logo';
        }

        /*
		 * If the alt attribute is not empty, there's no need to explicitly pass
		 * it because wp_get_attachment_image() already adds the alt attribute.
		 */
        $html = sprintf(
            '<a href="%1$s" class="custom-logo-link ' . esc_attr($class) . '" rel="home" itemprop="url">%2$s</a>',
            esc_url(home_url('/')),
            wp_get_attachment_image($custom_logo_id, 'full', false, $custom_logo_attr) . $t_logo_html
        );
    }

    return $html;
}

add_filter('get_custom_logo', 'profipaints_add_retina_logo', 15);


if (!function_exists('profipaints_site_logo')) {
    function profipaints_site_logo()
    {
        $classes = array();
        $html = '';
        $classes['logo'] = 'no-logo-img';

        if (function_exists('has_custom_logo')) {
            if (has_custom_logo()) {
                $classes['logo'] = 'has-logo-img';
                $html .= '<div class="site-logo-div desktop_logo">';
                $html .= get_custom_logo();
                $html .= '</div>';
            }
        }

        $mobile_logo = get_theme_mod('profipaints_mobile_logo');

        if ($mobile_logo != '') {
            $html .= '<div class="site-logo-div mobile_logo">';
            $html .= '<a href="http://wp.test:8080/" class="custom-logo-link  no-t-logo" rel="home" itemprop="url"><img height="54" src="';
            $html .= $mobile_logo;
            $html .= '" class="custom-logo" alt="Teplo50" decoding="async" loading="lazy" itemprop="logo"></a>';
            $html .= '</div>';
        }

        $hide_sitetile = get_theme_mod('profipaints_hide_sitetitle', 0);
        $hide_tagline  = get_theme_mod('profipaints_hide_tagline', 0);

        if (!$hide_sitetile) {
            $classes['title'] = 'has-title';
            if (is_front_page() && !is_home()) {
                $html .= '<h1 class="site-title"><a class="site-text-logo" href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></h1>';
            } else {
                $html .= '<p class="site-title"><a class="site-text-logo" href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></p>';
            }
        }

        if (!$hide_tagline) {
            $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) {
                $classes['desc'] = 'has-desc';
                $html .= '<p class="site-description">' . $description . '</p>';
            }
        } else {
            $classes['desc'] = 'no-desc';
        }

        echo '<div class="site-brand-inner ' . esc_attr(join(' ', $classes)) . '">' . $html . '</div>';
    }
}

if (!function_exists('profipaints_is_transparent_header')) {
    function profipaints_is_transparent_header()
    {
        $check = false;
        if (is_front_page() && is_page_template('template-frontpage.php')) {
            if (get_theme_mod('profipaints_header_transparent')) {
                $check = true;
            }
        } elseif (is_page() && has_post_thumbnail()) {
            if (!get_post_meta(get_the_ID(), '_cover', true)) {
                return false;
            }
            if (get_theme_mod('profipaints_page_title_bar_disable') == 1) {
                return false;
            }
            if (has_post_thumbnail()) {
                if (get_theme_mod('profipaints_header_transparent')) {
                    $check = true;
                }
            }
        } elseif (is_home()) {
            if (get_theme_mod('profipaints_page_title_bar_disable') == 1) {
                return false;
            }

            $new_page = get_option('page_for_posts');
            if (!get_post_meta($new_page, '_cover', true)) {
                return false;
            }

            if (has_post_thumbnail($new_page)) {
                if (get_theme_mod('profipaints_header_transparent')) {
                    $check = true;
                }
            }
        }

        return $check;
    }
}

add_action('profipaints_site_start', 'profipaints_site_header');
if (!function_exists('profipaints_site_header')) {
    /**
     * Display site header
     */
    function profipaints_site_header()
    {
        $header_width = get_theme_mod('profipaints_header_width', 'contained');
        $is_disable_sticky = sanitize_text_field(get_theme_mod('profipaints_sticky_header_disable'));
        $classes = array(
            'site-header',
            'header-' . $header_width,
        );

        if ($is_disable_sticky != 1) {
            $classes[] = 'is-sticky no-scroll';
        } else {
            $classes[] = 'no-sticky no-scroll';
        }

        $transparent = 'no-t';
        if (profipaints_is_transparent_header()) {
            $transparent = 'is-t';
        }
        $classes[] = $transparent;

        $pos = sanitize_text_field(get_theme_mod('profipaints_header_position', 'top'));
        if ($pos == 'below_hero') {
            $classes[] = 'h-below-hero';
        } else {
            $classes[] = 'h-on-top';
        }
        $header_main_phone = get_theme_mod('profipaints_main_phone');
        $header_whatsapp_phone = get_theme_mod('profipaints_whatsapp_phone');
        $header_telegram_phone = get_theme_mod('profipaints_telegram_phone');
?>
        <header id="masthead" class="<?php echo esc_attr(join(' ', $classes)); ?>" role="banner">
            <div class="container">
                <div class="site-branding">
                    <?php
                    profipaints_site_logo();
                    ?>
                </div>
                <div class="header-right-wrapper text-right">
                    <?php if ($header_main_phone != '' || $header_whatsapp_phone != '' || $header_telegram_phone != '') { ?>
                        <div class="header_phones d-flex">
                            <?php if ($header_whatsapp_phone != '') {
                                echo "<a href=' https://wa.me/$header_whatsapp_phone' class='d-flex header_phones_item'>
									<span class='header_phone_icon header_phone_icon_whatsapp'>
									<svg fill='none' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'><path d='M31.7501 8.18332C30.2221 6.63986 28.4021 5.4161 26.3961 4.58341C24.3902 3.75071 22.2386 3.32575 20.0667 3.33332C10.9667 3.33332 3.55008 10.75 3.55008 19.85C3.55008 22.7667 4.31675 25.6 5.75008 28.1L3.41675 36.6667L12.1667 34.3667C14.5834 35.6833 17.3001 36.3833 20.0667 36.3833C29.1667 36.3833 36.5834 28.9667 36.5834 19.8667C36.5834 15.45 34.8667 11.3 31.7501 8.18332ZM20.0667 33.5833C17.6001 33.5833 15.1834 32.9167 13.0667 31.6667L12.5667 31.3667L7.36675 32.7333L8.75008 27.6667L8.41675 27.15C7.04632 24.9616 6.31865 22.4321 6.31675 19.85C6.31675 12.2833 12.4834 6.11665 20.0501 6.11665C23.7167 6.11665 27.1667 7.54999 29.7501 10.15C31.0292 11.4233 32.0429 12.9378 32.7324 14.6057C33.4219 16.2736 33.7735 18.0618 33.7667 19.8667C33.8001 27.4333 27.6334 33.5833 20.0667 33.5833ZM27.6001 23.3167C27.1834 23.1167 25.1501 22.1167 24.7834 21.9667C24.4001 21.8333 24.1334 21.7667 23.8501 22.1667C23.5667 22.5833 22.7834 23.5167 22.5501 23.7833C22.3167 24.0667 22.0667 24.1 21.6501 23.8833C21.2334 23.6833 19.9001 23.2333 18.3334 21.8333C17.1001 20.7333 16.2834 19.3833 16.0334 18.9667C15.8001 18.55 16.0001 18.3333 16.2167 18.1167C16.4001 17.9333 16.6334 17.6333 16.8334 17.4C17.0334 17.1667 17.1167 16.9833 17.2501 16.7167C17.3834 16.4333 17.3167 16.2 17.2167 16C17.1167 15.8 16.2834 13.7667 15.9501 12.9333C15.6167 12.1333 15.2667 12.2333 15.0167 12.2167H14.2167C13.9334 12.2167 13.5001 12.3167 13.1167 12.7333C12.7501 13.15 11.6834 14.15 11.6834 16.1833C11.6834 18.2167 13.1667 20.1833 13.3667 20.45C13.5667 20.7333 16.2834 24.9 20.4167 26.6833C21.4001 27.1167 22.1667 27.3667 22.7667 27.55C23.7501 27.8667 24.6501 27.8167 25.3667 27.7167C26.1667 27.6 27.8167 26.7167 28.1501 25.75C28.5001 24.7833 28.5001 23.9667 28.3834 23.7833C28.2667 23.6 28.0167 23.5167 27.6001 23.3167Z' /></svg>
                                    </span>
								</a>";
                            } ?>
                            <?php if ($header_telegram_phone != '') {
                                echo "<a href='https://t.me/$header_telegram_phone' class='d-flex header_phones_item'>
									<span class='header_phone_icon header_phone_icon_telegram'>
									<svg viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M19.9899 3.33334C16.6936 3.33334 13.4712 4.31083 10.7304 6.14218C7.98959 7.97354 5.85338 10.5765 4.59192 13.622C3.33046 16.6674 3.00041 20.0185 3.6435 23.2515C4.28658 26.4845 5.87393 29.4542 8.2048 31.7851C10.5357 34.116 13.5054 35.7034 16.7384 36.3464C19.9714 36.9895 23.3225 36.6595 26.368 35.398C29.4134 34.1365 32.0164 32.0003 33.8477 29.2595C35.6791 26.5187 36.6566 23.2964 36.6566 20C36.6566 17.8113 36.2255 15.644 35.3879 13.622C34.5503 11.5999 33.3227 9.76254 31.775 8.2149C30.2274 6.66725 28.3901 5.4396 26.368 4.60202C24.3459 3.76444 22.1786 3.33334 19.9899 3.33334ZM25.2899 28.5867C25.2277 28.7424 25.1329 28.883 25.0119 28.999C24.8909 29.115 24.7464 29.2038 24.5882 29.2594C24.43 29.315 24.2617 29.336 24.0947 29.3212C23.9277 29.3064 23.7658 29.2559 23.6199 29.1733L19.0949 25.6567L16.1916 28.3367C16.1242 28.3864 16.0454 28.4185 15.9624 28.4298C15.8794 28.4412 15.7949 28.4315 15.7166 28.4017L16.2732 23.42L16.2899 23.435L16.3016 23.3367C16.3016 23.3367 24.4432 15.9233 24.7749 15.6083C25.1116 15.2933 24.9999 15.225 24.9999 15.225C25.0199 14.8417 24.3982 15.225 24.3982 15.225L13.6099 22.165L9.11825 20.635C9.11825 20.635 8.42825 20.3883 8.36325 19.8433C8.29492 19.3033 9.13992 19.01 9.13992 19.01L27.0016 11.9133C27.0016 11.9133 28.4699 11.26 28.4699 12.3433L25.2899 28.5867Z' /></svg>
									</span>
								</a>";
                            } ?>
                            <?php if ($header_main_phone != '') {
                                echo "<a href='tel:$header_main_phone' class='d-flex header_phones_item'>
									<span class='header_phone_icon header_phone_icon_main'>
									<svg viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M19.65 3C10.4545 3 3 10.4545 3 19.65C3 28.8455 10.4545 36.3 19.65 36.3C28.8455 36.3 36.3 28.8455 36.3 19.65C36.3 10.4545 28.8455 3 19.65 3ZM13.6664 9.61366C14.0095 9.59343 14.3195 9.79847 14.5546 10.1624L16.831 14.4794C17.0706 14.9909 16.9344 15.5386 16.5769 15.9041L15.5343 16.9468C15.4699 17.035 15.4276 17.1343 15.4265 17.2435C15.8264 18.7913 17.0393 20.219 18.1094 21.2008C19.1795 22.1825 20.3297 23.5118 21.8227 23.8267C22.0073 23.8782 22.2333 23.8966 22.3654 23.7739L23.5767 22.5402C23.9949 22.2233 24.5998 22.0697 25.0462 22.3288H25.0665L29.1741 24.7536C29.7771 25.1315 29.8395 25.862 29.4078 26.3064L26.5787 29.1132C26.1609 29.5417 25.6058 29.6857 25.0666 29.6863C22.6815 29.6149 20.4279 28.4443 18.5769 27.2413C15.5386 25.0309 12.7515 22.2894 11.0019 18.9773C10.3308 17.5884 9.54251 15.8163 9.61774 14.266C9.62445 13.6828 9.78224 13.1115 10.1929 12.7356L13.0221 9.90639C13.2425 9.71886 13.4606 9.62581 13.6664 9.61366Z' /></svg>
									</span>
									<span class='header_phone_text hidden-xs'>$header_main_phone</span>
								</a>";
                            } ?>
                        </div>
                    <?php } ?>
                    <div class="menu_wrapper">
                        <!-- #site-navigation start -->
                        <a href="#0" id="nav-toggle" style="display:none;"><?php _e('Menu', 'profipaints'); ?><span></span></a>
                        <input type="checkbox" id="active-menu">
                        <label for="active-menu" class="menu-btn"></label>
                        <nav id="site-navigation" class="menu-wrapper main-navigation" role="navigation">
                            <ul class="profipaints-menu">
                                <?php wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'container' => '',
                                        'items_wrap' => '%3$s',
                                    )
                                ); ?>
                            </ul>
                        </nav>
                        <!-- #site-navigation end -->
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->
        <?php
    }
}

if (!function_exists('profipaints_header')) {
    /**
     * @since 2.0.0
     */
    function profipaints_header()
    {
        $transparent = 'no-transparent';
        $classes = array();
        if (profipaints_is_transparent_header()) {
            $transparent = 'is-transparent';
        }
        $pos = sanitize_text_field(get_theme_mod('profipaints_header_position', 'top'));
        if ($pos == 'below_hero') {
            $transparent = 'no-transparent';
            $classes[] = 'h-below-hero';
        } else {
            $classes[] = 'h-on-top';
        }

        $classes[] = $transparent;

        echo '<div id="header-section" class="' . esc_attr(join(' ', $classes)) . '">';

        do_action('profipaints_header_section_start');
        if ($pos == 'below_hero') {
            if (is_page_template('template-frontpage.php')) {
                do_action('profipaints_header_end');
            }
        }

        $hide_header = false;
        $page_id = false;
        if (is_singular() || is_page()) {
            $page_id = get_the_ID();
        }
        if (profipaints_is_wc_active()) {
            if (is_shop()) {
                $page_id = wc_get_page_id('shop');
            }
        }

        if ($page_id) {
            $hide_header = get_post_meta($page_id, '_hide_header', true);
        }

        if (!$hide_header) {
            /**
             * Hooked: profipaints_site_header
             *
             * @see profipaints_site_header
             */
            do_action('profipaints_site_start');
        }

        if ($pos != 'below_hero') {
            if (is_page_template('template-frontpage.php')) {
                do_action('profipaints_header_end');
            }
        }

        do_action('profipaints_header_section_end');
        echo '</div>';
    }
}

if (!function_exists('profipaints_posted_on')) {
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function profipaints_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated hide" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            esc_html_x('Posted on %s', 'post date', 'profipaints'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
            esc_html_x('by %s', 'post author', 'profipaints'),
            '<span class="author vcard"><a  rel="author" class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

    }
}

if (!function_exists('profipaints_entry_footer')) {
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function profipaints_entry_footer()
    {

        ob_start();

        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'profipaints'));
            if ($categories_list && profipaints_categorized_blog()) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'profipaints') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'profipaints'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'profipaints') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(esc_html__('Leave a comment', 'profipaints'), esc_html__('1 Comment', 'profipaints'), esc_html__('% Comments', 'profipaints'));
            echo '</span>';
        }

        $content = ob_get_contents();
        ob_clean();
        ob_end_flush();

        if ($content) {
            echo '<footer class="entry-footer">';
            echo $content; // // WPCS: XSS OK.
            echo '</footer><!-- .entry-footer -->';
        }
    }
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function profipaints_categorized_blog()
{
    if (false === ($all_the_cool_cats = get_transient('profipaints_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(
            array(
                'fields'     => 'ids',
                'hide_empty' => 1,

                // We only need to know if there is more than one category.
                'number'     => 2,
            )
        );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = (!is_wp_error($all_the_cool_cats) && is_array($all_the_cool_cats) && !empty($all_the_cool_cats)) ? count($all_the_cool_cats) : 1;

        set_transient('profipaints_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so profipaints_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so profipaints_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in profipaints_categorized_blog.
 */
function profipaints_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('profipaints_categories');
}
add_action('edit_category', 'profipaints_category_transient_flusher');
add_action('save_post', 'profipaints_category_transient_flusher');


if (!function_exists('profipaints_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own profipaints_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @return void
     */
    function profipaints_comment($comment, $args, $depth)
    {
        switch ($comment->comment_type):
            case 'pingback':
            case 'trackback':
                // Display trackbacks differently than normal comments.
        ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p><?php _e('Pingback:', 'profipaints'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'profipaints'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
            default:
                // Proceed with normal comments.
                global $post;
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment clearfix">

                        <?php echo get_avatar($comment, 60); ?>

                        <div class="comment-wrapper">

                            <header class="comment-meta comment-author vcard">
                                <?php
                                printf(
                                    '<cite><b class="fn">%1$s</b> %2$s</cite>',
                                    get_comment_author_link(),
                                    // If current post author is also comment author, make it known visually.
                                    ($comment->user_id === $post->post_author) ? '<span>' . __('Post author', 'profipaints') . '</span>' : ''
                                );
                                printf(
                                    '<a class="comment-time" href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                    esc_url(get_comment_link($comment->comment_ID)),
                                    get_comment_time('c'),
                                    /* translators: 1: date, 2: time */
                                    get_comment_date()
                                );
                                comment_reply_link(
                                    array_merge(
                                        $args,
                                        array(
                                            'reply_text' => __('Reply', 'profipaints'),
                                            'after' => '',
                                            'depth' => $depth,
                                            'max_depth' => $args['max_depth'],
                                        )
                                    )
                                );
                                edit_comment_link(__('Edit', 'profipaints'), '<span class="edit-link">', '</span>');
                                ?>
                            </header><!-- .comment-meta -->

                            <?php if ('0' == $comment->comment_approved) : ?>
                                <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'profipaints'); ?></p>
                            <?php endif; ?>

                            <div class="comment-content entry-content">
                                <?php comment_text(); ?>
                            </div><!-- .comment-content -->

                        </div><!--/comment-wrapper-->

                    </article><!-- #comment-## -->
            <?php
                break;
        endswitch; // end comment_type check
    }
endif;

if (!function_exists('profipaints_hex_to_rgba')) {
    /**
     * Convert hex color to rgba color
     *
     * @since 1.1.5
     *
     * @param $color
     * @param int   $alpha
     * @return bool|string
     */
    function profipaints_hex_to_rgba($color, $alpha = 1)
    {
        $color = str_replace('#', '', $color);
        if ('' === $color) {
            return '';
        }

        if (strpos(trim($color), 'rgb') !== false) {
            return $color;
        }

        // 3 or 6 hex digits, or the empty string.
        if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', '#' . $color)) {
            // convert to rgb
            $colour = $color;
            if (strlen($colour) == 6) {
                list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
            } elseif (strlen($colour) == 3) {
                list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
            } else {
                return false;
            }
            $r = hexdec($r);
            $g = hexdec($g);
            $b = hexdec($b);
            return 'rgba(' . join(
                ',',
                array(
                    'r' => $r,
                    'g' => $g,
                    'b' => $b,
                    'a' => $alpha,
                )
            ) . ')';
        }

        return false;
    }
}



if (!function_exists('profipaints_custom_inline_style')) {
    /**
     * Add custom css to header
     *
     * @change 1.1.5
     */
    function profipaints_custom_inline_style()
    {

        $logo_height = absint(get_theme_mod('profipaints_logo_height'));
        $logo_tran_height = absint(get_theme_mod('profipaints_transparent_logo_height'));

        /**
         *  Custom hero section css
         */
        $hero_bg_color = profipaints_hex_to_rgba(get_theme_mod('profipaints_hero_overlay_color', '#000000'), .3);

        // Deprecate form v 1.1.5
        $hero_bg_color = profipaints_hex_to_rgba($hero_bg_color, floatval(get_theme_mod('profipaints_hero_overlay_opacity', .3)));

        ob_start();

        if ($logo_height > 0) {
            echo ".site-logo-div img{ height: {$logo_height}px; width: auto; }";
        }

        if ($logo_tran_height) {
            echo ".site-logo-div img.custom-logo-transparent{ height: {$logo_tran_height}px; width: auto; }";
        }

        $t_site_name_color = sanitize_hex_color(get_theme_mod('profipaints_transparent_site_title_c'));
        if ($t_site_name_color) {
            echo "#page .is-transparent .site-header.no-scroll .site-title, #page .is-transparent .site-header.no-scroll .site-title .site-text-logo { color: {$t_site_name_color}; }";
        }
        $t_tagline_color = sanitize_hex_color(get_theme_mod('profipaints_transparent_tag_title_c'));
        if ($t_tagline_color) {
            echo "#page .is-transparent .site-header.no-scroll .site-description { color: {$t_tagline_color}; }";
        }

            ?>
            #main .video-section section.hero-slideshow-wrapper {
            background: transparent;
            }
            .hero-slideshow-wrapper:after {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background-color: <?php echo $hero_bg_color; ?>;
            display: block;
            content: "";
            }
            .body-desktop .parallax-hero .hero-slideshow-wrapper:after {
            display: none !important;
            }
            #parallax-hero > .parallax-bg::before {
            background-color: <?php echo $hero_bg_color; ?>;
            opacity: 1;
            }
            .body-desktop .parallax-hero .hero-slideshow-wrapper:after {
            display: none !important;
            }

            <?php
            /**
             * Theme Color
             */
            $primary = sanitize_hex_color_no_hash(get_theme_mod('profipaints_primary_color'));
            /*
            if ($primary != '') { ?>
                a, .screen-reader-text:hover, .screen-reader-text:active, .screen-reader-text:focus, .header-social a, .profipaints-menu a:hover,
                .profipaints-menu ul li a:hover, .profipaints-menu li.profipaints-current-item > a, .profipaints-menu ul li.current-menu-item > a, .profipaints-menu > li a.menu-actived,
                .profipaints-menu.profipaints-menu-mobile li.profipaints-current-item > a, .site-footer a, .site-footer .footer-social a:hover, .site-footer .btt a:hover,
                .highlight, #comments .comment .comment-wrapper .comment-meta .comment-time:hover, #comments .comment .comment-wrapper .comment-meta .comment-reply-link:hover, #comments .comment .comment-wrapper .comment-meta .comment-edit-link:hover,
                .btn-theme-primary-outline, .sidebar .widget a:hover, .section-services .service-item .service-image i, .counter_item .counter__number,
                .team-member .member-thumb .member-profile a:hover, .icon-background-default
                {
                color: #<?php echo $primary; ?>;
                }
                input[type="reset"], input[type="submit"], input[type="submit"], input[type="reset"]:hover, input[type="submit"]:hover, input[type="submit"]:hover .nav-links a:hover, .btn-theme-primary, .btn-theme-primary-outline:hover, .section-testimonials .card-theme-primary,
                .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce button.button.alt,
                .pirate-forms-submit-button, .pirate-forms-submit-button:hover, input[type="reset"], input[type="submit"], input[type="submit"], .pirate-forms-submit-button,
                .contact-form div.wpforms-container-full .wpforms-form .wpforms-submit,
                .contact-form div.wpforms-container-full .wpforms-form .wpforms-submit:hover,
                .nav-links a:hover, .nav-links a.current,
                .nav-links .page-numbers:hover,
                .nav-links .page-numbers.current
                {
                background: #<?php echo $primary; ?>;
                }
                .btn-theme-primary-outline, .btn-theme-primary-outline:hover, .pricing__item:hover, .section-testimonials .card-theme-primary, .entry-content blockquote
                {
                border-color : #<?php echo $primary; ?>;
                }
                <?php
                if (class_exists('WooCommerce')) { ?>
                    .woocommerce #respond input#submit.alt,
                    .woocommerce a.button.alt,
                    .woocommerce button.button.alt,
                    .woocommerce input.button.alt {
                    background-color: #<?php echo $primary; ?>;
                    }
                    .woocommerce #respond input#submit.alt:hover,
                    .woocommerce a.button.alt:hover,
                    .woocommerce button.button.alt:hover,
                    .woocommerce input.button.alt:hover {
                    background-color: #<?php echo $primary; ?>;
                    }
                <?php }
            } // End $primary
            */

            /**
             * Theme Secondary Color
             *
             * @since 2.2.1
             */
            $secondary_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_secondary_color'));
            // if ('' != $secondary_color) {
            //     echo ".feature-item:hover .icon-background-default{ color: #{$secondary_color}; }";
            // }

            /**
             * Theme colors
             */
            $profipaints_primary_text_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_primary_text_color'));
            $profipaints_secondary_text_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_secondary_text_color'));
            $profipaints_accent_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_accent_color'));
            $profipaints_secondary_accent_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_secondary_accent_color'));
            $profipaints_background_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_background_color'));
            $profipaints_background_meta_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_background_meta_color'));

            if ('' != $profipaints_primary_text_color || '' != $profipaints_secondary_text_color || '' != $profipaints_accent_color || '' != $profipaints_secondary_accent_color || '' != $profipaints_background_color || '' != $profipaints_background_meta_color) {
                echo ':root {';
            }

            if ('' != $profipaints_primary_text_color) {
                echo "--primary-text-color: #{$profipaints_primary_text_color};";
            }
            if ('' != $profipaints_secondary_text_color) {
                echo "--secondary-text-color: #{$profipaints_secondary_text_color};";
            }
            if ('' != $profipaints_accent_color) {
                echo "--accent-color: #{$profipaints_accent_color};";
                $r = hexdec(substr($profipaints_accent_color, 0, 2));
                $g = hexdec(substr($profipaints_accent_color, 2, 2));
                $b = hexdec(substr($profipaints_accent_color, 4, 2));
                echo "--accent-transparent-color: rgba({$r},{$g},{$b},.85);";
                echo "--accent-transparent2-color: rgba({$r},{$g},{$b},.5);";
            }
            if ('' != $profipaints_secondary_accent_color) {
                echo "--accent-secondary-color: #{$profipaints_secondary_accent_color};";
            }
            if ('' != $profipaints_background_color) {
                echo "--background-color: #{$profipaints_background_color};";
            }
            if ('' != $profipaints_background_meta_color) {
                echo "--background-meta-color: #{$profipaints_background_meta_color};";
            }

            if ('' != $profipaints_primary_text_color || '' != $profipaints_secondary_text_color || '' != $profipaints_accent_color || '' != $profipaints_secondary_accent_color || '' != $profipaints_background_color || '' != $profipaints_background_meta_color) {
                echo '}';
            }


            $menu_padding = get_theme_mod('profipaints_menu_item_padding');
            if ($menu_padding) {
                $menu_padding = absint($menu_padding);
                echo ".profipaints-menu a{ padding-left: {$menu_padding}px; padding-right: {$menu_padding}px;  }";
            }

            $cover_align = sanitize_text_field(get_theme_mod('profipaints_page_cover_align'));
            switch ($cover_align) {
                case 'left':
                case 'right':
                    echo ".page-header.page--cover{ text-align: {$cover_align}; }";
                    break;
            }

            $normal_title_align = sanitize_text_field(get_theme_mod('profipaints_page_normal_align'));
            if ('' != $normal_title_align && in_array($normal_title_align, array('left', 'right', 'center'))) {
                echo ".page-header:not(.page--cover){ text-align: {$normal_title_align}; }";
            }

            $cover_color = profipaints_sanitize_color_alpha(get_theme_mod('profipaints_page_cover_color'));
            if ($cover_color) {
                echo " .page-header.page--cover .entry-title { color: {$cover_color}; } .page-header .entry-title { color: {$cover_color}; }";
            }

            $cover_overlay = profipaints_sanitize_color_alpha(get_theme_mod('profipaints_page_cover_overlay'));
            if ($cover_overlay) {
                echo ".page-header.page--cover:before { background: {$cover_overlay}; } .page-header:before { background: {$cover_overlay}; }";
            }
            $cover_pd_top = absint(get_theme_mod('profipaints_page_cover_pd_top'));
            if ($cover_pd_top > 0) {
                echo ".page-header.page--cover { padding-top: {$cover_pd_top}%; } .page-header { padding-top: {$cover_pd_top}%; }";
            }
            $cover_pd_bottom = absint(get_theme_mod('profipaints_page_cover_pd_bottom'));
            if ($cover_pd_bottom > 0) {
                echo ".page-header.page--cover { padding-bottom: {$cover_pd_bottom}%; } .page-header { padding-bottom: {$cover_pd_bottom}%; }";
            }

            /**
             * Header background
             */
            $header_bg_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_header_bg_color'));
            if ($header_bg_color) {
            ?>
                .site-header, .is-transparent .site-header.header-fixed {
                background: #<?php echo $header_bg_color; ?>;
                border-bottom: 0px none;
                }
            <?php
            } // END $header_bg_color

            /**
             * Menu color
             */
            $menu_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_menu_color'));
            if ($menu_color) {
            ?>
                .profipaints-menu > li > a {
                color: #<?php echo $menu_color; ?>;
                }
            <?php
            } // END $menu_color

            /**
             * Menu hover color
             */
            $menu_hover_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_menu_hover_color'));
            if ($menu_hover_color) {
            ?>
                .profipaints-menu > li > a:hover,
                .profipaints-menu > li.profipaints-current-item > a{
                color: #<?php echo $menu_hover_color; ?>;
                -webkit-transition: all 0.5s ease-in-out;
                -moz-transition: all 0.5s ease-in-out;
                -o-transition: all 0.5s ease-in-out;
                transition: all 0.5s ease-in-out;
                }
            <?php
            } // END $menu_hover_color

            /**
             * Menu hover background color
             */
            $menu_hover_bg = sanitize_hex_color_no_hash(get_theme_mod('profipaints_menu_hover_bg_color'));
            if ($menu_hover_bg) {
            ?>
                @media screen and (min-width: 1140px) {
                .profipaints-menu > li:last-child > a {
                padding-right: 17px;
                }
                .profipaints-menu > li > a:hover,
                .profipaints-menu > li.profipaints-current-item > a
                {
                background: #<?php echo $menu_hover_bg; ?>;
                -webkit-transition: all 0.5s ease-in-out;
                -moz-transition: all 0.5s ease-in-out;
                -o-transition: all 0.5s ease-in-out;
                transition: all 0.5s ease-in-out;
                }
                }
            <?php
            } // END $menu_hover_bg

            /**
             * Reponsive Mobie button color
             */
            $menu_button_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_menu_toggle_button_color'));
            if ($menu_button_color) {
            ?>
                #nav-toggle span, #nav-toggle span::before, #nav-toggle span::after,
                #nav-toggle.nav-is-visible span::before, #nav-toggle.nav-is-visible span::after {
                background: #<?php echo $menu_button_color; ?>;
                }
            <?php
            }

            /**
             * Site Title
             */
            $profipaints_logo_text_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_logo_text_color'));
            if ($profipaints_logo_text_color) {
            ?>
                #page .site-branding .site-title, #page .site-branding .site-text-logo {
                color: #<?php echo $profipaints_logo_text_color; ?>;
                }
            <?php
            }
            $profipaints_site_tagline_color = sanitize_hex_color_no_hash(get_theme_mod('profipaints_tagline_text_color'));
            if ($profipaints_site_tagline_color) {
                echo "#page .site-branding .site-description { color: #{$profipaints_site_tagline_color};  } ";
            }

            $r_text = sanitize_hex_color(get_theme_mod('profipaints_hcl1_r_color'));
            $r_bg_text = sanitize_hex_color(get_theme_mod('profipaints_hcl1_r_bg_color'));
            if ($r_text) {
            ?>
                .hero-content-style1 .morphext {
                color: <?php echo $r_text; ?>;
                }
            <?php
            }
            if ($r_bg_text) {
            ?>
                .hero-content-style1 .morphext {
                background: <?php echo $r_bg_text; ?>;
                padding: 0px 20px;
                text-shadow: none;
                border-radius: 3px;
                }
            <?php
            }

            $profipaints_footer_bg = sanitize_hex_color_no_hash(get_theme_mod('profipaints_footer_bg'));
            $footer_top_text = sanitize_hex_color(get_theme_mod('profipaints_footer_top_color'));
            if ($profipaints_footer_bg) {
            ?>
                .site-footer {
                background-color: #<?php echo $profipaints_footer_bg; ?>;
                }
                .site-footer .footer-connect .follow-heading, .site-footer .footer-social a {
                color: <?php echo ($footer_top_text) ? $footer_top_text : 'rgba(255, 255, 255, 0.9)'; ?>;
                }
            <?php
            } elseif ($footer_top_text) {
            ?>
                .site-footer .footer-connect .follow-heading, .site-footer .footer-social a {
                color: <?php echo $footer_top_text; ?>;
                }
            <?php
            }

            $profipaints_footer_info_bg = sanitize_hex_color_no_hash(get_theme_mod('profipaints_footer_info_bg'));
            $c_color = sanitize_hex_color(get_theme_mod('profipaints_footer_c_color'));
            $c_link_color = sanitize_hex_color(get_theme_mod('profipaints_footer_c_link_color'));
            $c_link_hover_color = sanitize_hex_color(get_theme_mod('profipaints_footer_c_link_hover_color'));
            if ($profipaints_footer_info_bg) {
            ?>
                .site-footer .site-info, .site-footer .btt a{
                background-color: #<?php echo $profipaints_footer_info_bg; ?>;

                }
                <?php if ($c_color) { ?>
                    .site-footer .site-info {
                    color: <?php echo $c_color; ?>;
                    }
                    .site-footer .btt a, .site-footer .site-info a {
                    color: <?php echo $c_color; ?>;
                    }
                <?php
                } else {
                ?>
                    .site-footer .site-info {
                    color: rgba(255, 255, 255, 0.7);
                    }
                    .site-footer .btt a, .site-footer .site-info a {
                    color: rgba(255, 255, 255, 0.9);
                    }
                <?php
                }
            } elseif ($c_color) {
                ?>
                .site-footer .site-info {
                color: <?php echo $c_color; ?>;
                }

            <?php
            }
            if ($c_link_color) {
            ?>
                .site-footer .btt a, .site-footer .site-info a {
                color: <?php echo $c_link_color; ?>;
                }
            <?php
            }
            if ($c_link_hover_color) {
            ?>
                .site-footer .btt a:hover, .site-footer .site-info a:hover {
                color: <?php echo $c_link_hover_color; ?>;
                }
            <?php
            }

            $footer_widgets_color = sanitize_hex_color(get_theme_mod('footer_widgets_color'));
            $footer_widgets_bg_color = sanitize_hex_color(get_theme_mod('footer_widgets_bg_color'));
            $footer_widgets_title_color = sanitize_hex_color(get_theme_mod('footer_widgets_title_color'));
            $footer_widgets_link_color = sanitize_hex_color(get_theme_mod('footer_widgets_link_color'));
            $footer_widgets_link_hover_color = sanitize_hex_color(get_theme_mod('footer_widgets_link_hover_color'));

            ?>
            #footer-widgets {
            <?php
            if ($footer_widgets_color) {
                echo "color: {$footer_widgets_color};";
            }
            if ($footer_widgets_bg_color) {
                echo "background-color: {$footer_widgets_bg_color};";
            }
            ?>
            }
            <?php
            if ($footer_widgets_title_color) {
                echo "#footer-widgets .widget-title{ color: {$footer_widgets_title_color}; }";
            }

            if ($footer_widgets_link_color) {
                echo "#footer-widgets .sidebar .widget a{ color: {$footer_widgets_link_color}; }";
            }

            if ($footer_widgets_link_hover_color) {
                echo "#footer-widgets .sidebar .widget a:hover{ color: {$footer_widgets_link_hover_color}; }";
            }

            $gallery_spacing = absint(get_theme_mod('profipaints_g_spacing', 20));

            ?>
            .gallery-carousel .g-item{
            padding: 0px <?php echo intval($gallery_spacing / 2); ?>px;
            }
            .gallery-carousel {
            margin-left: -<?php echo intval($gallery_spacing / 2); ?>px;
            margin-right: -<?php echo intval($gallery_spacing / 2); ?>px;
            }
            .gallery-grid .g-item, .gallery-masonry .g-item .inner {
            padding: <?php echo intval($gallery_spacing / 2); ?>px;
            }
            .gallery-grid, .gallery-masonry {
            margin: -<?php echo intval($gallery_spacing / 2); ?>px;
            }
            <?php
            $content_width = absint(get_theme_mod('single_layout_content_width'));
            if ($content_width > 0) {
                $value = $content_width . 'px';
                echo '.single-post .site-main, .single-post .entry-content > * { max-width: ' . $value . '; }';
            }

            $css = ob_get_clean();

            if (trim($css) == '') {
                return;
            }

            $css = apply_filters('profipaints_custom_css', $css);

            if (!is_customize_preview()) {

                $css = preg_replace(
                    array(
                        // Remove comment(s)
                        '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                        // Remove unused white-space(s)
                        '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                    ),
                    array(
                        '$1',
                        '$1$2$3$4$5$6$7',
                    ),
                    $css
                );
            }

            if (!function_exists('wp_get_custom_css')) {  // Back-compat for WordPress < 4.7.
                $custom = get_option('profipaints_custom_css');
                if ($custom) {
                    $css .= "\n/* --- Begin custom CSS --- */\n" . $custom . "\n/* --- End custom CSS --- */\n";
                }
            }

            return $css;
        }
    }


    if (function_exists('wp_update_custom_css_post')) {
        // Migrate any existing theme CSS to the core option added in WordPress 4.7.
        $css = get_option('profipaints_custom_css');
        if ($css) {
            $core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
            $return = wp_update_custom_css_post($core_css . "\n" . $css);
            if (!is_wp_error($return)) {
                // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
                delete_option('profipaints_custom_css');
            }
        }
    } else {
        // Back-compat for WordPress < 4.7.
    }

    if (!function_exists('profipaints_get_section_about_data')) {
        /**
         * Get About data
         *
         * @return array
         */
        function profipaints_get_section_about_data()
        {
            $boxes = get_theme_mod('profipaints_about_boxes');
            if (is_string($boxes)) {
                $boxes = json_decode($boxes, true);
            }
            $page_ids = array();
            if (!empty($boxes) && is_array($boxes)) {
                foreach ($boxes as $k => $v) {
                    if (isset($v['content_page'])) {
                        $v['content_page'] = absint($v['content_page']);
                        if ($v['content_page'] > 0) {
                            $page_ids[] = wp_parse_args(
                                $v,
                                array(
                                    'enable_link' => 0,
                                    'hide_title' => 0,
                                )
                            );
                        }
                    }
                }
            }
            $page_ids = array_filter($page_ids);

            return $page_ids;
        }
    }

    if (!function_exists('profipaints_get_section_about2_data')) {
        /**
         * Get About2 data
         *
         * @return array
         */
        function profipaints_get_section_about2_data()
        {
            $boxes = get_theme_mod('profipaints_about2_boxes');
            if (is_string($boxes)) {
                $boxes = json_decode($boxes, true);
            }
            $page_ids = array();
            if (!empty($boxes) && is_array($boxes)) {
                foreach ($boxes as $k => $v) {
                    if (isset($v['content_page'])) {
                        $v['content_page'] = absint($v['content_page']);
                        if ($v['content_page'] > 0) {
                            $page_ids[] = wp_parse_args(
                                $v,
                                array(
                                    'enable_link' => 0,
                                    'hide_title' => 0,
                                )
                            );
                        }
                    }
                }
            }
            $page_ids = array_filter($page_ids);

            return $page_ids;
        }
    }

    if (!function_exists('profipaints_get_section_aboutus_data')) {
        /**
         * Get aboutus data
         *
         * @return array
         */
        function profipaints_get_section_aboutus_data()
        {
            $boxes = get_theme_mod('profipaints_aboutus_boxes');
            if (is_string($boxes)) {
                $boxes = json_decode($boxes, true);
            }
            $page_ids = array();
            if (!empty($boxes) && is_array($boxes)) {
                foreach ($boxes as $k => $v) {
                    if (isset($v['content_page'])) {
                        $v['content_page'] = absint($v['content_page']);
                        if ($v['content_page'] > 0) {
                            $page_ids[] = wp_parse_args(
                                $v,
                                array(
                                    'enable_link' => 0,
                                    'hide_title' => 0,
                                )
                            );
                        }
                    }
                }
            }
            $page_ids = array_filter($page_ids);

            return $page_ids;
        }
    }

    if (!function_exists('profipaints_get_section_counter_data')) {
        /**
         * Get counter data
         *
         * @return array
         */
        function profipaints_get_section_counter_data()
        {
            $boxes = get_theme_mod('profipaints_counter_boxes');
            if (is_string($boxes)) {
                $boxes = json_decode($boxes, true);
            }
            if (empty($boxes) || !is_array($boxes)) {
                $boxes = array();
            }
            return $boxes;
        }
    }

    if (!function_exists('profipaints_get_section_services_data')) {
        /**
         * Get services data
         *
         * @return array
         */
        function profipaints_get_section_services_data()
        {
            $services = get_theme_mod('profipaints_services');
            if (is_string($services)) {
                $services = json_decode($services, true);
            }
            $page_ids = array();
            if (!empty($services) && is_array($services)) {
                foreach ($services as $k => $v) {
                    if (isset($v['content_page'])) {
                        $v['content_page'] = absint($v['content_page']);
                        if ($v['content_page'] > 0) {
                            $page_ids[] = wp_parse_args(
                                $v,
                                array(
                                    'icon_type' => 'icon',
                                    'image' => '',
                                    'icon' => 'gg',
                                    'enable_link' => 0,
                                )
                            );
                        }
                    }
                }
            }
            // if still empty data then get some page for demo
            return $page_ids;
        }
    }

    if (!function_exists('profipaints_get_section_team_data')) {
        /**
         * Get team members
         *
         * @return array
         */
        function profipaints_get_section_team_data()
        {
            $members = get_theme_mod('profipaints_team_members');
            if (is_string($members)) {
                $members = json_decode($members, true);
            }
            if (!is_array($members)) {
                $members = array();
            }
            return $members;
        }
    }

    if (!function_exists('profipaints_get_features_data')) {
        /**
         * Get features data
         *
         * @since 1.1.4
         * @return array
         */
        function profipaints_get_features_data()
        {
            $array = get_theme_mod('profipaints_features_boxes');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'icon' => 'gg',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    $array[$k]['icon'] = trim($array[$k]['icon']);
                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $array[$k]['icon'] = 'fa-' . $array[$k]['icon'];
                    }
                }
            }
            return $array;
        }
    }
    if (!function_exists('profipaints_get_about_data')) {
        /**
         * Get about data
         *
         * @since 1.1.4
         * @return array
         */
        function profipaints_get_about_data()
        {
            $array = get_theme_mod('profipaints_about_boxes');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'icon' => 'gg',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    $array[$k]['icon'] = trim($array[$k]['icon']);
                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $array[$k]['icon'] = 'fa-' . $array[$k]['icon'];
                    }
                }
            }
            return $array;
        }
    }
    if (!function_exists('profipaints_get_modules_data')) {
        /**
         * Get modules data
         *
         * @since 1.1.4
         * @return array
         */
        function profipaints_get_modules_data()
        {
            $array = get_theme_mod('profipaints_modules_boxes');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'icon' => 'gg',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    $array[$k]['icon'] = trim($array[$k]['icon']);
                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $array[$k]['icon'] = 'fa-' . $array[$k]['icon'];
                    }
                }
            }
            return $array;
        }
    }
    if (!function_exists('profipaints_get_about2_data')) {
        /**
         * Get about2 data
         *
         * @since 1.1.4
         * @return array
         */
        function profipaints_get_about2_data()
        {
            $array = get_theme_mod('profipaints_about2_boxes');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'icon' => 'gg',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    $array[$k]['icon'] = trim($array[$k]['icon']);
                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $array[$k]['icon'] = 'fa-' . $array[$k]['icon'];
                    }
                }
            }
            return $array;
        }
    }
    if (!function_exists('profipaints_get_aboutus_data')) {
        /**
         * Get aboutus data
         *
         * @since 1.1.4
         * @return array
         */
        function profipaints_get_aboutus_data()
        {
            $array = get_theme_mod('profipaints_aboutus_boxes');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'icon' => 'gg',
                            'title' => '',
                            'desc' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    $array[$k]['icon'] = trim($array[$k]['icon']);
                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $array[$k]['icon'] = 'fa-' . $array[$k]['icon'];
                    }
                }
            }
            return $array;
        }
    }
    if (!function_exists('profipaints_get_social_profiles')) {
        /**
         * Get social profiles
         *
         * @since 1.1.4
         * @return bool|array
         */
        function profipaints_get_social_profiles()
        {
            $array = get_theme_mod('profipaints_social_profiles');
            if (is_string($array)) {
                $array = json_decode($array, true);
            }
            $html = '';
            if (!empty($array) && is_array($array)) {
                foreach ($array as $k => $v) {
                    $array[$k] = wp_parse_args(
                        $v,
                        array(
                            'network' => '',
                            'icon' => '',
                            'link' => '',
                        )
                    );

                    // Get/Set social icons
                    // If icon isset
                    $icons = array();
                    $array[$k]['icon'] = trim($array[$k]['icon']);

                    if ($array[$k]['icon'] != '' && strpos($array[$k]['icon'], 'fa') !== 0) {
                        $icons[$array[$k]['icon']] = 'fa-' . $array[$k]['icon'];
                    } else {
                        $icons[$array[$k]['icon']] = $array[$k]['icon'];
                    }

                    $network = ($array[$k]['network']) ? sanitize_title($array[$k]['network']) : false;
                    if ($network && !$array[$k]['icon']) {
                        $icons['fa-' . $network] = 'fa-' . $network;
                    }

                    $array[$k]['icon'] = join(' ', $icons);
                }
            }

            foreach ((array) $array as $s) {
                if ($s['icon'] != '') {
                    $html .= '<a target="_blank" href="' . $s['link'] . '" title="' . esc_attr($s['network']) . '"><i class="fa ' . esc_attr($s['icon']) . '"></i></a>';
                }
            }

            return $html;
        }
    }

    if (!function_exists('profipaints_get_gallery_image_ids')) {
        /**
         * Get Gallery image ids from page content
         *
         * @since unknown
         * @since 2.2.1
         *
         * @return array
         */
        function profipaints_get_gallery_image_ids($page_id)
        {
            $images = array();
            $gallery = get_post_gallery($page_id, false);
            if ($gallery) {
                $images = $gallery['ids'];
            } else {
                $post = get_post($page_id);
                $post_content = $post->post_content;
                if ('' != $post_content) {
                    $ids = array();
                    preg_match_all('#data-id=([\'"])(.+?)\1#is', $post_content, $image_ids, PREG_SET_ORDER);
                    if (is_array($image_ids) && !empty($image_ids)) {
                        foreach ($image_ids as $img_id) {
                            if (isset($img_id[2]) && is_numeric($img_id[2]) && wp_attachment_is_image($img_id[2])) {
                                $ids[] = $img_id[2];
                            }
                        }
                    }
                    wp_reset_postdata();
                    if (!empty($ids)) {
                        $images = $ids;
                    }
                }
            }
            return $images;
        }
    }

    if (!function_exists('profipaints_get_gallery_image_ids_by_urls')) {
        /**
         * Get Gallery image ids by urls from page content
         *
         * @since 2.2.1
         * @param int $page_id
         * @return array
         */
        function profipaints_get_gallery_image_ids_by_urls($page_id)
        {
            $images = array();
            $post = get_post($page_id);
            $post_content = $post->post_content;
            if ('' != $post_content) {
                $urls = array();
                preg_match_all('#src=([\'"])(.+?)\1#is', $post_content, $image_urls, PREG_SET_ORDER);
                if (is_array($image_urls) && !empty($image_urls)) {
                    foreach ($image_urls as $img_url) {
                        if (isset($img_url[2])) {
                            $urls[] = $img_url[2];
                        }
                    }
                }
                wp_reset_postdata();
                if (!empty($urls)) {
                    $images = $urls;
                }
            }
            return $images;
        }
    }

    if (!function_exists('profipaints_get_section_gallery_data')) {
        /**
         * Get Gallery data
         *
         * @since 1.2.6
         * @since 2.2.1
         *
         * @return array
         */
        function profipaints_get_section_gallery_data()
        {
            $source = 'page';
            if (has_filter('profipaints_get_section_gallery_data')) {
                $data = apply_filters('profipaints_get_section_gallery_data', false);
                return $data;
            }

            $data = array();
            switch ($source) {
                default:
                    $page_id = get_theme_mod('profipaints_gallery_source_page');
                    $images = '';
                    if ($page_id) {
                        $images = profipaints_get_gallery_image_ids($page_id);
                    }

                    $display_type = get_theme_mod('profipaints_gallery_display', 'grid');
                    if ('masonry' == $display_type || 'justified' == $display_type) {
                        $size = 'large';
                    } else {
                        $size = 'profipaints-small';
                    }

                    $image_thumb_size = apply_filters('profipaints_gallery_page_img_size', $size);

                    if (!empty($images)) {
                        if (!is_array($images)) {
                            $images = explode(',', $images);
                        }
                        foreach ($images as $post_id) {
                            $post = get_post($post_id);
                            if ($post) {
                                $img_thumb = wp_get_attachment_image_src($post_id, $image_thumb_size);
                                if ($img_thumb) {
                                    $img_thumb = $img_thumb[0];
                                }

                                $img_full = wp_get_attachment_image_src($post_id, 'full');
                                if ($img_full) {
                                    $img_full = $img_full[0];
                                }

                                $alt = get_post_meta($post_id, '_wp_attachment_image_alt', true);

                                if ($img_thumb && $img_full) {
                                    $data[$post_id] = array(
                                        'id'        => $post_id,
                                        'thumbnail' => $img_thumb,
                                        'full'      => $img_full,
                                        'title'     => $post->post_title,
                                        'content'   => $post->post_content,
                                        'alt'       => $alt,
                                    );
                                }
                            }
                        }
                    } else {
                        if ($page_id) {
                            $gallery_image_urls = profipaints_get_gallery_image_ids_by_urls($page_id);
                            foreach ($gallery_image_urls as $key => $value) {
                                $data[$key] = array(
                                    'id'        => '',
                                    'thumbnail' => $value,
                                    'full'      => $value,
                                    'title'     => '',
                                    'content'   => '',
                                    'alt'       => '',
                                );
                            }
                        }
                    }
                    break;
            }

            return $data;
        }
    }

    /**
     * Generate HTML content for gallery items.
     *
     * @since 1.2.6
     *
     * @param $data
     * @param bool|true $inner
     * @return string
     */
    function profipaints_gallery_html($data, $inner = true, $size = 'thumbnail')
    {
        $max_item = get_theme_mod('profipaints_g_number', 10);
        $enable_image_link = get_theme_mod('profipaints_g_image_link', 1);
        $html = '';
        if (!is_array($data)) {
            return $html;
        }
        $n = count($data);
        if ($max_item > $n) {
            $max_item = $n;
        }
        $i = 0;
        while ($i < $max_item) {
            $photo = current($data);
            $i++;
            if ($size == 'full') {
                $thumb = $photo['full'];
            } else {
                $thumb = $photo['thumbnail'];
            }

            $title = wp_strip_all_tags($photo['title']);
            $alt = '';
            if (isset($photo['alt'])) {
                $alt = $photo['alt'];
            }
            if (!$alt) {
                $alt = $title;
            }

            $open_tag_html = '<div data-src="' . esc_attr($photo['full']) . '" class="g-item" title="' . esc_attr($title) . '">';
            $close_tag_html = '</div>';
            if ($enable_image_link) {
                $open_tag_html = '<a href="' . esc_attr($photo['full']) . '" class="g-item" title="' . esc_attr($title) . '">';
                $close_tag_html = '</a>';
            }

            $html .= $open_tag_html;
            if ($inner) {
                $html .= '<span class="inner">';
                $html .= '<span class="inner-content">';
                $html .= '<img src="' . esc_url($thumb) . '" alt="' . esc_attr($alt) . '">';
                $html .= '</span>';
                $html .= '</span>';
            } else {
                $html .= '<img src="' . esc_url($thumb) . '" alt="">';
            }

            $html .= $close_tag_html;

            next($data);
        }
        reset($data);

        return $html;
    }


    /**
     * Generate Gallery HTML
     *
     * @since 1.2.6
     * @param bool|true $echo
     * @return string
     */
    function profipaints_gallery_generate($echo = true)
    {

        $div = '';

        $data = profipaints_get_section_gallery_data();

        $display_type = get_theme_mod('profipaints_gallery_display', 'grid');
        $lightbox = get_theme_mod('profipaints_g_lightbox', 1);
        $class = '';
        if ($lightbox) {
            $class = ' enable-lightbox ';
        }
        $col = absint(get_theme_mod('profipaints_g_col', 4));
        if ($col <= 0) {
            $col = 4;
        }
        switch ($display_type) {
            case 'masonry':
                $html = profipaints_gallery_html($data);
                if ($html) {
                    $div .= '<div data-col="' . $col . '" class="g-zoom-in gallery-masonry ' . $class . ' gallery-grid g-col-' . $col . '">';
                    $div .= $html;
                    $div .= '</div>';
                }
                break;
            case 'carousel':
                $html = profipaints_gallery_html($data);
                if ($html) {
                    $div .= '<div data-col="' . $col . '" class="g-zoom-in gallery-carousel owl-theme owl-carousel owl-carousel' . $class . '">';
                    $div .= $html;
                    $div .= '</div>';
                }
                break;
            case 'slider':
                $html = profipaints_gallery_html($data, true, 'full');
                if ($html) {
                    $div .= '<div class="gallery-slider owl-theme owl-carousel owl-carousel' . $class . '">';
                    $div .= $html;
                    $div .= '</div>';
                }
                break;
            case 'justified':
                $html = profipaints_gallery_html($data, false);
                if ($html) {
                    $gallery_spacing = absint(get_theme_mod('profipaints_g_spacing', 20));
                    $row_height = absint(get_theme_mod('profipaints_g_row_height', 120));
                    $div .= '<div data-row-height="' . $row_height . '" data-spacing="' . $gallery_spacing . '" class="g-zoom-in gallery-justified' . $class . '">';
                    $div .= $html;
                    $div .= '</div>';
                }
                break;
            default: // grid
                $html = profipaints_gallery_html($data);
                if ($html) {
                    $div .= '<div class="gallery-grid g-zoom-in ' . $class . ' g-col-' . $col . '">';
                    $div .= $html;
                    $div .= '</div>';
                }
                break;
        }

        if ($echo) {
            echo $div;
        } else {
            return $div;
        }
    }



    if (!function_exists('profipaints_footer_site_info')) {
        /**
         * Add Copyright and Credit text to footer
         *
         * @since 1.1.3
         */
        function profipaints_footer_site_info()
        {
            ?>
            <?php printf(esc_html__('%1$s %2$s %3$s', 'profipaints'), '&copy;', esc_attr(date('Y')), esc_attr(get_bloginfo())); ?>
        <?php
        }
    }
    add_action('profipaints_footer_site_info', 'profipaints_footer_site_info');


    /**
     * Breadcrumb NavXT Compatibility.
     */
    function profipaints_breadcrumb($post_id = null)
    {
        if (!$post_id) {
            if (is_page()) {
                $post_id = get_the_ID();
            }
        }
        if ($post_id) {
            if (get_post_meta($post_id, '_hide_breadcrumb', true)) {
                return;
            }
        }
        if (function_exists('bcn_display')) {
        ?>
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <div class="container">
                    <?php bcn_display(); ?>
                </div>
            </div>
        <?php
        } else if (function_exists('yoast_breadcrumb')) {
        ?>
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <div class="container">
                    <?php yoast_breadcrumb(); ?>
                </div>
            </div>
            <?php
        }
    }

    if (!function_exists('profipaints_is_selective_refresh')) {
        function profipaints_is_selective_refresh()
        {
            return isset($GLOBALS['profipaints_is_selective_refresh']) && $GLOBALS['profipaints_is_selective_refresh'] ? true : false;
        }
    }

    if (!function_exists('profipaints_footer_widgets')) {
        function profipaints_footer_widgets()
        {
            $footer_columns = absint(get_theme_mod('footer_layout', 4));
            $max_cols = 12;
            $layouts = 12;
            if ($footer_columns > 1) {
                $default = '12';
                switch ($footer_columns) {
                    case 4:
                        $default = '3+3+3+3';
                        break;
                    case 3:
                        $default = '4+4+4';
                        break;
                    case 2:
                        $default = '6+6';
                        break;
                }
                $layouts = sanitize_text_field(get_theme_mod('footer_custom_' . $footer_columns . '_columns', $default));
            }

            $layouts = explode('+', $layouts);
            foreach ($layouts as $k => $v) {
                $v = absint(trim($v));
                $v = $v >= $max_cols ? $max_cols : $v;
                $layouts[$k] = $v;
            }

            $have_widgets = false;

            for ($count = 0; $count < $footer_columns; $count++) {
                $id = 'footer-' . ($count + 1);
                if (is_active_sidebar($id)) {
                    $have_widgets = true;
                }
            }

            if ($footer_columns > 0 && $have_widgets) { ?>
                <div id="footer-widgets" class="footer-widgets section-padding ">
                    <div class="container">
                        <div class="row">
                            <?php
                            for ($count = 0; $count < $footer_columns; $count++) {
                                $col = isset($layouts[$count]) ? $layouts[$count] : '';
                                $id = 'footer-' . ($count + 1);
                                if ($col) {
                            ?>
                                    <div id="footer-<?php echo esc_attr($count + 1); ?>" class="col-md-<?php echo esc_attr($col); ?> col-sm-12 footer-column widget-area sidebar" role="complementary">
                                        <?php dynamic_sidebar($id); ?>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php
        }
    }

    add_action('profipaints_before_site_info', 'profipaints_footer_widgets', 15);

    if (!function_exists('profipaints_display_page_title')) {
        /**
         * Display page header
         *
         * @since 2.0.0
         */
        function profipaints_display_page_title()
        {
            if (get_theme_mod('profipaints_page_title_bar_disable') == 1) {
                return;
            }

            $return = false;

            if (is_home()) {
                $page_id = get_option('page_for_posts');
            } else {
                $page_id = get_the_ID();
            }
            $el = 'h1';
            if (is_singular('post')) {
                if (!apply_filters('profipaints_single_show_page_header', false)) {
                    return;
                }
                $page_id = get_option('page_for_posts');
                $el = 'h2';
            }

            $apply_shop = false;
            $is_single_product = false;

            if (profipaints_is_wc_active()) {
                if (is_shop() || is_product_category() || is_product_tag() || is_product() || is_singular('product') || is_product_taxonomy()) {

                    $page_id = wc_get_page_id('shop');
                    if (is_product()) {
                        $el = 'h2';
                        $is_single_product = true;
                        $apply_shop = get_post_meta($page_id, '_wc_apply_product', true);
                    }
                    $return = false;

                    remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
                    remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
                    add_action('woocommerce_show_page_title', '__return_false', 95);
                }
            }

            if ($return) {
                return;
            }

            $classes = array('page-header');
            $img = '';
            $hide_page_title = get_post_meta($page_id, '_hide_page_title', true);

            if (!$is_single_product || ($apply_shop && $is_single_product)) {
                if (get_post_meta($page_id, '_cover', true)) {
                    if (has_post_thumbnail($page_id)) {
                        $classes[] = 'page--cover';
                        $img = get_the_post_thumbnail_url($page_id, 'full');
                    }
                    if (profipaints_is_transparent_header()) {
                        $classes[] = 'is-t-above';
                    }
                }
            }

            $excerpt = '';
            if (profipaints_is_wc_archive()) {
                $title = get_the_archive_title();
                $excerpt = category_description();

                $term = get_queried_object();
                $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                $t_image = wp_get_attachment_url($thumbnail_id);
                if ($t_image) {
                    $img = $t_image;
                }
            } else {
                $title = get_the_title($page_id);
                if (get_post_meta($page_id, '_show_excerpt', true)) {
                    $post = get_post($page_id);
                    if ($post->post_excerpt) {
                        $excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $page_id));
                    }
                }
            }
            if (!$apply_shop && $is_single_product) {
                $excerpt = '';
            }

        ?>
            <?php if (!$hide_page_title) { ?>
                <div class="<?php echo esc_attr(join(' ', $classes)); ?>" <?php echo ($img) ? ' style="background-image: url(\'' . esc_url($img) . '\')" ' : ''; ?>>
                    <div class="container">
                        <?php
                        // WPCS: XSS OK.
                        echo '<' . $el . ' class="entry-title">' . $title . '</' . $el . '>';
                        if ($excerpt) {
                            echo '<div class="entry-tagline">' . $excerpt . '</div>';
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        <?php
        }
    }

    add_action('profipaints_page_before_content', 'profipaints_display_page_title');

    if (!function_exists('profipaints_load_section')) {
        /**
         * Load section
         *
         * @since 2.0.0
         * @param $section_id
         */
        function profipaints_load_section($section_id)
        {
            /**
             * Hook before section
             */
            do_action('profipaints_before_section_' . $section_id);
            if ($section_id != 'hero') {
                do_action('profipaints_before_section_part', $section_id);
            }

            get_template_part('section-parts/section', $section_id);

            /**
             * Hook after section
             */
            if ($section_id != 'hero') {
                do_action('profipaints_after_section_part', $section_id);
            }
            do_action('profipaints_after_section_' . $section_id);
        }
    }

    if (!function_exists('profipaints_load_hero')) {
        function profipaints_load_hero_section()
        {
            if (is_page_template('template-frontpage.php')) {
                profipaints_load_section('hero');
            }
        }
    }

    add_action('profipaints_header_end', 'profipaints_load_hero_section');

    if (!function_exists('profipaints_subscribe_form')) {
        /**
         * Display subscribe form
         *
         * @since 2.0.0
         */
        function profipaints_subscribe_form()
        {
            $profipaints_newsletter_title = wp_kses_post(get_theme_mod('profipaints_newsletter_title', __('Join our Newsletter', 'profipaints')));
            $profipaints_newsletter_mailchimp = wp_kses_post(get_theme_mod('profipaints_newsletter_mailchimp'));
        ?>
            <div class="footer-subscribe">
                <?php if ($profipaints_newsletter_title != '') {
                    echo '<h5 class="follow-heading">' . $profipaints_newsletter_title . '</h5>';
                } ?>
                <form novalidate="" target="_blank" class="" name="mc-embedded-subscribe-form" id="mc-embedded-subscribe-form" method="post" action="<?php if ($profipaints_newsletter_mailchimp != '') {
                                                                                                                                                            echo $profipaints_newsletter_mailchimp;
                                                                                                                                                        }; ?>">
                    <input type="text" placeholder="<?php esc_attr_e('Enter your e-mail address', 'profipaints'); ?>" id="mce-EMAIL" class="subs_input" name="EMAIL" value="">
                    <input type="submit" class="subs-button" value="<?php esc_attr_e('Subscribe', 'profipaints'); ?>" name="subscribe">
                </form>
            </div>
        <?php
        }
    }
    if (!function_exists('profipaints_footer_social_icons')) {
        function profipaints_footer_social_icons()
        {
            $profipaints_social_footer_title = wp_kses_post(get_theme_mod('profipaints_social_footer_title', __('Keep Updated', 'profipaints')));
        ?>
            <div class="footer-social">
                <?php
                if ($profipaints_social_footer_title != '') {
                    echo '<h5 class="follow-heading">' . $profipaints_social_footer_title . '</h5>';
                }

                $socials = profipaints_get_social_profiles();
                /**
                 * New social profiles
                 *
                 * @since 1.1.4
                 * @change 1.2.1
                 */
                echo '<div class="footer-social-icons">';
                if ($socials) {
                    echo $socials;
                } else {
                    /**
                     * Deprecated
                     *
                     * @since 1.1.4
                     */
                    $twitter = get_theme_mod('profipaints_social_twitter');
                    $facebook = get_theme_mod('profipaints_social_facebook');
                    $google = get_theme_mod('profipaints_social_google');
                    $instagram = get_theme_mod('profipaints_social_instagram');
                    $rss = get_theme_mod('profipaints_social_rss');

                    if ($twitter != '') {
                        echo '<a target="_blank" href="' . esc_url($twitter) . '" title="Twitter"><i class="fa fa-twitter"></i></a>';
                    }
                    if ($facebook != '') {
                        echo '<a target="_blank" href="' . esc_url($facebook) . '" title="Facebook"><i class="fa fa-facebook"></i></a>';
                    }
                    if ($google != '') {
                        echo '<a target="_blank" href="' . esc_url($google) . '" title="Google Plus"><i class="fa fa-google-plus"></i></a>';
                    }
                    if ($instagram != '') {
                        echo '<a target="_blank" href="' . esc_url($instagram) . '" title="Instagram"><i class="fa fa-instagram"></i></a>';
                    }
                    if ($rss != '') {
                        echo '<a target="_blank" href="' . esc_url($rss) . '"><i class="fa fa-rss"></i></a>';
                    }
                }
                echo '</div>';
                ?>
            </div>
        <?php
        }
    }

    function profipaints_footer_connect()
    {

        $profipaints_newsletter_disable = sanitize_text_field(get_theme_mod('profipaints_newsletter_disable', '1'));
        $profipaints_social_disable = sanitize_text_field(get_theme_mod('profipaints_social_disable', '1'));

        if ($profipaints_newsletter_disable != '1' || $profipaints_social_disable != '1') : ?>
            <div class="footer-connect">
                <div class="container">
                    <div class="row">
                        <?php
                        if (!$profipaints_newsletter_disable && !$profipaints_social_disable) {
                            if (!$profipaints_newsletter_disable) : ?>
                                <div class="col-md-4 offset-md-2 col-sm-6 offset-md-0">
                                    <?php profipaints_subscribe_form(); ?>
                                </div>
                            <?php endif;

                            if (!$profipaints_social_disable) : ?>
                                <div class="col-md-4 col-sm-6">
                                    <?php profipaints_footer_social_icons(); ?>
                                </div>
                        <?php endif;
                        } else {
                            echo ' <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0">';
                            if (!$profipaints_newsletter_disable) {
                                profipaints_subscribe_form();
                            } else {
                                profipaints_footer_social_icons();
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
    <?php endif;
    }
    add_action('profipaints_before_site_info', 'profipaints_footer_connect', 25);
