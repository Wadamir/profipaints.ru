<?php

/**
 * Page Settings
 *
 * @package profipaints
 */

$wp_customize->add_section(
    'profipaints_page',
    array(
        'priority'    => null,
        'title'       => esc_html__('Page Title Area', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

// Disable the page title bar.
$wp_customize->add_setting(
    'profipaints_page_title_bar_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_page_title_bar_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Disable Page Title bar?', 'profipaints'),
        'section'     => 'profipaints_page',
        'description' => esc_html__('Check this box to disable the page title bar on all pages.', 'profipaints'),
    )
);

$wp_customize->add_setting(
    'profipaints_page_cover_pd_top',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_page_cover_pd_top',
    array(
        'label'       => esc_html__('Padding Top', 'profipaints'),
        'description' => esc_html__('The page cover padding top in percent (%).', 'profipaints'),
        'section'     => 'profipaints_page',
    )
);

$wp_customize->add_setting(
    'profipaints_page_cover_pd_bottom',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_page_cover_pd_bottom',
    array(
        'label'       => esc_html__('Padding Bottom', 'profipaints'),
        'description' => esc_html__('The page cover padding bottom in percent (%).', 'profipaints'),
        'section'     => 'profipaints_page',
    )
);

$wp_customize->add_setting(
    'profipaints_page_cover_color',
    array(
        'sanitize_callback' => 'profipaints_sanitize_color_alpha',
        'default'           => null,
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'profipaints_page_cover_color',
        array(
            'label'   => esc_html__('Color', 'profipaints'),
            'section' => 'profipaints_page',
        )
    )
);

// Overlay color.
$wp_customize->add_setting(
    'profipaints_page_cover_overlay',
    array(
        'sanitize_callback' => 'profipaints_sanitize_color_alpha',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    new ProfiPaints_Alpha_Color_Control(
        $wp_customize,
        'profipaints_page_cover_overlay',
        array(
            'label'   => esc_html__('Background Overlay Color', 'profipaints'),
            'section' => 'profipaints_page',
        )
    )
);

/**
 * Normal page title align.
 *
 * @since 2.2.1
 */
$wp_customize->add_setting(
    'profipaints_page_normal_align',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'left',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_page_normal_align',
    array(
        'label'   => esc_html__('Page Title Alignment', 'profipaints'),
        'section' => 'profipaints_page',
        'type'    => 'select',
        'choices' => array(
            'left'   => esc_html__('Left', 'profipaints'),
            'right'  => esc_html__('Right', 'profipaints'),
            'center' => esc_html__('Center', 'profipaints'),
        ),
    )
);


$wp_customize->add_setting(
    'profipaints_page_cover_align',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'center',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    'profipaints_page_cover_align',
    array(
        'label'   => esc_html__('Page Title Cover Alignment', 'profipaints'),
        'description'   => esc_html__('Apply when the page display featured image as header cover.', 'profipaints'),
        'section' => 'profipaints_page',
        'type'    => 'select',
        'choices' => array(
            'center' => esc_html__('Center', 'profipaints'),
            'left'   => esc_html__('Left', 'profipaints'),
            'right'  => esc_html__('Right', 'profipaints'),
        ),
    )
);
