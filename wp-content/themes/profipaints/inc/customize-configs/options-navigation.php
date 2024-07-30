<?php
/* Navigation Settings
----------------------------------------------------------------------*/
$wp_customize->add_section(
    'profipaints_nav',
    array(
        'priority'    => null,
        'title'       => esc_html__('Navigation', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_options',
    )
);
$wp_customize->add_setting(
    'profipaints_menu_item_padding',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    'profipaints_menu_item_padding',
    array(
        'label'       => esc_html__('Menu Item Padding', 'profipaints'),
        'description' => esc_html__('Padding left and right for Navigation items (pixels).', 'profipaints'),
        'section'     => 'profipaints_nav',
    )
);
