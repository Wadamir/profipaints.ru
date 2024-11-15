<?php

/**
 * Load Controls Files
 */
require_once get_template_directory() . '/inc/customize-controls/section-plus.php';
require_once get_template_directory() . '/inc/customize-controls/control-misc.php';
require_once get_template_directory() . '/inc/customize-controls/control-custom-textarea.php';
require_once get_template_directory() . '/inc/customize-controls/control-custom-textinput.php';
require_once get_template_directory() . '/inc/customize-controls/control-theme-support.php';
require_once get_template_directory() . '/inc/customize-controls/control-editor.php';
require_once get_template_directory() . '/inc/customize-controls/control-color-alpha.php';
require_once get_template_directory() . '/inc/customize-controls/control-repeater.php';
require_once get_template_directory() . '/inc/customize-controls/control-category.php';
require_once get_template_directory() . '/inc/customize-controls/control-pages.php';


class ProfiPaints_Editor_Scripts
{
    /**
     * Enqueue scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function enqueue()
    {

        if (!class_exists('_WP_Editors')) {
            require(ABSPATH . WPINC . '/class-wp-editor.php');
        }

        add_action('customize_controls_print_footer_scripts', array(__CLASS__, 'enqueue_editor'),  2);
        add_action('customize_controls_print_footer_scripts', array('_WP_Editors', 'editor_js'), 50);
        add_action('customize_controls_print_footer_scripts', array('_WP_Editors', 'enqueue_scripts'), 1);
    }

    public  static function enqueue_editor()
    {
        if (!isset($GLOBALS['__wp_mce_editor__']) || !$GLOBALS['__wp_mce_editor__']) {
            $GLOBALS['__wp_mce_editor__'] = true;
?>
            <script id="_wp-mce-editor-tpl" type="text/html">
                <?php wp_editor('', '__wp_mce_editor__'); ?>
            </script>
<?php
        }
    }
}


function onepres_customizer_control_scripts()
{
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');

    wp_enqueue_script('profipaints-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-controls', 'wp-color-picker'), time());
    wp_enqueue_style('profipaints-customizer',  get_template_directory_uri() . '/assets/css/customizer.css');
}

add_action('customize_controls_enqueue_scripts', 'onepres_customizer_control_scripts', 99);
add_action('customize_controls_enqueue_scripts', array('ProfiPaints_Editor_Scripts', 'enqueue'), 95);
