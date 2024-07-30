<?php

/**
 * Section: Services
 */
$wp_customize->add_panel(
    'profipaints_services',
    array(
        'priority'        => 200,
        'title'           => esc_html__('Section: Services', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_service_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_services',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_services_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_services_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_service_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_service_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_services_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('services', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_services_id',
    array(
        'label'       => esc_html__('Section ID:', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => 'The section ID should be English character, lowercase and no space.'
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_services_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Our Services', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_services_title',
    array(
        'label'       => esc_html__('Section Title', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_services_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_services_subtitle',
    array(
        'label'       => esc_html__('Section Subtitle', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_services_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_services_desc',
    array(
        'label'       => esc_html__('Section Description', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => '',
    )
));


// Services layout
$wp_customize->add_setting(
    'profipaints_service_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '6',
    )
);

$wp_customize->add_control(
    'profipaints_service_layout',
    array(
        'label'       => esc_html__('Services Layout Settings', 'profipaints'),
        'section'     => 'profipaints_service_settings',
        'description' => '',
        'type'        => 'select',
        'choices'     => array(
            '3'  => esc_html__('4 Columns', 'profipaints'),
            '4'  => esc_html__('3 Columns', 'profipaints'),
            '6'  => esc_html__('2 Columns', 'profipaints'),
            '12' => esc_html__('1 Column', 'profipaints'),
        ),
    )
);


// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_service_settings' );


$wp_customize->add_section(
    'profipaints_service_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_services',
    )
);

// Section service content.
$wp_customize->add_setting(
    'profipaints_services',
    array(
        'sanitize_callback' => 'profipaints_sanitize_repeatable_data_field',
        'transport'         => 'refresh', // refresh or postMessage
    )
);


$wp_customize->add_control(
    new Profipaints_Customize_Repeatable_Control(
        $wp_customize,
        'profipaints_services',
        array(
            'label'         => esc_html__('Service content', 'profipaints'),
            'description'   => '',
            'section'       => 'profipaints_service_content',
            'live_title_id' => 'content_page', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'profipaints'), // [live_title]
            'max_item'      => 24, // Maximum item can add,
            'limited_msg'   => wp_kses_post(__('Upgrade to <a target="_blank" href="https://www.famethemes.com/plugins/profipaints-plus/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=profipaints_customizer#get-started">ProfiPaints Plus</a> to be able to add more items and unlock other premium features!', 'profipaints')),
            'fields'        => array(
                'icon_type' => array(
                    'title'   => esc_html__('Custom icon', 'profipaints'),
                    'type'    => 'select',
                    'options' => array(
                        'icon'  => esc_html__('Icon', 'profipaints'),
                        'image' => esc_html__('image', 'profipaints'),
                    ),
                ),
                'icon'      => array(
                    'title'    => esc_html__('Icon', 'profipaints'),
                    'type'     => 'icon',
                    'required' => array('icon_type', '=', 'icon'),
                ),
                'image'     => array(
                    'title'    => esc_html__('Image', 'profipaints'),
                    'type'     => 'media',
                    'required' => array('icon_type', '=', 'image'),
                ),

                'content_page' => array(
                    'title'   => esc_html__('Select a page', 'profipaints'),
                    'type'    => 'select',
                    'options' => $option_pages
                ),
                'enable_link'  => array(
                    'title' => esc_html__('Link to single page', 'profipaints'),
                    'type'  => 'checkbox',
                ),
            ),

        )
    )
);


// Services icon size
$wp_customize->add_setting(
    'profipaints_service_icon_size',
    array(
        'sanitize_callback' => 'profipaints_sanitize_select',
        'default'           => '5x',
    )
);

$wp_customize->add_control(
    'profipaints_service_icon_size',
    array(
        'label'       => esc_html__('Icon Size', 'profipaints'),
        'section'     => 'profipaints_service_content',
        'description' => '',
        'type'        => 'select',
        'choices'     => array(
            '5x' => esc_html__('5x', 'profipaints'),
            '4x' => esc_html__('4x', 'profipaints'),
            '3x' => esc_html__('3x', 'profipaints'),
            '2x' => esc_html__('2x', 'profipaints'),
            '1x' => esc_html__('1x', 'profipaints'),
        ),
    )
);

// Service content source
$wp_customize->add_setting(
    'profipaints_service_content_source',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'excerpt',
    )
);

$wp_customize->add_control(
    'profipaints_service_content_source',
    array(
        'label'       => esc_html__('Item content source', 'profipaints'),
        'section'     => 'profipaints_service_content',
        'description' => '',
        'type'        => 'select',
        'choices'     => array(
            'content' => esc_html__('Full Page Content', 'profipaints'),
            'excerpt' => esc_html__('Page Excerpt', 'profipaints'),
        ),
    )
);
