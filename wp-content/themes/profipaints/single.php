<?php

/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ProfiPaints
 */

get_header();
$layout = profipaints_get_layout();

/**
 * @since 2.0.0
 * @see profipaints_display_page_title
 */
do_action('profipaints_page_before_content');
?>

<div id="content" class="site-content">

    <?php profipaints_breadcrumb(); ?>

    <div id="content-inside" class="container <?php echo esc_attr($layout); ?>">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('template-parts/content', 'single'); ?>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; // End of the loop. 
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ($layout != 'no-sidebar') { ?>
            <?php get_sidebar(); ?>
        <?php } ?>

    </div><!--#content-inside -->
</div><!-- #content -->

<?php get_footer(); ?>