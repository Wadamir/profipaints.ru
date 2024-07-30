<?php

/**
 * Section: Team
 */
$wp_customize->add_panel(
    'profipaints_team',
    array(
        'priority'        => 250,
        'title'           => esc_html__('Section: Team', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_team_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_team',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_team_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_team_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_team_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_team_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_team_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_team_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_team_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('team', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_team_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_team_settings',
        'description'   => 'The section ID should be English character, lowercase and no space.'
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_team_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Our Team', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_team_title',
    array(
        'label'            => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_team_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_team_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_team_subtitle',
    array(
        'label'     => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_team_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_team_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_team_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_team_settings',
        'description'   => '',
    )
));

// Team layout
$wp_customize->add_setting(
    'profipaints_team_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '3',
    )
);

$wp_customize->add_control(
    'profipaints_team_layout',
    array(
        'label'         => esc_html__('Team Layout Settings', 'profipaints'),
        'section'         => 'profipaints_team_settings',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '3' => esc_html__('4 Columns', 'profipaints'),
            '4' => esc_html__('3 Columns', 'profipaints'),
            '6' => esc_html__('2 Columns', 'profipaints'),
        ),
    )
);

// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_team_settings' );

$wp_customize->add_section(
    'profipaints_team_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_team',
    )
);

// Team member settings
$wp_customize->add_setting(
    'profipaints_team_members',
    array(
        'sanitize_callback' => 'profipaints_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    )
);


$wp_customize->add_control(
    new Profipaints_Customize_Repeatable_Control(
        $wp_customize,
        'profipaints_team_members',
        array(
            'label'     => esc_html__('Team members', 'profipaints'),
            'description'   => '',
            'section'       => 'profipaints_team_content',
            //'live_title_id' => 'user_id', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'profipaints'), // [live_title]
            'max_item'      => 24, // Maximum item can add
            'limited_msg'     => wp_kses_post(__('Upgrade to <a target="_blank" href="https://www.famethemes.com/plugins/profipaints-plus/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=profipaints_customizer#get-started">ProfiPaints Plus</a> to be able to add more items and unlock other premium features!', 'profipaints')),
            'fields'    => array(
                'user_id' => array(
                    'title' => esc_html__('User media', 'profipaints'),
                    'type'  => 'media',
                    'desc'  => '',
                ),
                'link' => array(
                    'title' => esc_html__('Custom Link', 'profipaints'),
                    'type'  => 'text',
                    'desc'  => '',
                ),
            ),

        )
    )
);
