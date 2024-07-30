<?php

/**
 * Section: Counter
 */
$wp_customize->add_panel(
    'profipaints_counter',
    array(
        'priority'        => 210,
        'title'           => esc_html__('Section: Counter', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage'
    )
);

$wp_customize->add_section(
    'profipaints_counter_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_counter',
    )
);
// Show Content
$wp_customize->add_setting(
    'profipaints_counter_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_counter_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_counter_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);
// Meta Color Content
$wp_customize->add_setting(
    'profipaints_counter_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_counter_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_counter_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID
$wp_customize->add_setting(
    'profipaints_counter_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('counter', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_id',
    array(
        'label'         => esc_html__('Section ID:', 'profipaints'),
        'section'         => 'profipaints_counter_settings',
        'description'   => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints')
    )
);

// Title
$wp_customize->add_setting(
    'profipaints_counter_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Our Numbers', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_title',
    array(
        'label'         => esc_html__('Section Title', 'profipaints'),
        'section'         => 'profipaints_counter_settings',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting(
    'profipaints_counter_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_subtitle',
    array(
        'label'         => esc_html__('Section Subtitle', 'profipaints'),
        'section'         => 'profipaints_counter_settings',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_counter_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(new ProfiPaints_Editor_Custom_Control(
    $wp_customize,
    'profipaints_counter_desc',
    array(
        'label'         => esc_html__('Section Description', 'profipaints'),
        'section'         => 'profipaints_counter_settings',
        'description'   => '',
    )
));

// Ячейка для ответа
$wp_customize->add_setting(
    'profipaints_counter_answer',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('B27', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_answer',
    array(
        'label'         => esc_html__('Ячейка таблицы с ответом', 'profipaints'),
        'section'         => 'profipaints_counter_settings'
    )
);

// Текст на кнопке
$wp_customize->add_setting(
    'profipaints_counter_btn_text',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('Рассчитать стоимость работ', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_btn_text',
    array(
        'label'         => esc_html__('Текст на кнопке калькулятора', 'profipaints'),
        'section'         => 'profipaints_counter_settings'
    )
);

// Шорткод Формы
$wp_customize->add_setting(
    'profipaints_counter_form',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('[contact-form-7 id="1566" title="Contact form 2"]', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_counter_form',
    array(
        'label'         => esc_html__('Шорткод формы для калькулятора', 'profipaints'),
        'section'         => 'profipaints_counter_settings'
    )
);

// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_counter_settings' );

$wp_customize->add_section(
    'profipaints_counter_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_counter',
    )
);

// Order & Styling
$wp_customize->add_setting(
    'profipaints_counter_boxes',
    array(
        'sanitize_callback' => 'profipaints_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    )
);


$wp_customize->add_control(
    new Profipaints_Customize_Repeatable_Control(
        $wp_customize,
        'profipaints_counter_boxes',
        array(
            'label'         => esc_html__('Counter content', 'profipaints'),
            'description'   => '',
            'section'       => 'profipaints_counter_content',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'profipaints'), // [live_title]
            'max_item'      => 144, // Maximum item can add
            'limited_msg'     => wp_kses_post(__('Have a good day!', 'profipaints')),
            'fields'    => array(
                'title' => array(
                    'title' => esc_html__('Название поля', 'profipaints'),
                    'type'  => 'text',
                    'desc'  => '',
                ),
                'number' => array(
                    'title' => esc_html__('Ссылка', 'profipaints'),
                    'type'  => 'text',
                    'desc'  => '',
                ),
                'unit_before'  => array(
                    'title' => esc_html__('Тип поля', 'profipaints'),
                    'type'  => 'text',
                    'default' => '',
                ),
                'unit_after'  => array(
                    'title' => esc_html__('Ячейка в Google таблице', 'profipaints'),
                    'type'  => 'text',
                    'default' => '',
                    'desc'  => 'Например: B10',
                ),
            ),

        )
    )
);
