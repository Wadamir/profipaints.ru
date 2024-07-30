<?php

/**
 * Load section template
 *
 * @since 1.2.1
 *
 * @param $template_names
 * @return string
 */
function profipaints_customizer_load_template($template_names)
{
    $located = '';

    $is_child = get_stylesheet_directory() != get_template_directory();
    foreach ((array) $template_names as $template_name) {
        if (!$template_name) {
            continue;
        }

        if ($is_child && file_exists(get_stylesheet_directory() . '/' . $template_name)) {  // Child them
            $located = get_stylesheet_directory() . '/' . $template_name;
            break;
        } elseif (defined('ONEPRESS_PLUS_PATH') && file_exists(ONEPRESS_PLUS_PATH . $template_name)) { // Check part in the plugin
            $located = ONEPRESS_PLUS_PATH . $template_name;
            break;
        } elseif (file_exists(get_template_directory() . '/' . $template_name)) { // current_theme
            $located = get_template_directory() . '/' . $template_name;
            break;
        }
    }

    return $located;
}

/**
 * Render customizer section
 *
 * @since 1.2.1
 *
 * @param $section_tpl
 * @param array       $section
 * @return string
 */
function profipaints_get_customizer_section_content($section_tpl, $section = array())
{
    ob_start();
    $GLOBALS['profipaints_is_selective_refresh'] = true;
    $file = profipaints_customizer_load_template($section_tpl);
    if ($file) {
        include $file;
    }
    $content = ob_get_clean();
    return trim($content);
}


/**
 * Add customizer selective refresh
 *
 * @since 1.2.1
 *
 * @param $wp_customize
 */
function profipaints_customizer_partials($wp_customize)
{

    // Abort if selective refresh is not available.
    if (!isset($wp_customize->selective_refresh)) {
        return;
    }

    $selective_refresh_keys = array(
        // section features
        array(
            'id' => 'features',
            'selector' => '.section-features',
            'settings' => array(
                'profipaints_features_boxes',
                'profipaints_features_title',
                'profipaints_features_subtitle',
                'profipaints_features_desc',
                'profipaints_features_layout',
            ),
        ),
        /*
		// section services
		array(
			'id' => 'services',
			'selector' => '.section-services',
			'settings' => array(
				'profipaints_services',
				'profipaints_services_title',
				'profipaints_services_subtitle',
				'profipaints_services_desc',
				'profipaints_service_layout',
				'profipaints_service_icon_size',
				'profipaints_service_content_source',
			),
		),
*/
        // section gallery
        'gallery' => array(
            'id' => 'gallery',
            'selector' => '.section-gallery',
            'settings' => array(
                'profipaints_gallery_source',

                'profipaints_gallery_title',
                'profipaints_gallery_subtitle',
                'profipaints_gallery_desc',
                'profipaints_gallery_source_page',
                'profipaints_gallery_layout',
                'profipaints_gallery_display',
                'profipaints_g_number',
                'profipaints_g_row_height',
                'profipaints_g_col',
                'profipaints_g_readmore_link',
                'profipaints_g_readmore_text',
            ),
        ),

        // section news
        array(
            'id' => 'news',
            'selector' => '.section-news',
            'settings' => array(
                'profipaints_news_title',
                'profipaints_news_subtitle',
                'profipaints_news_desc',
                'profipaints_news_number',
                'profipaints_news_more_link',
                'profipaints_news_more_text',

                'profipaints_news_hide_meta', // @since  2.1.0
                'profipaints_news_excerpt_length', // @since  2.1.0
                'profipaints_news_more_page', // @since  2.1.0

                'profipaints_news_cat',
                'profipaints_news_orderby',
                'profipaints_news_order',
            ),
        ),

        // section form
        array(
            'id' => 'form',
            'selector' => '.section-form',
            'settings' => array(
                'profipaints_form_title',
                'profipaints_form_subtitle',
                'profipaints_form_desc',
                'profipaints_form_cf7',
                'profipaints_form_cf7_disable',
                'profipaints_form_text',
                'profipaints_form_address_title',
                'profipaints_form_address',
                'profipaints_form_phone',
                'profipaints_form_email',
                'profipaints_form_fax',
            ),
        ),

        // section contact
        array(
            'id' => 'contact',
            'selector' => '.section-contact',
            'settings' => array(
                'profipaints_contact_title',
                'profipaints_contact_subtitle',
                'profipaints_contact_desc',
                'profipaints_contact_cf7',
                'profipaints_contact_cf7_disable',
                'profipaints_contact_text',
                'profipaints_contact_address_title',
                'profipaints_contact_address',
                'profipaints_contact_phone',
                'profipaints_contact_email',
                'profipaints_contact_fax',
            ),
        ),

        // section counter
        array(
            'id' => 'counter',
            'selector' => '.section-counter',
            'settings' => array(
                'profipaints_counter_boxes',
                'profipaints_counter_title',
                'profipaints_counter_subtitle',
                'profipaints_counter_desc',
            ),
        ),
        // section videolightbox
        array(
            'id' => 'videolightbox',
            'selector' => '.section-videolightbox',
            'settings' => array(
                'profipaints_videolightbox_title',
                'profipaints_videolightbox_url',
            ),
        ),

        // Section about
        array(
            'id' => 'about',
            'selector' => '.section-about',
            'settings' => array(
                'profipaints_about_boxes',
                'profipaints_about_title',
                'profipaints_about_subtitle',
                'profipaints_about_desc',
                'profipaints_about_content_source',
                'profipaints_about_layout',
            ),
        ),

        // Section options
        array(
            'id' => 'options',
            'selector' => '.section-options',
            'settings' => array(
                'profipaints_options_boxes',
                'profipaints_options_title',
                'profipaints_options_subtitle',
                'profipaints_options_desc',
                'profipaints_options_content_source',
                'profipaints_options_layout',
            ),
        ),

        // Section about2
        array(
            'id' => 'about2',
            'selector' => '.section-about2',
            'settings' => array(
                'profipaints_about2_boxes',
                'profipaints_about2_title',
                'profipaints_about2_subtitle',
                'profipaints_about2_desc',
                'profipaints_about2_content_source',
                'profipaints_about2_layout',
            ),
        ),

        // Section aboutus
        array(
            'id' => 'aboutus',
            'selector' => '.section-aboutus',
            'settings' => array(
                'profipaints_aboutus_boxes',
                'profipaints_aboutus_title',
                'profipaints_aboutus_subtitle',
                'profipaints_aboutus_desc',
                'profipaints_aboutus_content_source',
                'profipaints_aboutus_layout',
            ),
        ),

        // Section team
        array(
            'id' => 'team',
            'selector' => '.section-team',
            'settings' => array(
                'profipaints_team_members',
                'profipaints_team_title',
                'profipaints_team_subtitle',
                'profipaints_team_desc',
                'profipaints_team_layout',
            ),
        ),
    );

    $selective_refresh_keys = apply_filters('profipaints_customizer_partials_selective_refresh_keys', $selective_refresh_keys);

    foreach ($selective_refresh_keys as $section) {
        foreach ($section['settings'] as $key) {
            if ($wp_customize->get_setting($key)) {
                $wp_customize->get_setting($key)->transport = 'postMessage';
            }
        }

        $wp_customize->selective_refresh->add_partial(
            'section-' . $section['id'],
            array(
                'selector' => $section['selector'],
                'settings' => $section['settings'],
                'render_callback' => 'profipaints_selective_refresh_render_section_content',
            )
        );
    }

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('profipaints_hide_sitetitle')->transport = 'postMessage';
    $wp_customize->get_setting('profipaints_hide_tagline')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial(
        'header_brand',
        array(
            'selector' => '.site-header .site-branding',
            'settings' => array('blogname', 'blogdescription', 'profipaints_hide_sitetitle', 'profipaints_hide_tagline'),
            'render_callback' => 'profipaints_site_logo',
        )
    );

    // Footer social heading
    $wp_customize->selective_refresh->add_partial(
        'profipaints_social_footer_title',
        array(
            'selector' => '.footer-social .follow-heading',
            'settings' => array('profipaints_social_footer_title'),
            'render_callback' => 'profipaints_selective_refresh_social_footer_title',
        )
    );
    // Footer social icons
    $wp_customize->selective_refresh->add_partial(
        'profipaints_social_profiles',
        array(
            'selector' => '.footer-social .footer-social-icons',
            'settings' => array('profipaints_social_profiles'),
            'render_callback' => 'profipaints_get_social_profiles',
        )
    );

    // Footer New letter heading
    $wp_customize->selective_refresh->add_partial(
        'profipaints_newsletter_title',
        array(
            'selector' => '.footer-subscribe .follow-heading',
            'settings' => array('profipaints_newsletter_title'),
            'render_callback' => 'profipaints_selective_refresh_newsletter_title',
        )
    );

    /**
     * Footer Widgets
     *
     * @since 2.0.0
     */
    $wp_customize->selective_refresh->add_partial(
        'profipaints-footer-widgets',
        array(
            'selector' => '#footer-widgets',
            'settings' => array('footer_layout', 'footer_custom_1_columns', 'footer_custom_2_columns', 'footer_custom_3_columns', 'footer_custom_4_columns'),
            'render_callback' => 'profipaints_footer_widgets',
            'container_inclusive' => true,
        )
    );

    /**
     * Header Position
     *
     * @since 2.0.0
     */
    $wp_customize->selective_refresh->add_partial(
        'profipaints-header-section',
        array(
            'selector' => '#header-section',
            'settings' => array('profipaints_header_position', 'profipaints_sticky_header_disable', 'profipaints_header_transparent', 'profipaints_header_width'),
            'render_callback' => 'profipaints_header',
            'container_inclusive' => true,
        )
    );

    /**
     * Footer Connect
     *
     * @since 2.0.0
     */
    $wp_customize->selective_refresh->add_partial(
        'profipaints-footer-connect',
        array(
            'selector' => '.footer-connect',
            'settings' => array('profipaints_newsletter_disable', 'profipaints_social_disable'),
            'render_callback' => 'profipaints_footer_connect',
            'container_inclusive' => true,
        )
    );

    /**
     * Selective Refresh style
     *
     * @since 2.0.0
     */
    $css_settings = array(
        'profipaints_logo_height',
        'profipaints_transparent_logo_height',
        'profipaints_tagline_text_color',
        'profipaints_logo_text_color',

        'profipaints_transparent_site_title_c',
        'profipaints_transparent_tag_title_c',
        'profipaints_logo_height',

        'profipaints_hero_overlay_color',
        // 'profipaints_hero_overlay_opacity',
        'profipaints_primary_color',
        'profipaints_secondary_color',
        'profipaints_menu_item_padding',

        'profipaints_page_cover_align',
        'profipaints_page_normal_align',
        'profipaints_page_cover_color',
        'profipaints_page_cover_overlay',
        'profipaints_page_cover_pd_top',
        'profipaints_page_cover_pd_bottom',

        'profipaints_header_bg_color',
        'profipaints_menu_color',
        'profipaints_menu_hover_color',
        'profipaints_menu_hover_bg_color',
        'profipaints_menu_hover_bg_color',
        'profipaints_menu_toggle_button_color',

        'profipaints_footer_info_bg',
        'profipaints_footer_bg',
        'profipaints_footer_top_color',

        'profipaints_footer_c_color',
        'profipaints_footer_c_link_color',
        'profipaints_footer_c_link_hover_color',

        'footer_widgets_color',
        'footer_widgets_bg_color',
        'footer_widgets_title_color',
        'footer_widgets_link_color',
        'footer_widgets_link_hover_color',

        'profipaints_hcl1_r_color',
        'profipaints_hcl1_r_bg_color',

        'profipaints_sections_nav___color',
        'profipaints_sections_nav___color2',
        'profipaints_sections_nav___label_bg',
        'profipaints_sections_nav___label_color',

    );

    /**
     * @since 2.1.1
     */
    $css_settings = apply_filters('profipaints_selective_refresh_css_settings', $css_settings);

    foreach ($css_settings as $index => $key) {
        if ($wp_customize->get_setting($key)) {
            $wp_customize->get_setting($key)->transport = 'postMessage';
        } else {
            unset($css_settings[$index]);
        }
    }

    $wp_customize->selective_refresh->add_partial(
        'profipaints-style-live-css',
        array(
            'selector' => '#profipaints-style-inline-css',
            'settings' => $css_settings,
            'container_inclusive' => false,
            'render_callback' => 'profipaints_custom_inline_style',
        )
    );

    // Retina logo
    $wp_customize->selective_refresh->add_partial(
        'profipaints_site_logo',
        array(
            'selector' => '.site-branding',
            'settings' => array('profipaints_retina_logo', 'profipaints_transparent_logo', 'profipaints_transparent_retina_logo'),
            'render_callback' => 'profipaints_site_logo',
        )
    );
}
add_action('customize_register', 'profipaints_customizer_partials', 199);



/**
 * Selective render content
 *
 * @param $partial
 * @param array   $container_context
 */
function profipaints_selective_refresh_render_section_content($partial, $container_context = array())
{
    $tpl = 'section-parts/' . $partial->id . '.php';
    $GLOBALS['profipaints_is_selective_refresh'] = true;
    $file = profipaints_customizer_load_template($tpl);
    if ($file) {
        include $file;
    }
}

function profipaints_selective_refresh_social_footer_title()
{
    return get_theme_mod('profipaints_social_footer_title');
}

function profipaints_selective_refresh_newsletter_title()
{
    return get_theme_mod('profipaints_newsletter_title');
}
