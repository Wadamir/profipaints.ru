<?php

/**
 *Template Name: Frontpage
 *
 * @package ProfiPaints
 */

get_header(); ?>

<div id="content" class="site-content">
    <main id="main" class="site-main" role="main">
        <?php

        do_action('profipaints_frontpage_before_section_parts');

        if (!has_action('profipaints_frontpage_section_parts')) {

            $sections = apply_filters('profipaints_frontpage_sections_order', array(
                'about2', 'aboutus',  'features',  'about', 'buy', 'modules', 'videolightbox', 'gallery', 'counter', 'team',  'news', 'form', 'contact'
            ));

            foreach ($sections as $section) {
                /**
                 * Load section if active
                 *
                 * @since 2.1.1
                 */
                if (Profipaints_Config::is_section_active($section)) {
                    profipaints_load_section($section);
                }
            }
        } else {
            do_action('profipaints_frontpage_section_parts');
        }

        do_action('profipaints_frontpage_after_section_parts');

        ?>
    </main><!-- #main -->
</div><!-- #content -->

<?php get_footer(); ?>