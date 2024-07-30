<?php

/**
 * Site Identity.
 */

$is_old_logo = get_theme_mod('profipaints_site_image_logo');

$wp_customize->add_setting(
    'profipaints_hide_sitetitle',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => $is_old_logo ? 1 : 0,
    )
);
$wp_customize->add_control(
    'profipaints_hide_sitetitle',
    array(
        'label'   => esc_html__('Hide site title', 'profipaints'),
        'section' => 'title_tagline',
        'type'    => 'checkbox',
    )
);

$wp_customize->add_setting(
    'profipaints_hide_tagline',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => $is_old_logo ? 1 : 0,
    )
);
$wp_customize->add_control(
    'profipaints_hide_tagline',
    array(
        'label'   => esc_html__('Hide site tagline', 'profipaints'),
        'section' => 'title_tagline',
        'type'    => 'checkbox',

    )
);

// Mobile Logo
$wp_customize->add_setting(
    'profipaints_mobile_logo',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'profipaints_mobile_logo',
        array(
            'label'   => esc_html__('Mobile Logo', 'profipaints'),
            'section' => 'title_tagline',
        )
    )
);

// Retina Logo
$wp_customize->add_setting(
    'profipaints_retina_logo',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'profipaints_retina_logo',
        array(
            'label'   => esc_html__('Retina Logo', 'profipaints'),
            'section' => 'title_tagline',
        )
    )
);


// Logo Width
$wp_customize->add_setting(
    'profipaints_logo_height',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    'profipaints_logo_height',
    array(
        'label'   => esc_html__('Logo Height In Pixel', 'profipaints'),
        'section' => 'title_tagline',
    )

);
