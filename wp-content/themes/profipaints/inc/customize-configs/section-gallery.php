<?php

/**
 * Section: Gallery.
 *
 * @package profipaints
 */

$wp_customize->add_panel(
    'profipaints_gallery',
    array(
        'priority'        => 190,
        'title'           => esc_html__('Section: Gallery', 'profipaints'),
        'description'     => '',
        'active_callback' => 'profipaints_showon_frontpage',
    )
);

$wp_customize->add_section(
    'profipaints_gallery_settings',
    array(
        'priority'    => 3,
        'title'       => esc_html__('Section Settings', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_gallery',
    )
);

// Show Content.
$wp_customize->add_setting(
    'profipaints_gallery_disable',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => 1,
    )
);
$wp_customize->add_control(
    'profipaints_gallery_disable',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide this section?', 'profipaints'),
        'section'     => 'profipaints_gallery_settings',
        'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Meta Color Content
$wp_customize->add_setting(
    'profipaints_gallery_meta',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_gallery_meta',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Темный цвет?', 'profipaints'),
        'section'     => 'profipaints_gallery_settings',
        // 'description' => esc_html__('Check this box to hide this section.', 'profipaints'),
    )
);

// Section ID.
$wp_customize->add_setting(
    'profipaints_gallery_id',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => esc_html__('gallery', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_gallery_id',
    array(
        'label'       => esc_html__('Section ID:', 'profipaints'),
        'section'     => 'profipaints_gallery_settings',
        'description' => esc_html__('The section ID should be English character, lowercase and no space.', 'profipaints'),
    )
);

// Title.
$wp_customize->add_setting(
    'profipaints_gallery_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Gallery', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_gallery_title',
    array(
        'label'       => esc_html__('Section Title', 'profipaints'),
        'section'     => 'profipaints_gallery_settings',
        'description' => '',
    )
);

// Sub Title.
$wp_customize->add_setting(
    'profipaints_gallery_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_gallery_subtitle',
    array(
        'label'       => esc_html__('Section Subtitle', 'profipaints'),
        'section'     => 'profipaints_gallery_settings',
        'description' => '',
    )
);

// Description
$wp_customize->add_setting(
    'profipaints_gallery_desc',
    array(
        'sanitize_callback' => 'profipaints_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    new ProfiPaints_Editor_Custom_Control(
        $wp_customize,
        'profipaints_gallery_desc',
        array(
            'label'       => esc_html__('Section Description', 'profipaints'),
            'section'     => 'profipaints_gallery_settings',
            'description' => '',
        )
    )
);


// profipaints_add_upsell_for_section( $wp_customize, 'profipaints_gallery_settings' );


$wp_customize->add_section(
    'profipaints_gallery_content',
    array(
        'priority'    => 6,
        'title'       => esc_html__('Section Content', 'profipaints'),
        'description' => '',
        'panel'       => 'profipaints_gallery',
    )
);
// Gallery Source
$wp_customize->add_setting(
    'profipaints_gallery_source',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'validate_callback' => 'profipaints_gallery_source_validate',
        'default'           => 'page',
    )
);
$wp_customize->add_control(
    'profipaints_gallery_source',
    array(
        'label'    => esc_html__('Select Gallery Source', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'type'     => 'select',
        'priority' => 5,
        'choices'  => array(
            'page'      => esc_html__('Page', 'profipaints'),
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'flickr'    => 'Flickr',
        ),
    )
);

// Source page settings.
$wp_customize->add_setting(
    'profipaints_gallery_source_page',
    array(
        'sanitize_callback' => 'profipaints_sanitize_number',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_gallery_source_page',
    array(
        'label'       => esc_html__('Select Gallery Page', 'profipaints'),
        'section'     => 'profipaints_gallery_content',
        'type'        => 'select',
        'priority'    => 10,
        'choices'     => $option_pages,
        'description' => esc_html__('Select a page which have content contain [gallery] shortcode or gallery blocks.', 'profipaints'),
    )
);


// Gallery Layout.
$wp_customize->add_setting(
    'profipaints_gallery_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'default',
    )
);
$wp_customize->add_control(
    'profipaints_gallery_layout',
    array(
        'label'    => esc_html__('Layout', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'type'     => 'select',
        'priority' => 40,
        'choices'  => array(
            'default'    => esc_html__('Default, inside container', 'profipaints'),
            'full-width' => esc_html__('Full Width', 'profipaints'),
        ),
    )
);

// Gallery Display.
$wp_customize->add_setting(
    'profipaints_gallery_display',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'default',
    )
);
$wp_customize->add_control(
    'profipaints_gallery_display',
    array(
        'label'    => esc_html__('Display', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'type'     => 'select',
        'priority' => 50,
        'choices'  => array(
            'grid'      => esc_html__('Grid', 'profipaints'),
            'carousel'  => esc_html__('Carousel', 'profipaints'),
            'slider'    => esc_html__('Slider', 'profipaints'),
            'justified' => esc_html__('Justified', 'profipaints'),
            'masonry'   => esc_html__('Masonry', 'profipaints'),
        ),
    )
);

// Gallery grid spacing.
$wp_customize->add_setting(
    'profipaints_g_spacing',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 20,
    )
);
$wp_customize->add_control(
    'profipaints_g_spacing',
    array(
        'label'    => esc_html__('Item Spacing', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 55,

    )
);

// Gallery grid spacing.
$wp_customize->add_setting(
    'profipaints_g_row_height',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 120,
    )
);
$wp_customize->add_control(
    'profipaints_g_row_height',
    array(
        'label'    => esc_html__('Row Height', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 57,

    )
);

// Gallery grid gird col.
$wp_customize->add_setting(
    'profipaints_g_col',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '4',
    )
);
$wp_customize->add_control(
    'profipaints_g_col',
    array(
        'label'    => esc_html__('Layout columns', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 60,
        'type'     => 'select',
        'choices'  => array(
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
        ),

    )
);

// Gallery max number.
$wp_customize->add_setting(
    'profipaints_g_number',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 10,
    )
);
$wp_customize->add_control(
    'profipaints_g_number',
    array(
        'label'    => esc_html__('Number items', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 65,
    )
);
// Gallery grid spacing.
$wp_customize->add_setting(
    'profipaints_g_lightbox',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => 1,
    )
);
$wp_customize->add_control(
    'profipaints_g_lightbox',
    array(
        'label'    => esc_html__('Enable Lightbox', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 70,
        'type'     => 'checkbox',
    )
);

// Gallery image link to single.
$wp_customize->add_setting(
    'profipaints_g_image_link',
    array(
        'sanitize_callback' => 'profipaints_sanitize_checkbox',
        'default'           => 1,
    )
);
$wp_customize->add_control(
    'profipaints_g_image_link',
    array(
        'label'    => esc_html__('Enable Image Link', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 71,
        'type'     => 'checkbox',
    )
);

// Gallery readmore link.
$wp_customize->add_setting(
    'profipaints_g_readmore_link',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'profipaints_g_readmore_link',
    array(
        'label'    => esc_html__('Read More Link', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 90,
        'type'     => 'text',
    )
);

$wp_customize->add_setting(
    'profipaints_g_readmore_text',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('View More', 'profipaints'),
    )
);
$wp_customize->add_control(
    'profipaints_g_readmore_text',
    array(
        'label'    => esc_html__('Read More Text', 'profipaints'),
        'section'  => 'profipaints_gallery_content',
        'priority' => 100,
        'type'     => 'text',
    )
);
