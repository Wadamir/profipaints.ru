<?php

class Profipaints_Dashboard
{

    private static $_instance = null;

    static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function init()
    {
        add_action('switch_theme', array($this, 'reset_recommended_actions'));

        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
            add_action('admin_menu', array($this, 'theme_info'));
            /* activation notice */
            add_action('load-themes.php',  array($this, 'activation_admin_notice'));
            add_action('admin_init', array($this, 'admin_dismiss_actions'));
        }
    }

    function reset_recommended_actions()
    {
        delete_option('profipaints_actions_dismiss');
    }

    /**
     * Add theme dashboard page
     */
    /**
     * Check maybe show admin notice
     * @since 2.0.8
     */
    function maybe_show_switch_theme_notice()
    {
        if (get_option('profipaints_dismiss_switch_theme_notice')) {
            return false;
        }
        $keys = array(
            'profipaints_hcl1_largetext',
            'profipaints_hcl1_smalltext',
            'profipaints_hcl2_content',
            'profipaints_features_boxes',
            // 'profipaints_services',
            'profipaints_videolightbox_title',
            'profipaints_gallery_source',
            'profipaints_team_members',
            'profipaints_contact_text',
            'profipaints_contact_address',
        );

        foreach ($keys as $k) {
            if (get_theme_mod($k)) {
                return false;
            }
        }

        return true;
    }


    /**
     * Enqueue scripts for admin page only: Theme info page
     */
    function admin_scripts($hook)
    {
        if ($hook === 'widgets.php' || $hook === 'appearance_page_ft_profipaints') {
            wp_enqueue_style('profipaints-admin-css', get_template_directory_uri() . '/assets/css/admin.css');
            // Add recommend plugin css
            wp_enqueue_style('plugin-install');
            wp_enqueue_script('plugin-install');
            wp_enqueue_script('updates');
            add_thickbox();
        }
    }

    function theme_info()
    {
        $actions = $this->get_recommended_actions();
        $number_count = $actions['number_notice'];

        if ($number_count > 0) {
            $update_label = sprintf(_n('%1$s action required', '%1$s actions required', $number_count, 'profipaints'), $number_count);
            $count = "<span class='update-plugins count-" . esc_attr($number_count) . "' title='" . esc_attr($update_label) . "'><span class='update-count'>" . number_format_i18n($number_count) . "</span></span>";
            $menu_title = sprintf(esc_html__('ProfiPaints Theme %s', 'profipaints'), $count);
        } else {
            $menu_title = esc_html__('ProfiPaints Theme', 'profipaints');
        }

        add_theme_page(esc_html__('ProfiPaints Dashboard', 'profipaints'), $menu_title, 'edit_theme_options', 'ft_profipaints', array($this, 'theme_info_page'));
    }

    /**
     * Add admin notice when active theme, just show one timetruongsa@200811
     *
     * @return bool|null
     */
    function admin_notice()
    {

        $actions = $this->get_recommended_actions();
        $number_action = $actions['number_notice'];

        if ($number_action > 0) {
            $theme_data = wp_get_theme();
?>
            <div class="updated notice notice-success notice-alt is-dismissible">
                <p><?php printf(__('Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'profipaints'),  $theme_data->Name, admin_url('themes.php?page=ft_profipaints')); ?></p>
            </div>
        <?php
        }
    }

    function admin_import_notice()
    {
        ?>
        <div class="updated notice notice-success notice-alt is-dismissible">
            <p><?php printf(esc_html__('Save time by import our demo data, your website will be set up and ready to customize in minutes. %s', 'profipaints'), '<a class="button button-secondary" href="' . esc_url(add_query_arg(array('page' => 'ft_profipaints&tab=demo-data-importer'), admin_url('themes.php'))) . '">' . esc_html__('Import Demo Data', 'profipaints') . '</a>'); ?></p>
        </div>
    <?php
    }

    function activation_admin_notice()
    {
        global $pagenow;
        if (is_admin() && ('themes.php' == $pagenow) && isset($_GET['activated'])) {
            add_action('admin_notices', array($this, 'admin_notice'));
            add_action('admin_notices', array($this, 'admin_import_notice'));
        }
    }

    function render_section_settings($key, $section, $see_only = false)
    {
        $active_value = Profipaints_Config::is_section_active($key) ? 1 : false;
    ?>
        <div class="profipaints-admin-section <?php echo $see_only ? 'see-only' : ''; ?>">
            <div class="profipaints-admin-section-inner">
                <div class="admin-section-header">
                    <label>
                        <?php if (!$see_only) { ?>
                            <span class="switch-button">
                                <input <?php checked($active_value, 1); ?> name="section_<?php echo esc_attr($key); ?>" value="1" type="checkbox">
                                <span class="switch-slider"></span>
                            </span>
                        <?php } ?>
                        <?php echo $section['label']; // WPCS: XSS OK. 
                        ?>
                    </label>
                    <?php if ($see_only) { ?>
                        <span class="note-bubble"><?php _e('Plus Feature', 'profipaints'); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Section settings
     *
     * @since 2.1.1
     */
    function sections_settings()
    {
        $sections = Profipaints_Config::get_sections();

        if (isset($_POST['submit'])) {
            Profipaints_Config::save_settings($_POST);
        ?>
            <div id="sections-manager-notice" class="updated notice notice-success is-dismissible">
                <p><?php _e('Settings saved', 'profipaints'); ?></p>
            </div>
        <?php
        }

        echo '<div class="profipaints-admin-sections-wrapper">';
        echo '<h3>' . __('Customizer Section Manager', 'profipaints') . '</h3>';
        echo '<p class="description">' . __('Disable (or enable) unused sections to improve Customizer loading speed. Your section settings is still saved.', 'profipaints') . '</p>';

        echo '<form method="post" action="?page=ft_profipaints" class="profipaints-admin-sections-form">';
        echo '<div class="profipaints-admin-sections">';
        foreach ($sections as $key => $section) {
            $this->render_section_settings($key, $section);
        }

        if (!class_exists('ProfiPaints_Plus')) {
            foreach (Profipaints_Config::get_plus_sections() as $key => $section) {
                $this->render_section_settings($key, $section, true);
            }
        }

        echo '</div>';
        submit_button();
        echo '</form>';
        echo '</div>';
    }

    function theme_info_page()
    {

        $theme_data = wp_get_theme('profipaints');

        if (isset($_GET['profipaints_action_dismiss'])) {
            $actions_dismiss =  get_option('profipaints_actions_dismiss');
            if (!is_array($actions_dismiss)) {
                $actions_dismiss = array();
            }
            $actions_dismiss[sanitize_text_field($_GET['profipaints_action_dismiss'])] = 'dismiss';
            update_option('profipaints_actions_dismiss', $actions_dismiss);
        }

        // Check for current viewing tab
        $tab = null;
        if (isset($_GET['tab'])) {
            $tab = sanitize_text_field($_GET['tab']);
        } else {
            $tab = null;
        }

        $actions_r = $this->get_recommended_actions();
        $number_action = $actions_r['number_notice'];
        $actions = $actions_r['actions'];

        $current_action_link =  admin_url('themes.php?page=ft_profipaints&tab=recommended_actions');

        $recommend_plugins = get_theme_support('recommend-plugins');
        if (is_array($recommend_plugins) && isset($recommend_plugins[0])) {
            $recommend_plugins = $recommend_plugins[0];
        } else {
            $recommend_plugins[] = array();
        }
        ?>
        <div class="wrap about-wrap theme_info_wrapper">
            <h1><?php printf(esc_html__('Welcome to ProfiPaints - Version %1s', 'profipaints'), $theme_data->Version); ?></h1>
            <div class="about-text"><?php esc_html_e('ProfiPaints is a creative and flexible WordPress ONE PAGE theme well suited for business, portfolio, digital agency, product showcase, freelancers websites.', 'profipaints'); ?></div>
            <a target="_blank" href="<?php echo esc_url('https://www.famethemes.com/?utm_source=theme_dashboard_page&utm_medium=badge_link&utm_campaign=profipaints'); ?>" class="famethemes-badge wp-badge"><span>FameThemes</span></a>

            <hr class="wp-header-end">

            <h2 class="nav-tab-wrapper">
                <a href="?page=ft_profipaints" class="nav-tab<?php echo is_null($tab) ? ' nav-tab-active' : null; ?>"><?php esc_html_e('Overview', 'profipaints') ?></a>
                <a href="?page=ft_profipaints&tab=recommended_actions" class="nav-tab<?php echo $tab == 'recommended_actions' ? ' nav-tab-active' : null; ?>"><?php esc_html_e('Recommended Actions', 'profipaints');
                                                                                                                                                                echo ($number_action > 0) ? "<span class='theme-action-count'>{$number_action}</span>" : ''; ?></a>
                <?php if (!class_exists('ProfiPaints_Plus')) { ?>
                    <a href="?page=ft_profipaints&tab=free_pro" class="nav-tab<?php echo $tab == 'free_pro' ? ' nav-tab-active' : null; ?>"><?php esc_html_e('Free vs PLUS', 'profipaints'); ?></span></a>
                <?php } ?>
                <a href="?page=ft_profipaints&tab=demo-data-importer" class="nav-tab<?php echo $tab == 'demo-data-importer' ? ' nav-tab-active' : null; ?>"><?php esc_html_e('Demo Import', 'profipaints'); ?></span></a>
                <?php do_action('profipaints_admin_more_tabs', $tab); ?>
            </h2>

            <?php if (is_null($tab)) { ?>
                <div class="theme_info info-tab-content">
                    <div class="theme_info_column clearfix">
                        <div class="theme_info_left">
                            <?php
                            $this->sections_settings();
                            ?>
                        </div>

                        <div class="theme_info_right">
                            <div class="theme_link">
                                <h3><?php esc_html_e('Theme Customizer', 'profipaints'); ?></h3>
                                <p class="about"><?php printf(esc_html__('%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'profipaints'), $theme_data->Name); ?></p>
                                <p>
                                    <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php esc_html_e('Start Customize', 'profipaints'); ?></a>
                                </p>
                            </div>
                            <div class="theme_link">
                                <h3><?php esc_html_e('Theme Documentation', 'profipaints'); ?></h3>
                                <p class="about"><?php printf(esc_html__('Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'profipaints'), $theme_data->Name); ?></p>
                                <p>
                                    <a href="<?php echo esc_url('http://docs.famethemes.com/category/112-profipaints'); ?>" target="_blank" class="button button-secondary"><?php esc_html_e('ProfiPaints Documentation', 'profipaints'); ?></a>
                                </p>
                                <?php do_action('profipaints_dashboard_theme_links'); ?>
                            </div>
                            <div class="theme_link">
                                <h3><?php esc_html_e('Having Trouble, Need Support?', 'profipaints'); ?></h3>
                                <p class="about"><?php printf(esc_html__('Support for %s WordPress theme is conducted through FameThemes support ticket system.', 'profipaints'), $theme_data->Name); ?></p>
                                <p>
                                    <a href="<?php echo esc_url('https://www.famethemes.com/dashboard/tickets/'); ?>" target="_blank" class="button button-secondary"><?php echo sprintf(esc_html__('Create a support ticket', 'profipaints'), $theme_data->Name); ?></a>
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            <?php } ?>

            <?php if ($tab == 'recommended_actions') { ?>
                <div class="action-required-tab info-tab-content">

                    <?php if (is_child_theme()) {
                        $child_theme = wp_get_theme();
                    ?>
                        <form method="post" action="<?php echo esc_attr($current_action_link); ?>" class="demo-import-boxed copy-settings-form">
                            <p>
                                <strong> <?php printf(esc_html__('You\'re using %1$s theme, It\'s a child theme of ProfiPaints', 'profipaints'),  $child_theme->Name); ?></strong>
                            </p>
                            <p><?php printf(esc_html__("Child theme uses it's own theme setting name, would you like to copy setting data from parent theme to this child theme?", 'profipaints')); ?></p>
                            <p>
                                <?php

                                $select = '<select name="copy_from">';
                                $select .= '<option value="">' . esc_html__('From Theme', 'profipaints') . '</option>';
                                $select .= '<option value="profipaints">ProfiPaints</option>';
                                $select .= '<option value="' . esc_attr($child_theme->get_stylesheet()) . '">' . ($child_theme->Name) . '</option>';
                                $select .= '</select>';

                                $select_2 = '<select name="copy_to">';
                                $select_2 .= '<option value="">' . esc_html__('To Theme', 'profipaints') . '</option>';
                                $select_2 .= '<option value="profipaints">ProfiPaints</option>';
                                $select_2 .= '<option value="' . esc_attr($child_theme->get_stylesheet()) . '">' . ($child_theme->Name) . '</option>';
                                $select_2 .= '</select>';

                                echo $select . ' to ' . $select_2;

                                ?>
                                <input type="submit" class="button button-secondary" value="<?php esc_attr_e('Copy now', 'profipaints'); ?>">
                            </p>
                            <?php if (isset($_GET['copied']) && $_GET['copied'] == 1) { ?>
                                <p><?php esc_html_e('Your settings were copied.', 'profipaints'); ?></p>
                            <?php } ?>
                        </form>

                    <?php } ?>
                    <?php if ($actions_r['number_active']  > 0) { ?>
                        <?php $actions = wp_parse_args($actions, array('page_on_front' => '', 'page_template')) ?>

                        <?php if ($actions['recommend_plugins'] == 'active') {  ?>
                            <div id="plugin-filter" class="recommend-plugins action-required">
                                <a title="" class="dismiss" href="<?php echo add_query_arg(array('profipaints_action_notice' => 'recommend_plugins'), $current_action_link); ?>">
                                    <?php if ($actions_r['hide_by_click']['recommend_plugins'] == 'hide') { ?>
                                        <span class="dashicons dashicons-hidden"></span>
                                    <?php } else { ?>
                                        <span class="dashicons  dashicons-visibility"></span>
                                    <?php } ?>
                                </a>
                                <h3><?php esc_html_e('Recommend Plugins', 'profipaints'); ?></h3>
                                <?php
                                $this->render_recommend_plugins($recommend_plugins);
                                ?>
                            </div>
                        <?php } ?>


                        <?php if ($actions['page_on_front'] == 'active') {  ?>
                            <div class="theme_link  action-required">
                                <a title="<?php esc_attr_e('Dismiss', 'profipaints'); ?>" class="dismiss" href="<?php echo add_query_arg(array('profipaints_action_notice' => 'page_on_front'), $current_action_link); ?>">
                                    <?php if ($actions_r['hide_by_click']['page_on_front'] == 'hide') { ?>
                                        <span class="dashicons dashicons-hidden"></span>
                                    <?php } else { ?>
                                        <span class="dashicons  dashicons-visibility"></span>
                                    <?php } ?>
                                </a>
                                <h3><?php esc_html_e('Switch "Front page displays" to "A static page"', 'profipaints'); ?></h3>
                                <div class="about">
                                    <p><?php _e('In order to have the one page look for your website, please go to Customize -&gt; Static Front Page and switch "Front page displays" to "A static page".', 'profipaints'); ?></p>
                                </div>
                                <p>
                                    <a href="<?php echo admin_url('options-reading.php'); ?>" class="button"><?php esc_html_e('Setup front page displays', 'profipaints'); ?></a>
                                </p>
                            </div>
                        <?php } ?>

                        <?php if ($actions['page_template'] == 'active') {  ?>
                            <div class="theme_link  action-required">
                                <a title="<?php esc_attr_e('Dismiss', 'profipaints'); ?>" class="dismiss" href="<?php echo add_query_arg(array('profipaints_action_notice' => 'page_template'), $current_action_link); ?>">
                                    <?php if ($actions_r['hide_by_click']['page_template'] == 'hide') { ?>
                                        <span class="dashicons dashicons-hidden"></span>
                                    <?php } else { ?>
                                        <span class="dashicons  dashicons-visibility"></span>
                                    <?php } ?>
                                </a>
                                <h3><?php esc_html_e('Set your homepage page template to "Frontpage".', 'profipaints'); ?></h3>

                                <div class="about">
                                    <p><?php esc_html_e('In order to change homepage section contents, you will need to set template "Frontpage" for your homepage.', 'profipaints'); ?></p>
                                </div>
                                <p>
                                    <?php
                                    $front_page = get_option('page_on_front');
                                    if ($front_page <= 0) {
                                    ?>
                                        <a href="<?php echo admin_url('options-reading.php'); ?>" class="button"><?php esc_html_e('Setup front page displays', 'profipaints'); ?></a>
                                    <?php

                                    }

                                    if ($front_page > 0 && get_post_meta($front_page, '_wp_page_template', true) != 'template-frontpage.php') {
                                    ?>
                                        <a href="<?php echo get_edit_post_link($front_page); ?>" class="button"><?php esc_html_e('Change homepage page template', 'profipaints'); ?></a>
                                    <?php
                                    }
                                    ?>
                                </p>
                            </div>
                        <?php } ?>
                        <?php do_action('profipaints_more_required_details', $actions); ?>
                    <?php  } else { ?>
                        <h3><?php printf(__('Keep %s updated', 'profipaints'), $theme_data->Name); ?></h3>
                        <p><?php _e('Hooray! There are no required actions for you right now.', 'profipaints'); ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!class_exists('ProfiPaints_Plus')) { ?>
                <?php if ($tab == 'free_pro') { ?>
                    <div id="free_pro" class="freepro-tab-content info-tab-content">
                        <table class="free-pro-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ProfiPaints</th>
                                    <th>ProfiPaints Plus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h4>WooCommerce Support</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <h4>Hero Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Full Screen</h5>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <h5>- Background Video</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Background Slides</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before ">2</span></td>
                                    <td class="only-lite"><span class="dashicons-before">Unlimited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>About Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Number of items</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before ">3</span></td>
                                    <td class="only-lite"><span class="dashicons-before">Unlimited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Service Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Number of items</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before ">4</span></td>
                                    <td class="only-lite"><span class="dashicons-before">Unlimited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Counter Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Number of counter items</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before ">4</span></td>
                                    <td class="only-lite"><span class="dashicons-before">Unlimited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Team Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>- Number of members</h5>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before ">4</span></td>
                                    <td class="only-lite"><span class="dashicons-before">Unlimited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Latest News Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Contact Section</h4>
                                    </td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Drag and drop section orders</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Add New Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Styling for all sections</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Google Map Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Pricing Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Testimonial Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Call To Action Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Projects Section</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>Typography Options</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <h4>Footer Copyright Editor</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4>24/7 Priority Support</h4>
                                    </td>
                                    <td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>
                                    <td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if ($tab == 'demo-data-importer') { ?>
                <div class="demo-import-tab-content info-tab-content">
                    <?php if (has_action('profipaints_demo_import_content_tab')) {
                        do_action('profipaints_demo_import_content_tab');
                    } else { ?>
                        <div id="plugin-filter" class="demo-import-boxed">
                            <?php
                            $plugin_name = 'famethemes-demo-importer';
                            $status = is_dir(WP_PLUGIN_DIR . '/' . $plugin_name);
                            $button_class = 'install-now button';
                            $button_txt = esc_html__('Install Now', 'profipaints');
                            if (!$status) {
                                $install_url = wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'install-plugin',
                                            'plugin' => $plugin_name
                                        ),
                                        network_admin_url('update.php')
                                    ),
                                    'install-plugin_' . $plugin_name
                                );
                            } else {
                                $install_url = add_query_arg(array(
                                    'action' => 'activate',
                                    'plugin' => rawurlencode($plugin_name . '/' . $plugin_name . '.php'),
                                    'plugin_status' => 'all',
                                    'paged' => '1',
                                    '_wpnonce' => wp_create_nonce('activate-plugin_' . $plugin_name . '/' . $plugin_name . '.php'),
                                ), network_admin_url('plugins.php'));
                                $button_class = 'activate-now button-primary';
                                $button_txt = esc_html__('Active Now', 'profipaints');
                            }

                            $detail_link = add_query_arg(
                                array(
                                    'tab' => 'plugin-information',
                                    'plugin' => $plugin_name,
                                    'TB_iframe' => 'true',
                                    'width' => '772',
                                    'height' => '349',

                                ),
                                network_admin_url('plugin-install.php')
                            );

                            echo '<p>';
                            printf(
                                esc_html__(
                                    '%1$s you will need to install and activate the %2$s plugin first.',
                                    'profipaints'
                                ),
                                '<b>' . esc_html__('Hey.', 'profipaints') . '</b>',
                                '<a class="thickbox open-plugin-details-modal" href="' . esc_url($detail_link) . '">' . esc_html__('FameThemes Demo Importer', 'profipaints') . '</a>'
                            );
                            echo '</p>';

                            echo '<p class="plugin-card-' . esc_attr($plugin_name) . '"><a href="' . esc_url($install_url) . '" data-slug="' . esc_attr($plugin_name) . '" class="' . esc_attr($button_class) . '">' . $button_txt . '</a></p>';

                            ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php do_action('profipaints_more_tabs_details', $actions); ?>

        </div> <!-- END .theme_info -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('body').addClass('about-php');

                $('.copy-settings-form').on('submit', function() {
                    var c = confirm('<?php echo esc_attr_e('Are you sure want to copy ?', 'profipaints'); ?>');
                    if (!c) {
                        return false;
                    }
                });
            });
        </script>
<?php
    }

    function render_recommend_plugins($recommend_plugins = array())
    {
        foreach ($recommend_plugins as $plugin_slug => $plugin_info) {
            $plugin_info = wp_parse_args($plugin_info, array(
                'name' => '',
                'active_filename' => '',
            ));
            $plugin_name = $plugin_info['name'];
            $status = is_dir(WP_PLUGIN_DIR . '/' . $plugin_slug);
            $button_class = 'install-now button';
            if ($plugin_info['active_filename']) {
                $active_file_name = $plugin_info['active_filename'];
            } else {
                $active_file_name = $plugin_slug . '/' . $plugin_slug . '.php';
            }

            if (!is_plugin_active($active_file_name)) {
                $button_txt = esc_html__('Install Now', 'profipaints');
                if (!$status) {
                    $install_url = wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'install-plugin',
                                'plugin' => $plugin_slug
                            ),
                            network_admin_url('update.php')
                        ),
                        'install-plugin_' . $plugin_slug
                    );
                } else {
                    $install_url = add_query_arg(array(
                        'action' => 'activate',
                        'plugin' => rawurlencode($active_file_name),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('activate-plugin_' . $active_file_name),
                    ), network_admin_url('plugins.php'));
                    $button_class = 'activate-now button-primary';
                    $button_txt = esc_html__('Active Now', 'profipaints');
                }

                $detail_link = add_query_arg(
                    array(
                        'tab' => 'plugin-information',
                        'plugin' => $plugin_slug,
                        'TB_iframe' => 'true',
                        'width' => '772',
                        'height' => '349',

                    ),
                    network_admin_url('plugin-install.php')
                );

                echo '<div class="rcp">';
                echo '<h4 class="rcp-name">';
                echo esc_html($plugin_name);
                echo '</h4>';
                echo '<p class="action-btn plugin-card-' . esc_attr($plugin_slug) . '"><a href="' . esc_url($install_url) . '" data-slug="' . esc_attr($plugin_slug) . '" class="' . esc_attr($button_class) . '">' . $button_txt . '</a></p>';
                echo '<a class="plugin-detail thickbox open-plugin-details-modal" href="' . esc_url($detail_link) . '">' . esc_html__('Details', 'profipaints') . '</a>';
                echo '</div>';
            }
        }
    }

    function admin_dismiss_actions()
    {
        // Action for dismiss
        if (isset($_GET['profipaints_action_notice'])) {
            $actions_dismiss =  get_option('profipaints_actions_dismiss');
            if (!is_array($actions_dismiss)) {
                $actions_dismiss = array();
            }
            $action_key = sanitize_text_field($_GET['profipaints_action_notice']);
            if (isset($actions_dismiss[$action_key]) &&  $actions_dismiss[$action_key] == 'hide') {
                $actions_dismiss[$action_key] = 'show';
            } else {
                $actions_dismiss[$action_key] = 'hide';
            }
            update_option('profipaints_actions_dismiss', $actions_dismiss);
            $url = wp_unslash($_SERVER['REQUEST_URI']);
            $url = remove_query_arg('profipaints_action_notice', $url);
            wp_redirect($url);
            die();
        }

        // Action for copy options
        if (isset($_POST['copy_from']) && isset($_POST['copy_to'])) {
            $from = sanitize_text_field($_POST['copy_from']);
            $to = sanitize_text_field($_POST['copy_to']);
            if ($from && $to) {
                $mods = get_option("theme_mods_" . $from);
                update_option("theme_mods_" . $to, $mods);

                $url = wp_unslash($_SERVER['REQUEST_URI']);
                $url = add_query_arg(array('copied' => 1), $url);
                wp_redirect($url);
                die();
            }
        }
    }

    /**
     * Get theme actions required
     *
     * @return array|mixed|void
     */
    function get_recommended_actions()
    {

        $actions = array();
        $front_page = get_option('page_on_front');
        $actions['page_on_front'] = 'dismiss';
        $actions['page_template'] = 'dismiss';
        $actions['recommend_plugins'] = 'dismiss';
        if ('page' != get_option('show_on_front')) {
            $front_page = 0;
        }
        if ($front_page <= 0) {
            $actions['page_on_front'] = 'active';
            $actions['page_template'] = 'active';
        } else {
            if (get_post_meta($front_page, '_wp_page_template', true) == 'template-frontpage.php') {
                $actions['page_template'] = 'dismiss';
            } else {
                $actions['page_template'] = 'active';
            }
        }

        $recommend_plugins = get_theme_support('recommend-plugins');
        if (is_array($recommend_plugins) && isset($recommend_plugins[0])) {
            $recommend_plugins = $recommend_plugins[0];
        } else {
            $recommend_plugins[] = array();
        }

        if (!empty($recommend_plugins)) {

            foreach ($recommend_plugins as $plugin_slug => $plugin_info) {
                $plugin_info = wp_parse_args($plugin_info, array(
                    'name' => '',
                    'active_filename' => '',
                ));
                if ($plugin_info['active_filename']) {
                    $active_file_name = $plugin_info['active_filename'];
                } else {
                    $active_file_name = $plugin_slug . '/' . $plugin_slug . '.php';
                }
                if (!is_plugin_active($active_file_name)) {
                    $actions['recommend_plugins'] = 'active';
                }
            }
        }

        $actions = apply_filters('profipaints_get_recommended_actions', $actions);

        $hide_by_click = get_option('profipaints_actions_dismiss');
        if (!is_array($hide_by_click)) {
            $hide_by_click = array();
        }

        $n_active  = $n_dismiss = 0;
        $number_notice = 0;
        foreach ($actions as $k => $v) {
            if (!isset($hide_by_click[$k])) {
                $hide_by_click[$k] = false;
            }

            if ($v == 'active') {
                $n_active++;
                $number_notice++;
                if ($hide_by_click[$k]) {
                    if ($hide_by_click[$k] == 'hide') {
                        $number_notice--;
                    }
                }
            } else if ($v == 'dismiss') {
                $n_dismiss++;
            }
        }

        $return = array(
            'actions' => $actions,
            'number_actions' => count($actions),
            'number_active' => $n_active,
            'number_dismiss' => $n_dismiss,
            'hide_by_click'  => $hide_by_click,
            'number_notice'  => $number_notice,
        );
        if ($return['number_notice'] < 0) {
            $return['number_notice'] = 0;
        }

        return $return;
    }
}

Profipaints_Dashboard::get_instance()->init();
