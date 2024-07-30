<?php
/* Global Settings
----------------------------------------------------------------------*/
$wp_customize->add_section(
    'profipaints_global_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Global', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

// Sidebar settings
$wp_customize->add_setting(
    'profipaints_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'right-sidebar',
        //'transport'			=> 'postMessage'
    )
);

$wp_customize->add_control(
    'profipaints_layout',
    array(
        'type'        => 'select',
        'label'       => esc_html__('Site Layout', 'profipaints'),
        'description' => esc_html__('Site Layout, apply for all pages, exclude home page and custom page templates.', 'profipaints'),
        'section'     => 'profipaints_global_settings',
        'choices'     => array(
            'right-sidebar' => esc_html__('Right sidebar', 'profipaints'),
            'left-sidebar'  => esc_html__('Left sidebar', 'profipaints'),
            'no-sidebar'    => esc_html__('No sidebar', 'profipaints'),
        )
    )
);


// Disable Animation
$wp_customize->add_setting(
    'profipaints_animation_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_animation_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Disable animation effect?', 'profipaints'),
        'section'     => 'profipaints_global_settings',
        'description' => esc_html__('Check this box to disable all element animation when scroll.', 'profipaints')
    )
);

// Disable Animation
$wp_customize->add_setting(
    'profipaints_btt_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    'profipaints_btt_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide footer back to top?', 'profipaints'),
        'section'     => 'profipaints_global_settings',
        'description' => esc_html__('Check this box to hide footer back to top button.', 'profipaints')
    )
);

// Disable Google Font
$wp_customize->add_setting(
    'profipaints_disable_g_font',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    'profipaints_disable_g_font',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Disable Google Fonts', 'profipaints'),
        'section'     => 'profipaints_global_settings',
        'description' => esc_html__('Check this if you want to disable default google fonts in theme.', 'profipaints')
    )
);
