<?php

class Wordpress_Social_Reviews_Admin extends Wordpress_Social_Reviews
{
    public function __construct()
    {
        parent::__construct();
        add_action('admin_menu', array($this, 'social_reviews_menu'));
        add_action('admin_init', array($this, 'social_reviews_settings'));
        add_action('admin_enqueue_scripts', array($this, 'load_social_reviews_scripts'));
    }

    public function social_reviews_menu()
    {
        add_submenu_page(
            'edit.php?post_type=social-reviews',
            __('Social Reviews Settings', 'social-reviews'),
            __( 'Settings', 'social-reviews' ),
            'manage_options',
            'social-reviews-settings',
            array($this, 'social_reviews_settings_page'),
            //array($this, 'admin_js_test'),
        );
    }


    public function admin_js_test()
    {
        echo '<h2>Hello</h2>';
        echo '<div id="my-first-gutenberg-app"></div>';
    }


    public function load_social_reviews_scripts( $hook_suffix )
    {        
        $parent_menu_slug = sanitize_title( __( 'Parent Menu Title', 'parent-translation-domain' ) );

        if ( $parent_menu_slug . '_page_social-reviews-settings' !== $hook_suffix ) {
            return;
        }

        $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php' );

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

    public function social_reviews_settings()
    {
        register_setting('social-reviews-settings-group', 'social_reviews_facebook_app_id');
        register_setting('social-reviews-settings-group', 'social_reviews_facebook_app_secret');
        register_setting('social-reviews-settings-group', 'social_reviews_google_place_id');
        register_setting('social-reviews-settings-group', 'social_reviews_yelp_api_key');
        register_setting('social-reviews-settings-group', 'social_reviews_tripadvisor_location_id');
    }

    public function social_reviews_settings_page()
    {
?>
        <div class="wrap">
            <h2>Social Reviews Settings</h2>
            <form method="post" action="options.php">
                <?php settings_fields('social-reviews-settings-group'); ?>
                <?php do_settings_sections('social-reviews-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Facebook App ID</th>
                        <td><input type="text" name="social_reviews_facebook_app_id" value="<?php echo esc_attr(get_option('social_reviews_facebook_app_id')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Facebook App Secret</th>
                        <td><input type="text" name="social_reviews_facebook_app_secret" value="<?php echo esc_attr(get_option('social_reviews_facebook_app_secret')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Google Place ID</th>
                        <td><input type="text" name="social_reviews_google_place_id" value="<?php echo esc_attr(get_option('social_reviews_google_place_id')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Yelp API Key</th>
                        <td><input type="text" name="social_reviews_yelp_api_key" value="<?php echo esc_attr(get_option('social_reviews_yelp_api_key')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">TripAdvisor Location ID</th>
                        <td><input type="text" name="social_reviews_tripadvisor_location_id" value="<?php echo esc_attr(get_option('social_reviews_tripadvisor_location_id')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
<?php


    }
}
