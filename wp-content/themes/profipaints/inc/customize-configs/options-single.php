<?php

/* Single Settings
----------------------------------------------------------------------*/
$wp_customize->add_section(
    'profipaints_single',
    array(
        'priority'    => null,
        'title'       => esc_html__('Single Post', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);


$wp_customize->add_setting(
    'single_layout',
    array(
        'sanitize_callback' => 'profipaints_sanitize_select',
        'default'           => 'default',
    )
);
$wp_customize->add_control(
    'single_layout',
    array(
        'type'        => 'select',
        'label'       => esc_html__('Single Layout Sidebar', 'profipaints'),
        'section'     => 'profipaints_single',
        'choices' => array(
            'default' => esc_html__('Default', 'profipaints'),
            'no-sidebar' => esc_html__('No Sidebar', 'profipaints'),
            'left-sidebar' => esc_html__('Left Sidebar', 'profipaints'),
            'right-sidebar' => esc_html__('Right Sidebar', 'profipaints'),
        )
    )
);


$wp_customize->add_setting(
    'single_layout_content_width',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'single_layout_content_width',
    array(
        'type'        => 'text',
        'label'       => esc_html__('Single Content Max Width', 'profipaints'),
        'description'       => esc_html__('Enter content max width number, e.g : 800', 'profipaints'),
        'section'     => 'profipaints_single',
    )
);



$wp_customize->add_setting(
    'single_thumbnail',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'single_thumbnail',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Show single post thumbnail', 'profipaints'),
        'section'     => 'profipaints_single',
        'description' => esc_html__('Check this box to show post thumbnail on single post.', 'profipaints')
    )
);

$wp_customize->add_setting(
    'single_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '1',
    )
);
$wp_customize->add_control(
    'single_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Show single post meta', 'profipaints'),
        'section'     => 'profipaints_single',
        'description' => esc_html__('Check this box to show single post meta such as post date, author, category,...', 'profipaints')
    )
);
