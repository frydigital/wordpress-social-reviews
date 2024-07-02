<?php

class Wordpress_Social_Reviews_Taxonomies extends Wordpress_Social_Reviews
{

    public function __construct()
    {
        add_action('init', array($this, 'create_social_reviews_taxonomies'));
        add_action('platform_add_form_fields', array($this, 'platform_add_new_meta_fields'), 10, 2);
        add_action('platform_edit_form_fields', array($this, 'platform_edit_meta_fields'), 10, 2);
        add_action('created_platform', array($this, 'save_platform_meta'), 10, 2);
        add_action('edited_platform', array($this, 'update_platform_meta'), 10, 2);
    }

    public function create_social_reviews_taxonomies()
    {
        register_taxonomy(
            'platform',
            'social-reviews',
            array(
                'labels' => array(
                    'name' => __('Social Platforms'),
                    'singular_name' => __('Platform'),
                    'search_items' => __('Search Platforms'),
                    'all_items' => __('All Platforms'),
                    'edit_item' => __('Edit Platform'),
                    'update_item' => __('Update Platform'),
                    'add_new_item' => __('Add New Platform'),
                    'new_item_name' => __('New Platform Name'),
                    'menu_name' => __('Social Platforms')
                ),
                'show_admin_column' => true,
                'show_ui' => true,
                'hierarchical' => true,
                'show_in_rest' => true,
                'quick_edit' => true,
            )
        );
    }

    public function platform_add_new_meta_fields($taxonomy)
    {
?>

        <div class="form-field term-meta-wrap">
            <label for="platform_url"><?php _e('Platform URL', 'social-reviews'); ?></label>
            <input type="text" name="platform_url" id="platform_url" value="" class="term-meta-field" />
            <p class="description"><?php _e('Enter the URL for the platform.', 'social-reviews'); ?></p>
        </div>
    <?php
    }

    public function platform_edit_meta_fields($term, $taxonomy)
    {
        $platform_url = get_term_meta($term->term_id, 'platform_url', true);
    ?>


        <tr class="form-field term-meta-wrap">
            <th scope="row"><label for="platform_url"><?php _e('Platform URL', 'social-reviews'); ?></label></th>
            <td>
                <input type="text" name="platform_url" id="platform_url" value="<?php echo $platform_url; ?>" class="term-meta-field" />
                <p class="description"><?php _e('Enter the URL for the platform.', 'social-reviews'); ?></p>
            </td>
        </tr>
<?php
    }

    public function save_platform_meta($term_id, $tt_id)
    {

        if (isset($_POST['platform_url'])) {
            $platform_url = sanitize_text_field($_POST['platform_url']);
            add_term_meta($term_id, 'platform_url', $platform_url, true);
        }
    }

    public function update_platform_meta($term_id, $tt_id)
    {

        if (isset($_POST['platform_url'])) {
            $platform_url = sanitize_text_field($_POST['platform_url']);
            update_term_meta($term_id, 'platform_url', $platform_url);
        }
    }
}
