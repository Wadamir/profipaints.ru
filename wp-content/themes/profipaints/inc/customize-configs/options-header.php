<?php

/**
 * Header Settings.
 *
 * @package profipaints
 */

// Phones
$wp_customize->add_setting(
    'profipaints_main_phone',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_main_phone',
    array(
        'label'       => esc_html__('Main phone number', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => 'Номер телефона без пробелов и тире',
    )
);
$wp_customize->add_setting(
    'profipaints_whatsapp_phone',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_whatsapp_phone',
    array(
        'label'       => esc_html__('Whatsapp phone number', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => 'Номер телефона без пробелов и тире',
    )
);
$wp_customize->add_setting(
    'profipaints_telegram_phone',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_telegram_phone',
    array(
        'label'       => esc_html__('Telegram phone number', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => 'Номер телефона без пробелов и тире',
    )
);

$wp_customize->add_section(
    'profipaints_header_settings',
    array(
        'priority'    => 5,
        'title'       => esc_html__('Header', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

// Header width.
$wp_customize->add_setting(
    'profipaints_header_width',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'contained',
        'transport'         => 'postMessage',
    )
);

$wp_customize->add_control(
    'profipaints_header_width',
    array(
        'type'    => 'select',
        'label'   => esc_html__('Header Width', 'profipaints'),
        'section' => 'profipaints_header_settings',
        'choices' => array(
            'full-width' => esc_html__('Full Width', 'profipaints'),
            'contained'  => esc_html__('Contained', 'profipaints'),
        ),
    )
);

// Header Layout
$wp_customize->add_setting(
    'profipaints_header_position',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'top',
        'transport'         => 'postMessage',
        'active_callback'   => 'profipaints_showon_frontpage',
    )
);

$wp_customize->add_control(
    'profipaints_header_position',
    array(
        'type'    => 'select',
        'label'   => esc_html__('Header Position', 'profipaints'),
        'section' => 'profipaints_header_settings',
        'choices' => array(
            'top'        => esc_html__('Top', 'profipaints'),
            'below_hero' => esc_html__('Below Hero Slider', 'profipaints'),
        ),
    )
);

// Disable Sticky Header
$wp_customize->add_setting(
    'profipaints_sticky_header_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_sticky_header_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Disable Sticky Header?', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => esc_html__('Check this box to disable sticky header when scroll.', 'profipaints'),
    )
);


// Vertical align menu
$wp_customize->add_setting(
    'profipaints_vertical_align_menu',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_vertical_align_menu',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Center vertical align for menu', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => esc_html__('If you use logo and your logo is too tall, check this box to auto vertical align menu.', 'profipaints'),
    )
);

// Scroll to top when click to logo
$wp_customize->add_setting(
    'profipaints_header_scroll_logo',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => 0,
        'active_callback'   => '',
    )
);
$wp_customize->add_control(
    'profipaints_header_scroll_logo',
    array(
        'type'    => 'checkbox',
        'label'   => esc_html__('Scroll to top when click to the site logo or site title, only apply on front page.', 'profipaints'),
        'section' => 'profipaints_header_settings',
    )
);

// Header BG Color
$wp_customize->add_setting(
    'profipaints_header_bg_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_header_bg_color',
        array(
            'label'       => esc_html__('Background Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);


// Site Title Color
$wp_customize->add_setting(
    'profipaints_logo_text_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_logo_text_color',
        array(
            'label'       => esc_html__('Site Title Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => esc_html__('Only set if you don\'t use an image logo.', 'profipaints'),
        )
    )
);

$wp_customize->add_setting(
    'profipaints_tagline_text_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_tagline_text_color',
        array(
            'label'       => esc_html__('Site Tagline Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => esc_html__('Only set if display site tagline.', 'profipaints'),
        )
    )
);

// Header Menu Color
$wp_customize->add_setting(
    'profipaints_menu_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_menu_color',
        array(
            'label'       => esc_html__('Menu Link Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);

// Header Menu Hover Color
$wp_customize->add_setting(
    'profipaints_menu_hover_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_menu_hover_color',
        array(
            'label'       => esc_html__('Menu Link Hover/Active Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',

        )
    )
);

// Header Menu Hover BG Color
$wp_customize->add_setting(
    'profipaints_menu_hover_bg_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_menu_hover_bg_color',
        array(
            'label'       => esc_html__('Menu Link Hover/Active BG Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);

// Responsive Mobile button color
$wp_customize->add_setting(
    'profipaints_menu_toggle_button_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_menu_toggle_button_color',
        array(
            'label'       => esc_html__('Responsive Menu Button Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);


// Header Transparent
$wp_customize->add_setting(
    'profipaints_header_transparent',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
        'active_callback'   => 'profipaints_showon_frontpage',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_header_transparent',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Header Transparent', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => esc_html__('Apply for front page template only.', 'profipaints'),
    )
);

// Transparent Logo
$wp_customize->add_setting(
    'profipaints_transparent_logo',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'profipaints_transparent_logo',
        array(
            'label'       => esc_html__('Transparent Logo', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => esc_html__('Only apply when transparent header option is checked.', 'profipaints'),
        )
    )
);

// Transparent Retina Logo
$wp_customize->add_setting(
    'profipaints_transparent_retina_logo',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'profipaints_transparent_retina_logo',
        array(
            'label'       => esc_html__('Transparent Retina Logo', 'profipaints'),
            'description' => esc_html__('Only apply when transparent header option is checked.', 'profipaints'),
            'section'     => 'profipaints_header_settings',
        )
    )
);

/**
 * @since 2.0.8
 */
$wp_customize->add_setting(
    'profipaints_transparent_logo_height',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_transparent_logo_height',
    array(
        'label'       => esc_html__('Transparent Logo Height in Pixel', 'profipaints'),
        'section'     => 'profipaints_header_settings',
        'description' => '',
    )
);

$wp_customize->add_setting(
    'profipaints_transparent_site_title_c',
    array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default'           => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_transparent_site_title_c',
        array(
            'label'       => esc_html__('Transparent Site Title Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);

$wp_customize->add_setting(
    'profipaints_transparent_tag_title_c',
    array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default'           => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_transparent_tag_title_c',
        array(
            'label'       => esc_html__('Transparent Site Tagline Color', 'profipaints'),
            'section'     => 'profipaints_header_settings',
            'description' => '',
        )
    )
);
