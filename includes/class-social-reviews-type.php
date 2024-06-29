<?php

// Register custom post type / taxonomy

class Wordpress_Social_Reviews
{
    public function __construct()
    {
        add_action('init', array($this, 'create_social_reviews_posttype'));
        add_action('init', array($this, 'social_reviews_register_post_meta'));
        add_action('manage_social-reviews_posts_custom_column', array($this, 'social_reviews_columns_content'), 10, 2);
        add_filter('manage_social-reviews_posts_columns', array($this, 'social_reviews_columns'));
        add_filter('use_block_editor_for_post_type', array($this, 'disable_gutenberg'), 10, 2);
    }



    public function create_social_reviews_posttype()
    {

        register_post_type(
            'social-reviews',
            array(
                'labels' => array(
                    'name' => __('Social Reviews'),
                    'singular_name' => __('Social Review'),
                    'add_new' => __('Add New Review'),
                    'add_new_item' => __('Add New Review'),
                    'edit_item' => __('Edit Review'),
                    'new_item' => __('New Review'),
                    'view_item' => __('View Review'),
                    'search_items' => __('Search Reviews'),
                    'not_found' => __('No Reviews found'),
                    'not_found_in_trash' => __('No Reviews found in Trash')
                ),
                'public' => true,
                'publicly_queryable' => false,
                'show_in_nav_menus' => false,
                'has_archive' => false,
                'rewrite' => false,
                'supports' => array('title', 'excerpt', 'custom-fields', 'taxonomies'),
                'menu_icon' => 'dashicons-star-half',
                'show_in_rest' => true,
                'taxonomies' => array('platform')
            )
        );

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
                //'meta_box_cb' => 'post_categories_meta_box'
            )
        );
    }


    public function disable_gutenberg($current_status, $post_type)
    {
        if ($post_type === 'social-reviews') return false;
        return $current_status;
    }



    public function social_reviews_columns($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'social-reviews'),
            'review_platform' => __('Platform', 'social-reviews'),
            'review_author' => __('Author', 'social-reviews'),
            'review_rating' => __('Rating', 'social-reviews'),
            'review_date' => __('Review Date', 'social-reviews'),
            'date' => __('Import Date', 'social-reviews')
        );
        return $columns;
    }

    public function social_reviews_columns_content($column, $post_id)
    {
        switch ($column) {
            case 'review_platform':
                $platform = get_the_terms($post_id, 'platform');
                if ($platform && !is_wp_error($platform)) {
                    echo $platform[0]->name;
                }
                break;
            case 'review_rating':
                $rating = get_post_meta($post_id, 'rating', true);
                echo $rating;
                break;
            case 'review_author':
                $author = get_post_meta($post_id, 'review_author', true);
                echo $author;
                break;
            case 'review_date':
                $review_date = get_post_meta($post_id, 'review_date', true);
                echo $review_date;
                break;
        }
    }

    public function social_reviews_register_post_meta()
    {
        register_post_meta('social-reviews', 'review_rating', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'integer'
        ));
        register_post_meta('social-reviews', 'review_author', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string'
        ));
        register_post_meta('social-reviews', 'review_date', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string'
        ));
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
