<?php

/**
 * Section: Modules
 */
$wp_customize->add_panel(
    'profipaints_modules',
    array(
        'priority'        => 190,
        'title'           => esc_html__('Раздел: Доставка и оплата', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_modules_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_modules',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_modules_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_modules_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_modules_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_modules_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_modules_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_modules_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_modules_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('modules', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_modules_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_modules_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_modules_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('modules', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_modules_title',
    array(
        'label'         => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_modules_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_modules_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_modules_subtitle',
    array(
        'label'         => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_modules_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_modules_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_modules_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_modules_settings',
        'description'   => '',
    )
));

// modules layout
$wp_customize->add_setting(
    'profipaints_modules_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '3',
    )
);

$wp_customize->add_control(
    'profipaints_modules_layout',
    array(
        'label'         => esc_html__('Options 2 Layout Setting', 'profipaints'),
        'section'         => 'profipaints_modules_settings',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '3' => esc_html__('4 Columns', 'profipaints'),
            '4' => esc_html__('3 Columns', 'profipaints'),
            '6' => esc_html__('2 Columns', 'profipaints'),
        ),
    )
);


// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_modules_settings' );


$wp_customize->add_section(
    'profipaints_modules_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_modules',
    )
);

// modules content
$wp_customize->add_setting(
    'profipaints_modules_boxes',
    array(
        //'default' => '',
        'sanitize_callback' => 'profipaints_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    )
);

$wp_customize->add_control(
    new Profipaints_Customize_Repeatable_Control(
        $wp_customize,
        'profipaints_modules_boxes',
        array(
            'label'         => esc_html__('Content', 'profipaints'),
            'description'   => '',
            'section'       => 'profipaints_modules_content',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'profipaints'), // [live_title]
            'max_item'      => 124, // Maximum item can add
            'limited_msg'     => wp_kses_post(__('Upgrade to <a target="_blank" href="https://www.famethemes.com/plugins/profipaints-plus/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=profipaints_customizer#get-started">ProfiPaints Plus</a> to be able to add more items and unlock other premium modules!', 'profipaints')),
            'fields'    => array(
                'title'  => array(
                    'title' => esc_html__('Title', 'profipaints'),
                    'type'  => 'text',
                ),
                'subtitle'  => array(
                    'title' => esc_html__('Subtitle', 'profipaints'),
                    'type'  => 'text',
                ),
                'image'  => array(
                    'title' => esc_html__('Фото', 'profipaints'),
                    'type'  => 'media',
                ),
                'desc'  => array(
                    'title' => esc_html__('Description', 'profipaints'),
                    'type'  => 'editor',
                ),
            ),

        )
    )
);

/*
// Options content source
$wp_customize->add_setting( 'profipaints_modules_content_source',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'content',
	)
);

$wp_customize->add_control( 'profipaints_modules_content_source',
	array(
		'label' 		=> esc_html__('Item content source', 'profipaints'),
		'section' 		=> 'profipaints_modules_content',
		'description'   => '',
		'type'          => 'select',
		'choices'       => array(
			'content' => esc_html__( 'Full Page Content', 'profipaints' ),
			'excerpt' => esc_html__( 'Page Excerpt', 'profipaints' ),
		),
	)
);
*/