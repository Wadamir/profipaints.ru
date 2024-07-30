<?php
/*------------------------------------------------------------------------*/
/*  Section: Video Popup
/*------------------------------------------------------------------------*/
$wp_customize->add_panel(
    'profipaints_videolightbox',
    array(
        'priority'        => 300,
        'title'           => esc_html__('Section: Video Lightbox', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_videolightbox_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_videolightbox',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_videolightbox_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_videolightbox_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_videolightbox_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_videolightbox_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_videolightbox_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_videolightbox_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_videolightbox_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => 'videolightbox',
    )
);
$wp_customize->add_control(
    'profipaints_videolightbox_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_videolightbox_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_videolightbox_title',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);

$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_videolightbox_title',
    array(
        'label'         =>  esc_html__('Section heading', 'profipaints'),
        'section'         => 'profipaints_videolightbox_settings',
        'description'   => '',
    )
));

// Video URL
$wp_customize->add_setting(
    'profipaints_videolightbox_url',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_videolightbox_url',
    array(
        'label'         => esc_html__('Video url', 'profipaints'),
        'section'         => 'profipaints_videolightbox_settings',
        'description'   =>  esc_html__('Paste Youtube or Vimeo url here', 'profipaints'),
    )
);

// Parallax image
$wp_customize->add_setting(
    'profipaints_videolightbox_image',
    array(
        'sanitize_callback' => 'profipaints_sanitize_number',
        'default'           => '',
    )
);
$wp_customize->add_control(new WP_Customize_Media_Control(
    $wp_customize,
    'profipaints_videolightbox_image',
    array(
        'label'         => esc_html__('Background image', 'profipaints'),
        'section'         => 'profipaints_videolightbox_settings',
    )
));

// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_videolightbox_settings' );