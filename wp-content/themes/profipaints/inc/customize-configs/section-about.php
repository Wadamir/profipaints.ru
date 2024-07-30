<?php

/**
 * Section: About
 */
$wp_customize->add_panel(
    'profipaints_about',
    array(
        'priority'        => 180,
        'title'           => esc_html__('Раздел: Для корп. клиентов', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_about_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_about',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_about_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_about_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_about_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_about_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_about_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_about_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_about_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('about', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_about_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_about_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_about_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('about', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_about_title',
    array(
        'label'         => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_about_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_about_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_about_subtitle',
    array(
        'label'         => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_about_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_about_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_about_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_about_settings',
        'description'   => '',
    )
));

// Image
$wp_customize->add_setting(
    'profipaints_about_image',
    array(
        'sanitize_callback' => 'esc_url',
        'default'           => '',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'profipaints_about_image',
        array(
            'label'       => esc_html__('Section Image', 'profipaints'),
            'section'     => 'profipaints_about_settings',
            'description' => '',
        )
    )
);

// Form cf7
$wp_customize->add_setting(
    'profipaints_about_form',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_about_form',
    array(
        'label'         => esc_html__('Форма', 'profipaints'),
        'section'         => 'profipaints_about_settings',
        'description'   => '',
    )
);
