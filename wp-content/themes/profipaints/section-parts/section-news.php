<?php
$id        = get_theme_mod('profipaints_news_id', esc_html__('news', 'profipaints'));
$disable   = get_theme_mod('profipaints_news_disable') == 1 ? true : false;
$meta_class = get_theme_mod('profipaints_news_meta') == 1 ? 'profipaints-meta' : '';
$section_classes = esc_attr(apply_filters('profipaints_section_class', "section-news section-padding onepage-section {$meta_class}", 'news'));

if (profipaints_is_selective_refresh()) {
    $disable = false;
}

if (!$disable) :

    $title     = get_theme_mod('profipaints_news_title', esc_html__('Latest News', 'profipaints'));
    $subtitle  = get_theme_mod('profipaints_news_subtitle', esc_html__('Section subtitle', 'profipaints'));
    $number    = absint(get_theme_mod('profipaints_news_number', '3'));
    $more_page = get_theme_mod('profipaints_news_more_page', '');
    $more_link = get_theme_mod('profipaints_news_more_link', '');
    $more_text = get_theme_mod('profipaints_news_more_text', esc_html__('Read Our Blog', 'profipaints'));
    $desc = get_theme_mod('profipaints_news_desc');

?>
    <?php if (!profipaints_is_selective_refresh()) { ?>
        <section id="<?php echo ($id !== '') ? esc_attr($id) : 'news'; ?>" <?php do_action('profipaints_section_atts', 'news'); ?> class="<?php echo $section_classes; ?>">
        <?php } ?>
        <?php do_action('profipaints_section_before_inner', 'news'); ?>
        <div class="<?php echo esc_attr(apply_filters('profipaints_section_container_class', 'container', 'news')); ?>">
            <?php if ($title || $subtitle || $desc) { ?>
                <div class="section-title-area">
                    <?php if ($subtitle != '') {
                        echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>';
                    } ?>
                    <?php if ($title != '') {
                        echo '<h2 class="section-title">' . esc_html($title) . '</h2>';
                    } ?>
                    <?php if ($desc) {
                        echo '<div class="section-desc">' . apply_filters('profipaints_the_content', wp_kses_post($desc)) . '</div>';
                    } ?>
                </div>
            <?php } ?>
            <div class="section-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="blog-entry wow slideInUp">
                            <?php

                            $cat = absint(get_theme_mod('profipaints_news_cat'));
                            $orderby = sanitize_text_field(get_theme_mod('profipaints_news_orderby'));
                            $order = sanitize_text_field(get_theme_mod('profipaints_news_order'));
                            $hide_meta = sanitize_text_field(get_theme_mod('profipaints_news_hide_meta'), false);
                            $excerpt_length = absint(get_theme_mod('profipaints_news_excerpt_length'));
                            $excerpt_type = get_theme_mod('profipaints_news_excerpt_type', 'custom');
                            if ($hide_meta) {
                                profipaints_loop_set_prop('show_meta', false);
                            }

                            profipaints_loop_set_prop('excerpt_length', $excerpt_length);
                            profipaints_loop_set_prop('excerpt_type', $excerpt_type);

                            $args = array(
                                'posts_per_page' => $number,
                                'suppress_filters' => 0,
                            );
                            if ($cat > 0) {
                                $args['category__in'] = array($cat);
                            }

                            if ($orderby && $orderby != 'default') {
                                $args['orderby'] = $orderby;
                            }

                            if ($order) {
                                $args['order'] = $order;
                            }

                            $query = new WP_Query($args);

                            ?>
                            <?php if ($query->have_posts()) : ?>

                                <?php /* Start the Loop */ ?>
                                <?php while ($query->have_posts()) :
                                    $query->the_post(); ?>
                                    <?php
                                    /*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
                                    get_template_part('template-parts/content', 'list');
                                    ?>

                                <?php endwhile; ?>
                            <?php else : ?>
                                <?php get_template_part('template-parts/content', 'none'); ?>
                            <?php endif;


                            if ($hide_meta) {
                                profipaints_loop_remove_prop('show_meta');
                            }

                            profipaints_loop_remove_prop('excerpt_length');
                            profipaints_loop_remove_prop('excerpt_type');

                            $link = '';
                            $label = '';

                            if ($more_page) {
                                $page = get_post($more_page);
                                if ($page) {
                                    $link = get_permalink($page);
                                    if (!$more_text) {
                                        $label = $page->post_title;
                                    }
                                }
                            }

                            if (!$link) {
                                $link = $more_link;
                            }

                            if (!$label) {
                                $label = $more_text;
                            }

                            if ($link != '' && $label != '') {
                            ?>
                                <div class="all-news">
                                    <a class="btn btn-theme-primary-outline" href="<?php echo esc_url($link); ?>"><?php echo esc_html($label); ?></a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php do_action('profipaints_section_after_inner', 'news'); ?>
        <?php if (!profipaints_is_selective_refresh()) { ?>
        </section>
    <?php } ?>
<?php endif;
wp_reset_postdata();
