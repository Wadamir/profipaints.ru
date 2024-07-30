<?php

/**
 * Blog Post Settings
 * 
 * @package profipaints
 *
 * @since 2.1.0
 * @since 2.2.1
 */

$wp_customize->add_section(
    'profipaints_blog_posts',
    array(
        'priority'    => null,
        'title'       => esc_html__('Blog Posts', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

$wp_customize->add_setting(
    'profipaints_disable_archive_prefix',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_disable_archive_prefix',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Disable archive prefix', 'profipaints'),
        'section'     => 'profipaints_blog_posts',
        'description' => esc_html__('Check this to disable archive prefix on category, date, tag page.', 'profipaints'),
    )
);

$wp_customize->add_setting(
    'profipaints_hide_thumnail_if_not_exists',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_hide_thumnail_if_not_exists',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide thumbnail placeholder', 'profipaints'),
        'section'     => 'profipaints_blog_posts',
        'description' => esc_html__('Hide placeholder if the post thumbnail not exists.', 'profipaints'),
    )
);
