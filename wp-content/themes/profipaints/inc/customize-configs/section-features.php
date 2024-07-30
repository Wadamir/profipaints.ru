<?php

/**
 * Section: Features
 */
$wp_customize->add_panel(
    'profipaints_features',
    array(
        'priority'        => 170,
        'title'           => esc_html__('Раздел: Товары', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_features_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_features',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_features_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_features_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_features_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_features_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_features_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_features_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_features_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('features', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_features_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Features', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_title',
    array(
        'label'         => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_features_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_subtitle',
    array(
        'label'         => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_features_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_features_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
));

// Features layout
$wp_customize->add_setting(
    'profipaints_features_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '3',
    )
);

$wp_customize->add_control(
    'profipaints_features_layout',
    array(
        'label'         => esc_html__('Features Layout Setting', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '3' => esc_html__('4 Columns', 'profipaints'),
            '4' => esc_html__('3 Columns', 'profipaints'),
            '6' => esc_html__('2 Columns', 'profipaints'),
        ),
    )
);

// Tab 1 title
$wp_customize->add_setting(
    'profipaints_features_tab1_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Информация о товаре', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_tab1_title',
    array(
        'label'         => esc_html__('Информация о товаре', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
);

// Tab 2 title
$wp_customize->add_setting(
    'profipaints_features_tab2_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Сертификаты', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_tab2_title',
    array(
        'label'         => esc_html__('Сертификаты', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
);

// Tab 3 title
$wp_customize->add_setting(
    'profipaints_features_tab3_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Техничка', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_features_tab3_title',
    array(
        'label'         => esc_html__('Техничка', 'profipaints'),
        'section'         => 'profipaints_features_settings',
        'description'   => '',
    )
);

// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_features_settings' );


$wp_customize->add_section(
    'profipaints_features_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_features',
    )
);

// Features content
$wp_customize->add_setting(
    'profipaints_features_boxes',
    array(
        //'default' => '',
        'sanitize_callback' => 'profipaints_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    )
);

$wp_customize->add_control(
    new Profipaints_Customize_Repeatable_Control(
        $wp_customize,
        'profipaints_features_boxes',
        array(
            'label'         => esc_html__('Features content', 'profipaints'),
            'description'   => '',
            'section'       => 'profipaints_features_content',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'profipaints'), // [live_title]
            'max_item'      => 124, // Maximum item can add
            'limited_msg'     => wp_kses_post(__('Upgrade to <a target="_blank" href="https://www.famethemes.com/plugins/profipaints-plus/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=profipaints_customizer#get-started">ProfiPaints Plus</a> to be able to add more items and unlock other premium features!', 'profipaints')),
            'fields'    => array(
                'title'  => array(
                    'title' => esc_html__('Title', 'profipaints'),
                    'type'  => 'text',
                ),
                'subtitle'  => array(
                    'title' => esc_html__('Subtitle', 'profipaints'),
                    'type'  => 'text',
                ),
                // 'icon_type'  => array(
                //     'title' => esc_html__('Custom icon', 'profipaints'),
                //     'type'  => 'select',
                //     'options' => array(
                //         'icon' => esc_html__('Icon', 'profipaints'),
                //         'image' => esc_html__('image', 'profipaints'),
                //     ),
                // ),
                // 'icon'  => array(
                //     'title' => esc_html__('Icon', 'profipaints'),
                //     'type'  => 'icon',
                //     'required' => array('icon_type', '=', 'icon'),
                // ),
                'image'  => array(
                    'title' => esc_html__('Основное фото', 'profipaints'),
                    'type'  => 'media',
                    // 'required' => array('icon_type', '=', 'image'),
                ),
                'image2'  => array(
                    'title' => esc_html__('Доп. фото 1 (в окне)', 'profipaints'),
                    'type'  => 'media',
                    // 'required' => array('icon_type', '=', 'image'),
                ),
                'image3'  => array(
                    'title' => esc_html__('Доп. фото 2 (в окне)', 'profipaints'),
                    'type'  => 'media',
                    // 'required' => array('icon_type', '=', 'image'),
                ),
                'desc'  => array(
                    'title' => esc_html__('Description', 'profipaints'),
                    'type'  => 'editor',
                ),
                // hr
                'divider' => array(
                    'type'    => 'hr-bold'
                ),
                'certificates_title'  => array(
                    'label' => esc_html__('Сертификаты', 'profipaints'),
                    'type'  => 'subheader',
                ),
                // hr
                'divider1' => array(
                    'type'    => 'hr'
                ),
                'link1'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link1__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider2' => array(
                    'type'    => 'hr'
                ),
                'link2'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link2__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider3' => array(
                    'type'    => 'hr'
                ),
                'link3'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link3__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider4' => array(
                    'type'    => 'hr'
                ),
                'link4'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link4__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider5' => array(
                    'type'    => 'hr'
                ),
                'link5'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link5__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider6' => array(
                    'type'    => 'hr'
                ),
                'link6'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link6__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider7' => array(
                    'type'    => 'hr'
                ),
                'link7'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link7__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider8' => array(
                    'type'    => 'hr'
                ),
                'link8'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link8__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider9' => array(
                    'type'    => 'hr'
                ),
                'link9'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link9__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'divider10' => array(
                    'type'    => 'hr'
                ),
                'link10'  => array(
                    'title' => esc_html__('Ссылка на сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'link10__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),

                // Technical docs

                // hr
                'tech_divider' => array(
                    'type'    => 'hr-bold'
                ),
                'tech_title'  => array(
                    'label' => esc_html__('Техничка', 'profipaints'),
                    'type'  => 'subheader',
                ),
                // hr
                'tech_divider1' => array(
                    'type'    => 'hr'
                ),
                'tech_link1'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link1__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider2' => array(
                    'type'    => 'hr'
                ),
                'tech_link2'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link2__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider3' => array(
                    'type'    => 'hr'
                ),
                'tech_link3'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link3__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider4' => array(
                    'type'    => 'hr'
                ),
                'tech_link4'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link4__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider5' => array(
                    'type'    => 'hr'
                ),
                'tech_link5'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link5__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider6' => array(
                    'type'    => 'hr'
                ),
                'tech_link6'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link6__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider7' => array(
                    'type'    => 'hr'
                ),
                'tech_link7'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link7__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider8' => array(
                    'type'    => 'hr'
                ),
                'tech_link8'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link8__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider9' => array(
                    'type'    => 'hr'
                ),
                'tech_link9'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link9__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
                // hr
                'tech_divider10' => array(
                    'type'    => 'hr'
                ),
                'tech_link10'  => array(
                    'title' => esc_html__('Ссылка на тех. сертификат', 'profipaints'),
                    'type'  => 'text',
                ),
                'tech_link10__text'  => array(
                    'title' => esc_html__('Текст ссылки', 'profipaints'),
                    'type'  => 'text',
                ),
            ),

        )
    )
);
