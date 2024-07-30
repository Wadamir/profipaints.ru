<?php

/**
 * Section: Contact
 */
$wp_customize->add_panel(
    'profipaints_form',
    array(
        'priority'        => 270,
        'title'           => esc_html__('Раздел: Форма', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_form_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_form',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_form_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_form_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_form_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_form_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_form_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_form_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_form_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('form', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_form_id',
    array(
        'label'     => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_form_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_form_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Get in touch', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_form_title',
    array(
        'label'     => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_form_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_form_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_form_subtitle',
    array(
        'label'     => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_form_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_form_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_form_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_form_settings',
        'description'   => '',
    )
));


// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_form_settings' );


$wp_customize->add_section(
    'profipaints_form_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_form',
    )
);

// Address Box
$wp_customize->add_setting(
    'profipaints_contact_form_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_contact_form_title',
    array(
        'label'         => esc_html__('Contact Box Title', 'profipaints'),
        'section'         => 'profipaints_form_content',
        'description'   => '',
    )
);

// Contact Text
$wp_customize->add_setting(
    'profipaints_contact_form_text',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_contact_form_text',
    array(
        'label'         => esc_html__('Contact Text', 'profipaints'),
        'section'         => 'profipaints_form_content',
        'description'   => '',
    )
));

// hr
$wp_customize->add_setting('profipaints_form_text_hr', array('sanitize_callback' => 'profipaints_sanitize_text'));
$wp_customize->add_control(new ProfiPaints_Misc_Control(
    $wp_customize,
    'profipaints_form_text_hr',
    array(
        'section'     => 'profipaints_form_content',
        'type'        => 'hr'
    )
));
// Contact form 7 guide.
$wp_customize->add_setting(
    'profipaints_form_cf7_guide',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text'
    )
);
$wp_customize->add_control(new ProfiPaints_Misc_Control(
    $wp_customize,
    'profipaints_form_cf7_guide',
    array(
        'section'     => 'profipaints_form_content',
        'type'        => 'custom_message',
        'description' => wp_kses_post('Paste your form shortcode from contact form plugin here, e.g <code>[wpforms  id="123"]</code>', 'profipaints')
    )
));
/// Contact Form 7 Shortcode
$wp_customize->add_setting(
    'profipaints_form_cf7',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_form_cf7',
    array(
        'label'         => esc_html__('Contact Form Shortcode.', 'profipaints'),
        'section'         => 'profipaints_form_content',
        'description'   => '',
    )
);

// Show CF7
$wp_customize->add_setting(
    'profipaints_form_cf7_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_form_cf7_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide contact form completely.', 'profipaints'),
        'section'     => 'profipaints_form_content',
        'description' => esc_html__('Check this box to hide contact form.', 'profipaints'),
    )
);
