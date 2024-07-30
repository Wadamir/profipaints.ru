<?php

/**
 * Site Options
 *
 * @package profipaints
 */

$wp_customize->add_panel(
    'profipaints_options',
    array(
        'priority'       => 5,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__('Theme Options', 'profipaints'),
        'description'    => '',
    )
);


if (!function_exists('wp_get_custom_css')) {  // Back-compat for WordPress < 4.7.

    // Custom CSS Settings.
    $wp_customize->add_section(
        'profipaints_custom_code',
        array(
            'title' => __('Custom CSS', 'profipaints'),
            'panel' => 'profipaints_options',
        )
    );


    $wp_customize->add_setting(
        'profipaints_custom_css',
        array(
            'default'           => '',
            'sanitize_callback' => 'profipaints_sanitize_css',
            'type'              => 'option',
        )
    );

    $wp_customize->add_control(
        'profipaints_custom_css',
        array(
            'label'   => __('Custom CSS', 'profipaints'),
            'section' => 'profipaints_custom_code',
            'type'    => 'textarea',
        )
    );
} else {
    $wp_customize->get_section('custom_css')->priority = 994;
}
