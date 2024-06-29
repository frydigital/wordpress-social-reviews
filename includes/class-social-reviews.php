<?php

// Register custom post type / taxonomy

class Wordpress_Social_Reviews
{
    public function __construct()
    {
        add_action('init', array($this, 'create_social_review_posttype'));
    }



    public function create_social_review_posttype()
    {

        register_post_type(
            'social-review',
            array(
                'labels' => array(
                    'name' => __('Social Reviews'),
                    'singular_name' => __('Social Review'),
                    'add_new' => __('Add New'),
                    'add_new_item' => __('Add New Social Review'),
                    'edit_item' => __('Edit Social Review'),
                    'new_item' => __('New Social Review'),
                    'view_item' => __('View Social Review'),
                    'search_items' => __('Search Social Reviews'),
                    'not_found' => __('No Social Reviews found'),
                    'not_found_in_trash' => __('No Social Reviews found in Trash')
                ),
                'public' => true,
                'publicly_queryable' => false,
                'show_in_nav_menus' => false,
                'has_archive' => false,
                'rewrite' => false,
                'supports' => array('title', 'editor', 'custom-fields', 'taxonomies'),
                'menu_icon' => 'dashicons-star-half',
                'show_in_rest' => true,
                'taxonomies' => array('platform')
            )
        );

        register_taxonomy(
            'platform',
            'social-review',
            array(
                'labels' => array(
                    'name' => __('Platform'),
                    'singular_name' => __('Platform'),
                    'search_items' => __('Search Platforms'),
                    'all_items' => __('All Platforms'),
                    'edit_item' => __('Edit Platform'),
                    'update_item' => __('Update Platform'),
                    'add_new_item' => __('Add New Platform'),
                    'new_item_name' => __('New Platform Name'),
                    'menu_name' => __('Platform')
                ),
                'show_admin_column' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => false,
                'quick_edit' => true,
                'meta_box_cb' => 'post_categories_meta_box'
            )
        );

        add_filter('manage_social-review_posts_columns', array($this, 'social_review_columns'));
        add_action('manage_social-review_posts_custom_column', array($this, 'social_review_columns_content'), 10, 2);
    }

    public function social_review_columns($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'platform' => __('Platform'),
            'author' => __('Author'),
            'rating' => __('Rating'),
            'date' => __('Import Date')
        );
        return $columns;
    }

    public function social_review_columns_content($column, $post_id)
    {
        switch ($column) {
            case 'platform':
                $platform = get_the_terms($post_id, 'platform');
                if ($platform && !is_wp_error($platform)) {
                    echo $platform[0]->name;
                }
                break;
            case 'rating':
                $rating = get_post_meta($post_id, 'rating', true);
                echo $rating;
                break;
            case 'author':
                $author = get_post_meta($post_id, 'author', true);
                echo $author;
                break;
        }
    }

    public function generate_star_rating_logos($rating)
    {
        $rating = intval($rating);
        $output = '<span class="star-rating">';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $output .= '<img class="star star-fill" style="height: 32px;" alt="filled rating star" src="' . plugin_dir_url(__DIR__) . 'public/assets/icons/star_fill_96.png">';
            } elseif ($i - 0.5 == $rating) {
                $output .= '<img class="star star-half-fill" style="height: 32px;" alt="half filled rating star" src="' . plugin_dir_url(__DIR__) . 'public/assets/icons/star_half_96.png">';
            } else {
                $output .= '<img class="star star-empty" style="height: 32px;" alt="empty rating star" src="' . plugin_dir_url(__DIR__) . 'public/assets/icons/star_empty_96.png">';
            }
        }
        $output .= '</span>';
        return $output;
    }

    public function render_platform_logo($platform = '', $version = 'primary')
    {
        if ($platform == '' || $platform == null) {
            return;
        }
        $platform = strtolower($platform);
        $logo_file = $platform . '_' . $version . '_96.png';
        $output = '<img class="platform-logo" style="height: 32px;" alt="' . $platform . ' logo" src="' . plugin_dir_url(__DIR__) . 'public/assets/logos/' . $logo_file . '">';
        return $output;
    }
}


new Wordpress_Social_Reviews();
