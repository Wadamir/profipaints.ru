<?php
/*
 Colors
----------------------------------------------------------------------*/
$wp_customize->add_section(
    'profipaints_colors_settings',
    array(
        'priority'    => 4,
        'title'       => esc_html__('Site Colors', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

// Primary Text Color
$wp_customize->add_setting(
    'profipaints_primary_text_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#1B1D21',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_primary_text_color',
        array(
            'label'       => esc_html__('Primary Text Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 1,
        )
    )
);

// Secondary Text Color
$wp_customize->add_setting(
    'profipaints_secondary_text_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#4F5151',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_secondary_text_color',
        array(
            'label'       => esc_html__('Secondary Text Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 2,
        )
    )
);

$wp_customize->add_setting(
    'profipaints_accent_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#EF6333',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_accent_color',
        array(
            'label'       => esc_html__('Primary Accent Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 3,
        )
    )
);

$wp_customize->add_setting(
    'profipaints_secondary_accent_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#C0141E',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_secondary_accent_color',
        array(
            'label'       => esc_html__('Secondary Accent Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 4,
        )
    )
);

/**
 * Background Color
 *
 * @since 2.2.1
 */
$wp_customize->add_setting(
    'profipaints_background_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#FCFCFC',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_background_color',
        array(
            'label'       => esc_html__('Background Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 5,
        )
    )
);

/**
 * Background Color
 *
 * @since 2.2.1
 */
$wp_customize->add_setting(
    'profipaints_background_meta_color',
    array(
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default'              => '#E6E6E6',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_background_meta_color',
        array(
            'label'       => esc_html__('Background Dark Color', 'profipaints'),
            'section'     => 'profipaints_colors_settings',
            'description' => '',
            'priority'    => 6,
        )
    )
);
