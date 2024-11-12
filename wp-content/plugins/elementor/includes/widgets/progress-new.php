<?php

namespace Elementor;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor progress_new widget.
 *
 * Elementor widget that displays an escalating progress_new bar.
 *
 * @since 1.0.0
 */
class Widget_Progress_New extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve progress_new widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'progress_new';
    }

    /**
     * Get widget title.
     *
     * Retrieve progress_new widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('New Progress Bar', 'elementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve progress_new widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-skill-bar';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['progress', 'bar'];
    }

    protected function is_dynamic_content(): bool
    {
        return false;
    }

    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
        return ['widget-progress_new'];
    }

    /**
     * Register progress_new widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_progress_new',
            [
                'label' => esc_html__('New Progress Bar', 'elementor'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Enter your title', 'elementor'),
                'default' => esc_html__('My Skill', 'elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'span',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'progress_new_type',
            [
                'label' => esc_html__('Type', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'elementor'),
                    'info' => esc_html__('Info', 'elementor'),
                    'success' => esc_html__('Success', 'elementor'),
                    'warning' => esc_html__('Warning', 'elementor'),
                    'danger' => esc_html__('Danger', 'elementor'),
                ],
                'default' => '',
                'condition' => [
                    'progress_new_type!' => '', // a workaround to hide the control, unless it's in use (not default).
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'percent',
            [
                'label' => esc_html__('Percentage', 'elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'display_percentage',
            [
                'label' => esc_html__('Display Percentage', 'elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor'),
                'label_off' => esc_html__('Hide', 'elementor'),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );

        $this->add_control(
            'inner_text',
            [
                'label' => esc_html__('Inner Text', 'elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('e.g. Web Designer', 'elementor'),
                'default' => esc_html__('Web Designer', 'elementor'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_progress_new_style',
            [
                'label' => esc_html__('Progress_new Bar', 'elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label' => esc_html__('Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-progress_new-wrapper .elementor-progress_new_bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-progress_new-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_height',
            [
                'label' => esc_html__('Height', 'elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-progress_new_bar' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-progress_new-wrapper' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_control(
            'inner_text_heading',
            [
                'label' => esc_html__('Inner Text', 'elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bar_inline_color',
            [
                'label' => esc_html__('Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-progress_new_bar' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bar_inner_typography',
                'selector' => '{{WRAPPER}} .elementor-progress_new_bar',
                'exclude' => [
                    'line_height',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'bar_inner_shadow',
                'selector' => '{{WRAPPER}} .elementor-progress_new_bar',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Title Style', 'elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-title' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .elementor-title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .elementor-title',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render progress_new widget output on the frontend.
     * Make sure value does no exceed 100%.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['title']) && empty($settings['percent']['size'])) {
            return;
        }

        $progress_new_bar_id = 'elementor-progress_new_bar-' . $this->get_id();

        $progress_new_percentage = is_numeric($settings['percent']['size']) ? $settings['percent']['size'] : '0';
        if (100 < $progress_new_percentage) {
            $progress_new_percentage = 100;
        }

        if (! Utils::is_empty($settings['title'])) {
            $this->add_render_attribute(
                'title',
                [
                    'class' => 'elementor-title',
                    'id' => $progress_new_bar_id,
                ]
            );

            $this->add_inline_editing_attributes('title');

            $this->add_render_attribute('wrapper', 'aria-labelledby', $progress_new_bar_id);
        }

        $this->add_render_attribute(
            'wrapper',
            [
                'class' => 'elementor-progress_new-wrapper',
                'role' => 'progress_new_bar',
                'aria-valuemin' => '0',
                'aria-valuemax' => '100',
                'aria-valuenow' => $progress_new_percentage,
            ]
        );

        if (! empty($settings['inner_text'])) {
            $this->add_render_attribute('wrapper', 'aria-valuetext', "{$progress_new_percentage}% ({$settings['inner_text']})");
        }

        if (! empty($settings['progress_new_type'])) {
            $this->add_render_attribute('wrapper', 'class', 'progress_new-' . $settings['progress_new_type']);
        }

        $this->add_render_attribute(
            'progress_new_bar',
            [
                'class' => 'elementor-progress_new_bar',
                'data-max' => $progress_new_percentage,
            ]
        );

        $this->add_render_attribute('inner_text', 'class', 'elementor-progress_new-text');

        $this->add_inline_editing_attributes('inner_text');

        if (! Utils::is_empty($settings['title'])) { ?>
            <<?php Utils::print_validated_html_tag($settings['title_tag']); ?> <?php $this->print_render_attribute_string('title'); ?>>
                <?php $this->print_unescaped_setting('title'); ?>
            </<?php Utils::print_validated_html_tag($settings['title_tag']); ?>>
        <?php } ?>

        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div <?php $this->print_render_attribute_string('progress_new_bar'); ?>>
                <span <?php $this->print_render_attribute_string('inner_text'); ?>><?php $this->print_unescaped_setting('inner_text'); ?></span>
                <?php if ('show' === $settings['display_percentage']) { ?>
                    <span class="elementor-progress_new-percentage"><?php echo $progress_new_percentage; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                    ?>%</span>
                <?php } ?>
            </div>
        </div>
    <?php
    }

    /**
     * Render progress_new widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    ?>
        <#
            if ( ''===settings.title && ''===settings.percent.size ) {
            return;
            }

            const title_tag=elementor.helpers.validateHTMLTag( settings.title_tag );
            const progress_new_bar_id='elementor-progress_new_bar-<?php echo esc_attr($this->get_id()); ?>' ;

            let progress_new_percentage=0;
            if ( ! isNaN( settings.percent.size ) ) {
            progress_new_percentage=100 < settings.percent.size ? 100 : settings.percent.size;
            }

            if ( settings.title ) {
            view.addRenderAttribute( 'title' ,
            { 'class' : 'elementor-title' , 'id' : progress_new_bar_id,
            }
            );

            view.addInlineEditingAttributes( 'title' );

            view.addRenderAttribute( 'wrapper' , 'aria-labelledby' , progress_new_bar_id );
            }

            view.addRenderAttribute( 'progress_newWrapper' ,
            { 'class' : [ 'elementor-progress_new-wrapper' , 'progress_new-' + settings.progress_new_type ], 'role' : 'progress_new_bar' , 'aria-valuemin' : '0' , 'aria-valuemax' : '100' , 'aria-valuenow' : progress_new_percentage,
            }
            );

            if ( '' !==settings.inner_text ) {
            view.addRenderAttribute( 'progress_newWrapper' , 'aria-valuetext' , progress_new_percentage + '% (' + settings.inner_text + ')' );
            }

            view.addRenderAttribute( 'inner_text' , 'class' , 'elementor-progress_new-text' );

            view.addInlineEditingAttributes( 'inner_text' );
            #>
            <# if ( settings.title ) { #>
                <{{ title_tag }} {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</{{ title_tag }}>
                <# } #>
                    <div {{{ view.getRenderAttributeString( 'progress_newWrapper' ) }}}>
                        <div class="elementor-progress_new_bar" data-max="{{ progress_new_percentage }}">
                            <span {{{ view.getRenderAttributeString( 'inner_text' ) }}}>{{{ settings.inner_text }}}</span>
                            <# if ( 'show'===settings.display_percentage ) { #>
                                <span class="elementor-progress_new-percentage">{{{ progress_new_percentage }}}%</span>
                                <# } #>
                        </div>
                    </div>
            <?php
        }
    }
