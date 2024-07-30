<?php

/**
 *  Section: News
 */
$wp_customize->add_panel(
    'profipaints_news',
    array(
        'priority'        => 260,
        'title'           => esc_html__('Section: News', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_news_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_news',
    )
);

// Show Content
$wp_customize->add_setting(
    'profipaints_news_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_news_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_news_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_news_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_news_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('news', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_news_id',
    array(
        'label'       => esc_html__('Section ID:', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_news_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Latest News', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_news_title',
    array(
        'label'       => esc_html__('Section Title', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_news_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_news_subtitle',
    array(
        'label'       => esc_html__('Section Subtitle', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_news_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_news_desc',
    array(
        'label'       => esc_html__('Section Description', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
));

// hr
$wp_customize->add_setting(
    'profipaints_news_settings_hr',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
    )
);
$wp_customize->add_control(new ProfiPaints_Misc_Control(
    $wp_customize,
    'profipaints_news_settings_hr',
    array(
        'section' => 'profipaints_news_settings',
        'type'    => 'hr'
    )
));

/**
 * @since 2.1.0
 */
$wp_customize->add_setting(
    'profipaints_news_hide_meta',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => false,
    )
);
$wp_customize->add_control(
    'profipaints_news_hide_meta',
    array(
        'label'       => esc_html__('Hide post categories', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'type' => 'checkbox',
        'description' => '',
    )
);

/**
 * @since 2.1.0
 */
$wp_customize->add_setting(
    'profipaints_news_excerpt_type',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'custom',
    )
);
$wp_customize->add_control(
    'profipaints_news_excerpt_type',
    array(
        'label'       => esc_html__('Custom excerpt length', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'type' => 'select',
        'choices' => array(
            'custom' => __('Custom', 'profipaints'),
            'excerpt' => __('Use excerpt metabox', 'profipaints'),
            'more_tag' => __('Strip excerpt by more tag', 'profipaints'),
            'content' => __('Full content', 'profipaints'),
        ),
        'description' => '',
    )
);

/**
 * @since 2.1.0
 */
$wp_customize->add_setting(
    'profipaints_news_excerpt_length',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_news_excerpt_length',
    array(
        'label'       => esc_html__('Custom excerpt length', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
);


// Number of post to show.
$wp_customize->add_setting(
    'profipaints_news_number',
    array(
        'sanitize_callback' => 'profipaints_sanitize_number',
        'default'           => '3',
    )
);
$wp_customize->add_control(
    'profipaints_news_number',
    array(
        'label'       => esc_html__('Number of post to show', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
);

$wp_customize->add_setting(
    'profipaints_news_cat',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 0,
    )
);

$wp_customize->add_control(new ProfiPaints_Category_Control(
    $wp_customize,
    'profipaints_news_cat',
    array(
        'label'       => esc_html__('Category to show', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
));

$wp_customize->add_setting(
    'profipaints_news_orderby',
    array(
        'sanitize_callback' => 'profipaints_sanitize_select',
        'default'           => 0,
    )
);

$wp_customize->add_control(
    'profipaints_news_orderby',
    array(
        'label'   => esc_html__('Order By', 'profipaints'),
        'section' => 'profipaints_news_settings',
        'type'    => 'select',
        'choices' => array(
            'default'       => esc_html__('Default', 'profipaints'),
            'id'            => esc_html__('ID', 'profipaints'),
            'author'        => esc_html__('Author', 'profipaints'),
            'title'         => esc_html__('Title', 'profipaints'),
            'date'          => esc_html__('Date', 'profipaints'),
            'comment_count' => esc_html__('Comment Count', 'profipaints'),
            'menu_order'    => esc_html__('Order by Page Order', 'profipaints'),
            'rand'          => esc_html__('Random order', 'profipaints'),
        )
    )
);

$wp_customize->add_setting(
    'profipaints_news_order',
    array(
        'sanitize_callback' => 'profipaints_sanitize_select',
        'default'           => 'desc',
    )
);

$wp_customize->add_control(
    'profipaints_news_order',
    array(
        'label'   => esc_html__('Order', 'profipaints'),
        'section' => 'profipaints_news_settings',
        'type'    => 'select',
        'choices' => array(
            'desc' => esc_html__('Descending', 'profipaints'),
            'asc'  => esc_html__('Ascending', 'profipaints'),
        )
    )
);

// Blog Button

$wp_customize->add_setting(
    'profipaints_news_more_page',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);

$wp_customize->add_control(new ProfiPaints_Pages_Control(
    $wp_customize,
    'profipaints_news_more_page',
    array(
        'label'       => esc_html__('More News Page', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'show_option_none' =>  esc_html__('Custom Link', 'profipaints'),
        'description' => esc_html__('It should be your blog page link.', 'profipaints')
    )
));


$wp_customize->add_setting(
    'profipaints_news_more_link',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);

$wp_customize->add_control(
    'profipaints_news_more_link',
    array(
        'label'       => esc_html__('Custom More News link', 'profipaints'),
        'section'     => 'profipaints_news_settings'
    )
);


$wp_customize->add_setting(
    'profipaints_news_more_text',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Read Our Blog', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_news_more_text',
    array(
        'label'       => esc_html__('More News Button Text', 'profipaints'),
        'section'     => 'profipaints_news_settings',
        'description' => '',
    )
);

// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_news_settings' );
