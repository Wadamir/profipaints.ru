<?php
$id       = get_theme_mod('profipaints_features_id', esc_html__('features', 'profipaints'));
$disable  = get_theme_mod('profipaints_features_disable') == 1 ? true : false;
$title    = get_theme_mod('profipaints_features_title', esc_html__('Features', 'profipaints'));
$subtitle = get_theme_mod('profipaints_features_subtitle', esc_html__('Why choose Us', 'profipaints'));
$profipaints_features_tab1_title = get_theme_mod('profipaints_features_tab1_title', esc_html__('Информация о товаре', 'profipaints'));
$profipaints_features_tab2_title = get_theme_mod('profipaints_features_tab2_title', esc_html__('Сертификаты', 'profipaints'));
$profipaints_features_tab3_title = get_theme_mod('profipaints_features_tab3_title', esc_html__('Техничка', 'profipaints'));
$profipaints_modal_id = get_theme_mod('profipaints_features_modal', '');
if (profipaints_is_selective_refresh()) {
    $disable = false;
}
$data  = profipaints_get_features_data();
if (!$disable && !empty($data)) {
    $desc = get_theme_mod('profipaints_features_desc');
?>
    <?php
    foreach ($data as $k => $f) {
        $media = '';
        $f =  wp_parse_args($f, array(
            'icon_type' => 'icon',
            'icon' => 'gg',
            'image' => '',
            'image2' => '',
            'image3' => '',
            'title' => '',
            'subtitle' => '',
            'desc' => '',
            'link'          => '',
            'link__text'    => '',
            'link2'         => '',
            'link2__text'   => '',
            'link3'         => '',
            'link3__text'   => '',
            'link4'         => '',
            'link4__text'   => '',
            'link5'         => '',
            'link5__text'   => '',
            'link6'         => '',
            'link6__text'   => '',
            'link7'         => '',
            'link7__text'   => '',
            'link8'         => '',
            'link8__text'   => '',
            'link9'         => '',
            'link9__text'   => '',
            'link10'        => '',
            'link10__text'  => '',
        ));
        // var_dump($f);
        if ($f['image']) {
            $url = profipaints_get_media_url($f['image']);
            $image_alt = get_post_meta($f['image']['id'], '_wp_attachment_image_alt', true);
            if ($url) {
                $media = '<span class="icon-image"><img src="' . esc_url($url) . '" alt="' . $image_alt . '"></span>';
            }
        }
        if ($f['image2']) {
            $url2 = profipaints_get_media_url($f['image2']);
            $image2_alt = get_post_meta($f['image2']['id'], '_wp_attachment_image_alt', true);
            if ($url2) {
                $media2 = '<span class="icon-image"><img src="' . esc_url($url2) . '" alt="' . $image2_alt . '"></span>';
            } else {
                $media2 = '';
            }
        }
        if ($f['image3']) {
            $url3 = profipaints_get_media_url($f['image3']);
            $image3_alt = get_post_meta($f['image3']['id'], '_wp_attachment_image_alt', true);
            if ($url3) {
                $media3 = '<span class="icon-image"><img src="' . esc_url($url3) . '" alt="' . $image3_alt . '"></span>';
            } else {
                $media3 = '';
            }
        }

        $show_nav_tabs_class = (($f['link'] && $f['link__text']) || ($f['link2'] && $f['link2__text']) || ($f['link3'] && $f['link3__text']) || ($f['link4'] && $f['link4__text']) || ($f['link5'] && $f['link5__text']) || ($f['link6'] && $f['link6__text']) || ($f['link7'] && $f['link7__text']) || ($f['link8'] && $f['link8__text']) || ($f['link9'] && $f['link9__text']) || ($f['link10'] && $f['link10__text']) || ($f['tech_link1'] && $f['tech_link1__text']) || ($f['tech_link2'] && $f['tech_link2__text']) || ($f['tech_link3'] && $f['tech_link3__text']) || ($f['tech_link4'] && $f['tech_link4__text']) || ($f['tech_link5'] && $f['tech_link5__text']) || ($f['tech_link6'] && $f['tech_link6__text']) || ($f['tech_link7'] && $f['tech_link7__text']) || ($f['tech_link8'] && $f['tech_link8__text']) || ($f['tech_link9'] && $f['tech_link9__text']) || ($f['tech_link10'] && $f['tech_link10__text'])) ? '' : ' d-none';
    ?>
        <div class="modal fade" id="feature-item-content-<?php echo $k ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-wide">
                <div class="modal-content modal-content-high">
                    <div class="modal-header">
                        <h3><?php echo esc_html($f['title']); ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1561_14432)">
                                        <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#1B1D21"></path>
                                    </g>
                                    <defs>
                                        <clipPath>
                                            <rect width="24" height="24" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <nav class="nav nav-pills flex-column flex-sm-row<?php echo $show_nav_tabs_class ?>">
                            <button class="nav-link active" id="info-tab-<?php echo $k ?>" data-bs-toggle="tab" data-bs-target="#info-<?php echo $k ?>" type="button" role="tab" aria-controls="info-<?php echo $k ?>" aria-selected="true">
                                <?php echo $profipaints_features_tab1_title; ?>
                            </button>
                            <?php
                            if (($f['link1'] && $f['link1__text']) || ($f['link2'] && $f['link2__text']) || ($f['link3'] && $f['link3__text']) || ($f['link4'] && $f['link4__text']) || ($f['link5'] && $f['link5__text']) || ($f['link6'] && $f['link6__text']) || ($f['link7'] && $f['link7__text']) || ($f['link8'] && $f['link8__text']) || ($f['link9'] && $f['link9__text']) || ($f['link10'] && $f['link10__text'])) {
                            ?>
                                <button class="nav-link" id="certification-tab-<?php echo $k ?>" data-bs-toggle="tab" data-bs-target="#certification-<?php echo $k ?>" type="button" role="tab" aria-controls="certification-<?php echo $k ?>" aria-selected="false">
                                    <?php echo $profipaints_features_tab2_title; ?>
                                </button>
                            <?php
                            }
                            ?>
                            <?php
                            if (($f['tech_link1'] && $f['tech_link1__text']) || ($f['tech_link2'] && $f['tech_link2__text']) || ($f['tech_link3'] && $f['tech_link3__text']) || ($f['tech_link4'] && $f['tech_link4__text']) || ($f['tech_link5'] && $f['tech_link5__text']) || ($f['tech_link6'] && $f['tech_link6__text']) || ($f['tech_link7'] && $f['tech_link7__text']) || ($f['tech_link8'] && $f['tech_link8__text']) || ($f['tech_link9'] && $f['tech_link9__text']) || ($f['tech_link10'] && $f['tech_link10__text'])) {
                            ?>
                                <button class="nav-link" id="tech-tab-<?php echo $k ?>" data-bs-toggle="tab" data-bs-target="#tech-<?php echo $k ?>" type="button" role="tab" aria-controls="tech-<?php echo $k ?>" aria-selected="false">
                                    <?php echo $profipaints_features_tab3_title; ?>
                                </button>
                            <?php
                            }
                            ?>
                        </nav>
                        <div class="feature-item footer-feature-item">
                            <div class="row">
                                <div class="feature-media col-12 col-md-4">
                                    <div class="feature-image product-carousel owl-theme owl-carousel owl-hidden">
                                        <?php echo $media; ?>
                                        <?php echo ($f['image2']) ? $media2 : ''; ?>
                                        <?php echo ($f['image3']) ? $media3 : ''; ?>
                                    </div>
                                </div>
                                <div class="feature-inner-content col-12 col-md-8">
                                    <div class="tab-content" id="myTabContent-<?php echo $k ?>">
                                        <div class="tab-pane fade show active" id="info-<?php echo $k ?>" role="tabpanel" aria-labelledby="info-tab-<?php echo $k ?>">
                                            <p class="subtitle h5 mb-2"><?php echo esc_html($f['subtitle']); ?></p>
                                            <?php echo apply_filters('the_content', $f['desc']); ?>
                                            <?php
                                            if ($profipaints_modal_id !== '') {
                                                echo '<p class="text-center"><a href="#" class="btn btn-medium btn-secondary" data-bs-toggle="modal" data-bs-target="#' . esc_attr($profipaints_modal_id) . '">' . esc_html__('Заказать', 'profipaints') . '</a></p>';
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (($f['link'] && $f['link__text']) || ($f['link2'] && $f['link2__text']) || ($f['link3'] && $f['link3__text']) || ($f['link4'] && $f['link4__text']) || ($f['link5'] && $f['link5__text']) || ($f['link6'] && $f['link6__text']) || ($f['link7'] && $f['link7__text']) || ($f['link8'] && $f['link8__text']) || ($f['link9'] && $f['link9__text']) || ($f['link10'] && $f['link10__text'])) {
                                        ?>
                                            <div class="tab-pane fade" id="certification-<?php echo $k ?>" role="tabpanel" aria-labelledby="certification-tab-<?php echo $k ?>">
                                                <ul class="push">
                                                    <?php
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        $link = 'link' . $i;
                                                        $link_text = 'link' . $i . '__text';
                                                        if (empty($f[$link]) || empty($f[$link_text])) {
                                                            continue;
                                                        }
                                                        if (empty($f[$link]) || empty($f[$link_text])) {
                                                            continue;
                                                        }
                                                    ?>
                                                        <li>
                                                            <a href=" <?php echo esc_url($f[$link]); ?>" target="_blank"><?php echo esc_html($f[$link_text]); ?></a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (($f['tech_link1'] && $f['tech_link1__text']) || ($f['tech_link2'] && $f['tech_link2__text']) || ($f['tech_link3'] && $f['tech_link3__text']) || ($f['tech_link4'] && $f['tech_link4__text']) || ($f['tech_link5'] && $f['tech_link5__text']) || ($f['tech_link6'] && $f['tech_link6__text']) || ($f['tech_link7'] && $f['tech_link7__text']) || ($f['tech_link8'] && $f['tech_link8__text']) || ($f['tech_link9'] && $f['tech_link9__text']) || ($f['tech_link10'] && $f['tech_link10__text'])) {
                                        ?>
                                            <div class="tab-pane fade" id="tech-<?php echo $k ?>" role="tabpanel" aria-labelledby="tech-tab-<?php echo $k ?>">
                                                <ul class="push">
                                                    <?php
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        $link = 'tech_link' . $i;
                                                        $link_text = 'tech_link' . $i . '__text';
                                                        if (empty($f[$link]) || empty($f[$link_text])) {
                                                            continue;
                                                        }
                                                        if (empty($f[$link]) || empty($f[$link_text])) {
                                                            continue;
                                                        }
                                                    ?>
                                                        <li>
                                                            <a href=" <?php echo esc_url($f[$link]); ?>" target="_blank"><?php echo esc_html($f[$link_text]); ?></a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } // end loop features
    ?>
<?php } ?>