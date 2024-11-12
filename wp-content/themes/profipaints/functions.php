<?php

/**
 * ProfiPaints functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ProfiPaints
 */

if (!function_exists('profipaints_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function profipaints_setup()
    {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ProfiPaints, use a find and replace
		 * to change 'profipaints' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('profipaints', get_template_directory() . '/languages');

        /*
		 * Add default posts and comments RSS feed links to head.
		 */
        add_theme_support('automatic-feed-links');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /**
         * Excerpt for page
         */
        add_post_type_support('page', 'excerpt');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');
        add_image_size('profipaints-blog-small', 300, 150, true);
        add_image_size('profipaints-small', 480, 300, true);
        add_image_size('profipaints-medium', 640, 400, true);

        /*
		 * This theme uses wp_nav_menu() in one location.
		 */
        register_nav_menus(
            array(
                'primary'      => esc_html__('Primary Menu', 'profipaints'),
            )
        );

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /*
		 * WooCommerce support.
		 */
        add_theme_support('woocommerce');

        /**
         * Add theme Support custom logo
         *
         * @since WP 4.5
         * @sin 1.2.1
         */

        add_theme_support(
            'custom-logo',
            array(
                'height'      => 37,
                'width'       => 338,
                'flex-height' => true,
                'flex-width'  => true,
                // 'header-text' => array( 'site-title',  'site-description' ), //
            )
        );

        // Recommend plugins.
        add_theme_support(
            'recommend-plugins',
            array(
                'wpforms-lite' => array(
                    'name' => esc_html__('Contact Form by WPForms', 'profipaints'),
                    'active_filename' => 'wpforms-lite/wpforms.php',
                ),
                'famethemes-demo-importer' => array(
                    'name' => esc_html__('Famethemes Demo Importer', 'profipaints'),
                    'active_filename' => 'famethemes-demo-importer/famethemes-demo-importer.php',
                ),
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for WooCommerce.
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        /**
         * Add support for Gutenberg.
         *
         * @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
         */
        // add_theme_support('editor-styles');
        add_theme_support('align-wide');

        /*
		 * This theme styles the visual editor to resemble the theme style.
		 */
        // add_editor_style(array('editor-style.css', profipaints_fonts_url()));
    }
endif;
add_action('after_setup_theme', 'profipaints_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function profipaints_content_width()
{
    /**
     * Support dynamic content width
     *
     * @since 2.1.1
     */
    $width = absint(get_theme_mod('single_layout_content_width'));
    if ($width <= 0) {
        $width = 800;
    }
    $GLOBALS['content_width'] = apply_filters('profipaints_content_width', $width);
}
add_action('after_setup_theme', 'profipaints_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function profipaints_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'profipaints'),
            'id'            => 'sidebar-1',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    if (class_exists('WooCommerce')) {
        register_sidebar(
            array(
                'name'          => esc_html__('WooCommerce Sidebar', 'profipaints'),
                'id'            => 'sidebar-shop',
                'description'   => '',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(
            array(
                'name' => sprintf(__('Footer %s', 'profipaints'), $i),
                'id' => 'footer-' . $i,
                'description' => '',
                'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
        );
    }
}
add_action('widgets_init', 'profipaints_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function profipaints_scripts()
{

    $theme = wp_get_theme('profipaints');
    $version = $theme->get('Version');

    if (!get_theme_mod('profipaints_disable_g_font')) {
        wp_enqueue_style('profipaints-fonts', profipaints_fonts_url(), array(), $version);
    }

    wp_enqueue_style('profipaints-animate', get_template_directory_uri() . '/assets/css/animate.min.css', array(), $version);
    wp_enqueue_style('profipaints-fa', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0');
    wp_enqueue_style('profipaints-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', false, $version);
    wp_enqueue_style('profipaints-style', get_template_directory_uri() . '/style.css');

    $custom_css = profipaints_custom_inline_style();
    wp_add_inline_style('profipaints-style', $custom_css);

    wp_enqueue_script('jquery');
    wp_enqueue_script('profipaints-js-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery'), $version, true);
    wp_enqueue_script('profipaints-js-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), $version, true);

    // Animation from settings.
    $profipaints_js_settings = array(
        'profipaints_disable_animation'     => get_theme_mod('profipaints_animation_disable'),
        'profipaints_disable_sticky_header' => get_theme_mod('profipaints_sticky_header_disable'),
        'profipaints_vertical_align_menu'   => get_theme_mod('profipaints_vertical_align_menu'),
        'hero_animation'                 => get_theme_mod('profipaints_hero_option_animation', 'flipInX'),
        'hero_speed'                     => intval(get_theme_mod('profipaints_hero_option_speed', 5000)),
        'hero_fade'                      => intval(get_theme_mod('profipaints_hero_slider_fade', 750)),
        'hero_duration'                  => intval(get_theme_mod('profipaints_hero_slider_duration', 5000)),
        'hero_disable_preload'           => get_theme_mod('profipaints_hero_disable_preload', false) ? true : false,
        'is_home'                        => '',
        'gallery_enable'                 => '',
        'is_rtl' => is_rtl(),
    );

    // Load gallery scripts.
    $galley_disable  = get_theme_mod('profipaints_gallery_disable') == 1 ? true : false;
    $is_shop = false;
    if (function_exists('is_woocommerce')) {
        if (is_woocommerce()) {
            $is_shop = true;
        }
    }

    // Don't load scripts for woocommerce because it don't need.
    if (!$is_shop) {
        if (!$galley_disable || is_customize_preview()) {
            $profipaints_js_settings['gallery_enable'] = 1;
            $display = get_theme_mod('profipaints_gallery_display', 'grid');
            if (!is_customize_preview()) {
                switch ($display) {
                    case 'masonry':
                        wp_enqueue_script('profipaints-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array(), $version, true);
                        break;
                    case 'justified':
                        wp_enqueue_script('profipaints-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js', array(), $version, true);
                        break;
                    default:
                        break;
                }
            } else {
                wp_enqueue_script('profipaints-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array(), $version, true);
                wp_enqueue_script('profipaints-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js', array(), $version, true);
            }
        }
        wp_enqueue_script('profipaints-gallery-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), $version, true);
        wp_enqueue_style('profipaints-gallery-lightgallery', get_template_directory_uri() . '/assets/css/lightgallery.css');
    }

    wp_enqueue_script('profipaints-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), $version, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_front_page() && is_page_template('template-frontpage.php')) {
        if (get_theme_mod('profipaints_header_scroll_logo')) {
            $profipaints_js_settings['is_home'] = 1;
        }
    }
    wp_localize_script('jquery', 'profipaints_js_settings', $profipaints_js_settings);
}
add_action('wp_enqueue_scripts', 'profipaints_scripts');


if (!function_exists('profipaints_fonts_url')) :
    /**
     * Register default Google fonts
     */
    function profipaints_fonts_url()
    {
        $fonts_url = '';

        /*
		* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $open_sans = _x('off', 'Open Sans font: on or off', 'profipaints');

        /*
		* Translators: If there are characters in your language that are not
		* supported by Raleway, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $raleway = _x('off', 'Raleway font: on or off', 'profipaints');

        /*
		* Translators: If there are characters in your language that are not
		* supported by Roboto Condensed, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $roboto_condensed = _x('off', 'Roboto Condensed font: on or off', 'profipaints');

        /*
		* Translators: If there are characters in your language that are not
		* supported by Oswald, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $oswald = _x('off', 'Oswald font: on or off', 'profipaints');

        /*
		* Translators: If there are characters in your language that are not
		* supported by Oswald, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $playfair = _x('off', 'Playfair Display font: on or off', 'profipaints');

        /*
		* Translators: If there are characters in your language that are not
		* supported by Oswald, translate this to 'off'. Do not translate
		* into your own language.
		*/
        $montserrat = _x('on', 'Montserrat font: on or off', 'profipaints');

        if ('off' !== $raleway || 'off' !== $open_sans || 'off' !== $roboto_condensed || 'off' !== $montserrat) {
            $font_families = array();

            if ('off' !== $raleway) {
                $font_families[] = 'Raleway:400,500,600,700,300,100,800,900';
            }

            if ('off' !== $open_sans) {
                $font_families[] = 'Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic';
            }

            if ('off' !== $roboto_condensed) {
                $font_families[] = 'Roboto+Condensed:400,300,300italic,400italic,700,700italic';
            }

            if ('off' !== $playfair) {
                $font_families[] = 'Playfair+Display:400,300,300italic,400italic,700,700italic';
            }

            if ('off' !== $oswald) {
                $font_families[] = 'Oswald:300,400,500,600,700';
            }

            if ('off' !== $montserrat) {
                $font_families[] = 'Montserrat:ital,wght@0,100..900;1,100..900&display=swap';
            }

            /*
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            */

            $query_args = array(
                'family' => implode('|', $font_families),
                // 'subset' => urlencode('latin,latin-ext'),
            );

            // $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css2');
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap';
        }

        return esc_url_raw($fonts_url);
    }
endif;


if (!function_exists('add_preconnect_links')) :
    function add_preconnect_links()
    {
        $domains = [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
        ];
        foreach ($domains as $domain) {
?>
            <link rel="preconnect" href="<?php echo $domain; ?>" crossorigin>
    <?php
        }
    }
    add_action('wp_head', 'add_preconnect_links', 5);
endif;



/**
 * Glabel ProfiPaints loop properties
 *
 * @since 2.1.0
 */
global $profipaints_loop_props;
$profipaints_loop_props = array();

/**
 * Set profipaints loop property.
 *
 * @since 2.1.0
 *
 * @param string $prop
 * @param string $value
 */
function profipaints_loop_set_prop($prop, $value)
{
    global $profipaints_loop_props;
    $profipaints_loop_props[$prop] = $value;
}


/**
 * Get profipaints loop property
 *
 * @since 2.1.0
 *
 * @param $prop
 * @param bool $default
 *
 * @return bool|mixed
 */
function profipaints_loop_get_prop($prop, $default = false)
{
    global $profipaints_loop_props;
    if (isset($profipaints_loop_props[$prop])) {
        return apply_filters('profipaints_loop_get_prop', $profipaints_loop_props[$prop], $prop);
    }

    return apply_filters('profipaints_loop_get_prop', $default, $prop);
}

/**
 * Remove profipaints loop property
 *
 * @since 2.1.0
 *
 * @param $prop
 */
function profipaints_loop_remove_prop($prop)
{
    global $profipaints_loop_props;
    if (isset($profipaints_loop_props[$prop])) {
        unset($profipaints_loop_props[$prop]);
    }
}

/**
 * Trim the excerpt with custom length
 *
 * @since 2.1.0
 *
 * @see wp_trim_excerpt
 * @param $text
 * @param null $excerpt_length
 * @return string
 */
function profipaints_trim_excerpt($text, $excerpt_length = null)
{
    $text = strip_shortcodes($text);
    /** This filter is documented in wp-includes/post-template.php */
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);

    if (!$excerpt_length) {
        /**
         * Filters the number of words in an excerpt.
         *
         * @since 2.7.0
         *
         * @param int $number The number of words. Default 55.
         */
        $excerpt_length = apply_filters('excerpt_length', 55);
    }

    /**
     * Filters the string in the "more" link displayed after a trimmed excerpt.
     *
     * @since 2.9.0
     *
     * @param string $more_string The string shown within the more link.
     */
    $excerpt_more = apply_filters('excerpt_more', ' ' . '&hellip;');

    return wp_trim_words($text, $excerpt_length, $excerpt_more);
}

/**
 * Display the excerpt
 *
 * @param string $type
 * @param bool   $length
 */
function profipaints_the_excerpt($type = false, $length = false)
{

    $type = profipaints_loop_get_prop('excerpt_type', 'excerpt');
    $length = profipaints_loop_get_prop('excerpt_length', false);

    switch ($type) {
        case 'excerpt':
            the_excerpt();
            break;
        case 'more_tag':
            the_content('', true);
            break;
        case 'content':
            the_content('', false);
            break;
        default:
            $text = '';
            global $post;
            if ($post) {
                if ($post->post_excerpt) {
                    $text = $post->post_excerpt;
                } else {
                    $text = $post->post_content;
                }
            }
            $excerpt = profipaints_trim_excerpt($text, $length);
            if ($excerpt) {
                // WPCS: XSS OK.
                echo apply_filters('the_excerpt', $excerpt);
            } else {
                the_excerpt();
            }
    }
}

/**
 * Config class
 *
 * @since 2.1.1
 */
require get_template_directory() . '/inc/class-config.php';

/**
 * Load Sanitize
 */
require get_template_directory() . '/inc/sanitize.php';

/**
 * Custom Metabox  for this theme.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Dots Navigation class
 *
 * @since 2.1.0
 */
require get_template_directory() . '/inc/class-sections-navigation.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add theme info page
 */
require get_template_directory() . '/inc/admin/dashboard.php';

/**
 * Editor Style
 *
 * @since 2.2.1
 */
require get_template_directory() . '/inc/admin/class-editor.php';

/*
 * Form to Add Lesson
 */

function add_lesson_form()
{
    $language_terms = get_terms('language', [
        'hide_empty' => false,
    ]);
    // var_dump($language_terms);
    ob_start();
    ?>
    <div class="modal fade" id="addLesson" tabindex="-1" aria-labelledby="addLessonLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="addLessonLabel">Add Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="lesson_id" id="lessonId">
                        <div id="lesson_photo" class="mb-3">
                            <img src="/wp-content/themes/profipaints/assets/images/no-image.png" class="lesson-image" id="lessonThumb" alt="Lesson Thumbnail">
                            <input type="hidden" name="lesson_thumb_id" id="lessonThumbId">
                            <div id="lesson_photo__preloader">
                                <div class="lds-roller">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div id="lesson_photo__input_wrapper">
                                <label for="lesson_photo__input" id="lesson_photo__input_label" class="lesson-image-input-wrapper cover-image lesson-image-add">
                                    <span class="lesson-image-add-text">+ Replace Photo</span>
                                    <input type="file" class="fm-image-input" aria-label="" id="lesson_photo__input" accept="image/*" style="display:none">
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="lessonTitle" class="form-label">Lesson Title</label>
                            <input type="text" name="lesson_title" class="form-control lesson_title" id="lessonTitle">
                        </div>
                        <div class="mb-3">
                            <label for="lessonDescription" class="form-label">Lesson Description</label>
                            <textarea name="lesson_description" class="form-control" id="lessonDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lessonLanguage" class="form-label">Language</label>
                            <select name="lesson_language" class="form-select" id="lessonLanguage">
                                <option value="">Select Language</option>
                                <?php
                                foreach ($language_terms as $term) {
                                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="lesson_status" class="form-check-input" id="lessonStatus">
                            <label class="form-check-label" for="lessonStatus">Lesson finished</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="save-lesson" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('add_lesson_form', 'add_lesson_form');

add_action('wp_ajax_save_lesson', 'save_lesson');
function save_lesson()
{
    $response = [];
    $lesson_id = intval($_POST['lesson_id']);
    $response['lesson_id'] = $lesson_id;
    $lesson_thumbnail_id = isset($_POST['lesson_thumbnail_id']) ? intval($_POST['lesson_thumbnail_id']) : null;
    $response['lesson_thumbnail_id'] = $lesson_thumbnail_id;
    $title = $_POST['lesson_title'];
    $description = $_POST['lesson_description'];
    $language_id = ($_POST['lesson_language'] && intval($_POST['lesson_language']) > 0) ? intval($_POST['lesson_language']) : null;
    $status = (isset($_POST['lesson_status']) && ($_POST['lesson_status'] === '1' || $_POST['lesson_status'] === 'finished')) ? 'finished' : 'active';
    $response['message'] = 'Trying to save lesson ' . $title . ' with status ' . $status;
    if (isset($lesson_id) && $lesson_id !== null && intval($lesson_id) > 0) {
        $post_id = wp_update_post(array(
            'ID' => $lesson_id,
            'post_title' => esc_html($title),
            'post_content' => sanitize_post($description),
            'post_status' => 'publish',
            'post_type' => 'lessons'
        ));
        $response['message'] .= ' | Lesson updated ' . $post_id;
    } else {
        $post_id = wp_insert_post(array(
            'post_title' => esc_html($title),
            'post_content' => sanitize_post($description),
            'post_status' => 'publish',
            'post_type' => 'lessons'
        ));
        $response['message'] .= ' | Lesson created ' . $post_id;
    }
    if ($post_id) {
        $response['post_id'] = $post_id;
        $meta_status = get_post_meta($post_id, 'status', true);
        if ($meta_status && $meta_status !== null && $meta_status !== '' && $meta_status !== [] && $meta_status !== $status) {
            $post_meta_result = update_post_meta($post_id, 'status', $status);
        } else if ($meta_status !== $status) {
            $post_meta_result = add_post_meta($post_id, 'status', $status);
        } else {
            $post_meta_result = 'unchanged';
        }
        if ($post_meta_result) {
            $response['post_meta_result'] = $post_meta_result;
            $response['message'] .= ' | Lesson status saved ' . $status;
        } else {
            $response['status'] = 'error';
            $response['message'] .= ' | Error saving lesson status';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] .= ' | Error saving lesson';
    }

    if ($response['status'] !== 'error') {
        if ($language_id !== null) {
            $language_terms = wp_get_post_terms($post_id, 'language');
            $response['current_language'] = $language_terms;
            if (!$language_terms || $language_terms === null || $language_terms === []) {
                $language_result = wp_set_post_terms($post_id, $language_id, 'language');
            } else {
                $language_result = 'unchanged';
            }
            if ($language_result) {
                $response['message'] .= ' | Lesson language saved ' . $language_id;
            } else {
                $response['status'] = 'error';
                $response['message'] .= ' | Error saving lesson language';
            }
        } else {
            wp_delete_object_term_relationships($post_id, 'language');
            $response['message'] .= ' | Lesson language removed';
        }
    }

    if ($response['status'] !== 'error') {
        $current_thumbnail_id = get_post_thumbnail_id($post_id);
        $response['current_thumbnail_id'] = $current_thumbnail_id;
        if ($lesson_thumbnail_id !== $current_thumbnail_id) {
            $thumbnail_result = set_post_thumbnail($post_id, $lesson_thumbnail_id);
            if ($thumbnail_result) {
                $response['message'] .= ' | Lesson thumbnail saved ' . $lesson_thumbnail_id;
            } else {
                $response['status'] = 'error';
                $response['message'] .= ' | Error saving lesson thumbnail';
            }
        } else {
            $response['message'] .= ' | Lesson thumbnail unchanged ' . $lesson_thumbnail_id;
        }
    }

    wp_send_json($response);

    wp_die();
}

add_action('wp_ajax_get_lesson', 'get_lesson');
function get_lesson()
{
    $lesson_id = $_POST['lesson_id'];
    $lesson = get_post($lesson_id);
    if (!$lesson) {
        wp_send_json(array('status' => 'error', 'message' => 'Lesson not found'), 404);
    }
    $lesson_id = $lesson->ID;
    $lesson_title = htmlspecialchars_decode($lesson->post_title);
    $lesson_content = htmlspecialchars_decode($lesson->post_content);
    $lesson_status = get_post_meta($lesson_id, 'status', true);
    $lesson_terms = wp_get_post_terms($lesson_id, 'language');
    $lesson_language_id = $lesson_terms[0]->term_id;
    $lesson_thumbnail = (get_the_post_thumbnail_url($lesson_id)) ? get_the_post_thumbnail_url($lesson_id) : '/wp-content/themes/profipaints/assets/images/no-image.png';
    wp_send_json(array('status' => 'success', 'message' => 'Lesson fetched', 'lesson_id' => $lesson_id, 'lesson_title' => $lesson_title, 'lesson_content' => $lesson_content, 'lesson_status' => $lesson_status, 'lesson_language' => $lesson_language_id, 'lesson_thumbnail' => $lesson_thumbnail), 200);
    wp_die();
}


add_action('wp_ajax_remove_lesson', 'remove_lesson');
function remove_lesson()
{
    $lesson_id = $_POST['lesson_id'];
    $result = wp_delete_post($lesson_id);
    if ($result) {
        wp_send_json(array('status' => 'success', 'message' => 'Lesson removed'), 200);
    } else {
        wp_send_json(array('status' => 'error', 'message' => 'Error removing lesson'));
    }
    wp_die();
}

add_action('wp_ajax_upload_photo', 'upload_photo');
function upload_photo()
{
    $response = [];

    $lessonId = filter_input(INPUT_POST, 'lesson_id');
    $response['lesson_id'] = $lessonId;
    $imageName = filter_input(INPUT_POST, 'image_name');
    $response['image_name'] = $imageName;
    $image = filter_input(INPUT_POST, 'image');
    $response['image'] = $image;

    list($mimeContent, $content) = explode(',', $image);

    $mimeType = str_replace(['data:', ';base64'], '', $mimeContent);

    $uploadDirPath = wp_upload_dir()['path'];

    $filePath = $uploadDirPath . '/' . $imageName;

    if (empty($content)) {
        wp_send_json('File is not selected.', 500);
    }

    if (strlen($content) > wp_max_upload_size()) {
        wp_send_json('It is too large than expected.', 500);
    }

    if (!in_array($mimeType, get_allowed_mime_types())) {
        wp_send_json('WordPress doesn\'t allow this type of uploads.', 500);
    }

    $i = 0;
    while (file_exists($filePath)) {
        $filePath = $uploadDirPath . '/' . (++$i) . '_' . $imageName;
    }

    file_put_contents($filePath, base64_decode($content));

    $uploadId = wp_insert_attachment(array(
        'guid'           => $filePath,
        'post_mime_type' => str_replace(['data:', ';base64'], '', $mimeType),
        'post_title'     => preg_replace('/\.[^.]+$/', '', $imageName),
        'post_content'   => '',
        'post_status'    => 'inherit'
    ), $filePath);
    $response['upload_id'] = $uploadId;

    require_once(ABSPATH . 'wp-admin/includes/image.php');

    wp_update_attachment_metadata($uploadId, wp_generate_attachment_metadata($uploadId, $filePath));

    $imgSrc = wp_get_attachment_url($uploadId);
    $response['img_src'] = $imgSrc;
    $response['status'] = 'success';

    wp_send_json($response, 200);
    wp_die();
}
