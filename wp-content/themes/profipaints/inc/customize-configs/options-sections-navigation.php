<?php

/**
 *  Dots Navigation Settings
 * @since 2.1.0
 */
$wp_customize->add_section(
    'profipaints_sections_nav',
    array(
        'priority'    => null,
        'title'       => esc_html__('Sections Navigation', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);

Profipaints_Dots_Navigation::get_instance()->add_customize($wp_customize, 'profipaints_sections_nav');
