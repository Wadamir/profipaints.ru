<?php

/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ProfiPaints
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php // You can start editing here -- including this comment! 
    ?>

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $n = get_comments_number();
            if (1 === $n) {
                printf(esc_html__('One thought on &ldquo;%2$s&rdquo;', 'profipaints'), '<span>' . get_the_title() . '</span>');
            } else {
                // WPCS: XSS OK.
                printf(
                    /* translators: 1: number of comments, 2: post title */
                    _nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $n,
                        'comments title',
                        'profipaints'
                    ),
                    number_format_i18n($n),
                    '<span>' . get_the_title() . '</span>'
                );
            }

            ?>
        </h3>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
        ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'profipaints'); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments', 'profipaints')); ?></div>
                    <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'profipaints')); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. 
        ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'callback' => 'profipaints_comment',
                )
            );
            ?>
        </ol><!-- .comment-list -->

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
        ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'profipaints'); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments', 'profipaints')); ?></div>
                    <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'profipaints')); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
        <?php endif; // Check for comment navigation. 
        ?>

    <?php endif; // Check for have_comments(). 
    ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'profipaints'); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->