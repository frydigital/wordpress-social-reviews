<?php

class Wordpress_Social_Reviews_Shortcode extends Wordpress_Social_Reviews
{

    public function __construct()
    {
        parent::__construct();
        add_shortcode('social_reviews', array($this, 'social_reviews_shortcode'));
    }

    public function social_reviews_shortcode($atts)
    {
        // pulls in the review posts from the custom post type 'social-reviews'. Atts include qty, template, and platform.
        $atts = shortcode_atts(array(
            'qty' => 3,
            'template' => 'default',
            'platform' => ''
        ), $atts);

        $args = array(
            'post_type' => 'social-reviews',
            'posts_per_page' => $atts['qty'],
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if ($atts['platform'] != '') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'platform',
                    'field' => 'slug',
                    'terms' => $atts['platform']
                )
            );
        }

        $reviews = new WP_Query($args);

        if ($reviews->have_posts()) {
            return $this->render_template($reviews, $atts['template']);
        } else {
            return 'No reviews found';
        }
    }

    public function render_template($reviews, $template)
    {
        if ($reviews) {
            ob_start();
            include(plugin_dir_path(__FILE__) . '../public/templates/loop_start.php');
            foreach ($reviews->posts as $review) {
                include(plugin_dir_path(__FILE__) . '../public/templates/' . $template . '.php');
            }
            include(plugin_dir_path(__FILE__) . '../public/templates/loop_end.php');
            return ob_get_clean();
        }
    }
}
