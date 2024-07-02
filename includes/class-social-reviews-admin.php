<?php

class Wordpress_Social_Reviews_Admin extends Wordpress_Social_Reviews
{
    public function __construct()
    {
        parent::__construct();
        add_action('admin_menu', array($this, 'social_reviews_menu'));
        add_action('admin_enqueue_scripts', array($this, 'load_social_reviews_scripts'));
    }

    public function social_reviews_menu()
    {
        add_submenu_page(
            'edit.php?post_type=social-reviews',
            __('Social Reviews Settings', 'social-reviews'),
            __('Settings', 'social-reviews'),
            'manage_options',
            'social-reviews-settings',
            array($this, 'social_reviews_settings_page'),
            //array($this, 'admin_js_test'),
        );
    }

    public function load_social_reviews_scripts($hook_suffix)
    {
        $parent_menu_slug = sanitize_title(__('Parent Menu Title', 'parent-translation-domain'));

        if ($parent_menu_slug . '_page_social-reviews-settings' !== $hook_suffix) {
            return;
        }

        $asset_file = include(plugin_dir_path(__FILE__) . 'build/index.asset.php');

        foreach ($asset_file['dependencies'] as $style) {
            wp_enqueue_script($style);
        }


        wp_register_script(
            'social-reviews-admin',
            plugin_dir_url(__FILE__) . 'build/index.js',
            $asset_file['dependencies'],
            $asset_file['version'],
        );
        wp_enqueue_script('social-reviews-admin');

        wp_register_style(
            'social-reviews-admin',
            plugin_dir_url(__FILE__) . 'style.css',
            array(),
            $asset_file['version'],
        );
        wp_enqueue_style('social-reviews-admin');
    }



    public function social_reviews_settings_page()
    {
?>
        <div class="wrap">
            <h2>Social Reviews Settings</h2>

        </div>
<?php


    }
}
