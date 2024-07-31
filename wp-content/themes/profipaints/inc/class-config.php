<?php

/**
 * Class Profipaints_Config
 * @since 2.1.1
 */
class Profipaints_Config
{

    static private $key = 'profipaints_sections_settings';

    static function is_section_active($section_key)
    {
        $data = get_option(self::$key);
        $force_active = false;
        if (!is_array($data) || empty($data)) {
            $force_active = true;
            $data = array();
        }
        if ($force_active) {
            $active_value = 1;
        } else {
            $active_value = isset($data[$section_key]) ? $data[$section_key] : 1;
        }

        return $active_value;
    }

    static function save_settings($submitted_data)
    {

        $sections = Profipaints_Config::get_sections();

        if (is_array($submitted_data)) {
            $data = array();
            foreach ($sections as $k => $s) {
                $data[$k] = isset($submitted_data['section_' . $k]) && $submitted_data['section_' . $k] == 1 ? 1 : false;
            }

            update_option(self::$key, $data);
        }
    }

    static function get_settings()
    {
        return get_option(self::$key);
    }

    static function get_plus_sections()
    {
        $plugin_sections = array(

            'slider' => array(
                'label' => __('Section: Slider', 'profipaints'),
                'title' => __('Slider', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),

            'clients' => array(
                'label' => __('Section: Clients', 'profipaints'),
                'title' => __('Our Clients', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'cta' => array(
                'label' => __('Section: Call to Action', 'profipaints'),
                'title' => __('', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'map' => array(
                'label' => __('Section: Map', 'profipaints'),
                'title' => __('Map', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'pricing' => array(
                'label' => __('Section: Pricing', 'profipaints'),
                'title' => __('Pricing Table', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'projects' => array(
                'label' => __('Section: Projects', 'profipaints'),
                'title' => __('Highlight Projects', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'testimonials' => array(
                'label' => __('Section: Testimonials', 'profipaints'),
                'title' => __('Testimonials', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
        );

        return $plugin_sections;
    }

    /**
     * Get sections
     *
     * @return array
     */
    static function get_sections()
    {

        $sorted_sections = apply_filters('profipaints_frontpage_sections_order', array(
            'about2', 'aboutus', 'features', 'about', 'buy', 'modules', 'videolightbox', 'gallery', 'counter', 'team',  'news', 'form', 'contact'
        ));

        $sections_config = array(
            'hero' => array(
                'label' => __('Section: Hero', 'profipaints'),
                'title' => __('Home', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'about' => array(
                'label' => __('Section: About', 'profipaints'),
                'title' => __('About Us', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'modules' => array(
                'label' => __('Section: Modules', 'profipaints'),
                'title' => __('Modules', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'about2' => array(
                'label' => __('Section: About2', 'profipaints'),
                'title' => __('About Us', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'aboutus' => array(
                'label' => __('Раздел: О компании', 'profipaints'),
                'title' => __('About Us', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'form' => array(
                'label' =>  __('Раздел: Форма', 'profipaints'),
                'title' => __('Get in touch', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'contact' => array(
                'label' =>  __('Section: Contact', 'profipaints'),
                'title' => __('Get in touch', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'counter' => array(
                'label' => __('Section: Counter', 'profipaints'),
                'title' => __('Our Numbers', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'features' => array(
                'label' => __('Section: Features', 'profipaints'),
                'title' => __('Features', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'buy' => array(
                'label' => __('Section: Buy', 'profipaints'),
                'title' => __('Buy Now', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'gallery' => array(
                'label' => __('Section: Gallery', 'profipaints'),
                'title' => __('Gallery', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'news' => array(
                'label' => __('Section: News', 'profipaints'),
                'title' => __('Latest News', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            /*
			'services' => array(
				'label' => __( 'Section: Services', 'profipaints' ),
				'title' => __( 'Our Services', 'profipaints' ),
				'default' => false,
				'inverse' => false,
			),
			*/
            'team' => array(
                'label' => __('Section: Team', 'profipaints'),
                'title' => __('Our Team', 'profipaints'),
                'default' => false,
                'inverse' => false,
            ),
            'videolightbox' => array(
                'label' => __('Section: Video Lightbox', 'profipaints'),
                'title' => '',
                'default' => false,
                'inverse' => false,
            ),
        );

        $new = array(
            'hero' => $sections_config['hero']
        );

        foreach ($sorted_sections as $id) {
            if (isset($sections_config[$id])) {
                $new[$id] = $sections_config[$id];
            }
        }

        // Filter to add more custom sections here
        return apply_filters('profipaints_get_sections', $new);
    }
}
